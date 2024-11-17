<?php

ob_start();
require_once "config/db-conn-setup.php";
require_once "Donate.php";
ob_end_clean();

class BasicDonation implements Donate {
    private ?int $donationID;
    private ?int $userID;
    private ?float $amount;
    
    private string $urgencyLevel;
    
    private const URGENCY_LEVELS = ['low', 'medium', 'high'];


    public function __construct(
        ?int $donationID = null,
        ?int $userID = null,
        ?float $amount = null,
        string $urgencyLevel = 'low'
    ) {
        $this->donationID = $donationID;
        $this->userID = $userID;
        $this->amount = $amount;
        

        // Validate urgency level
        if (!in_array($urgencyLevel, self::URGENCY_LEVELS)) {
            throw new InvalidArgumentException("Invalid urgency level. Allowed values: " . implode(', ', self::URGENCY_LEVELS));
        }
        $this->urgencyLevel = $urgencyLevel;
    }

    public function makeDonation(): bool {
        global $configs;
        try {
            $query = "INSERT INTO Donation (userID, amount, urgencyLevel) 
                     VALUES (?, ?, ?, ?, ?)";
            $stmt = $configs->conn->prepare($query);
            $stmt->bind_param("idsss", 
                $this->userID, 
                $this->amount, 
                $this->urgencyLevel
            );

            if ($stmt->execute()) {
                $this->donationID = $stmt->insert_id;
                return true;
            }
            return false;
        } catch (mysqli_sql_exception $e) {
            error_log("Error creating donation: " . $e->getMessage());
            return false;
        }
    }

    public function calculateImpact(): float {
        $urgencyFactors = [
            'low' => 1.0,
            'medium' => 1.5,
            'high' => 2.0
        ];

        return ($this->amount ?? 0) * $urgencyFactors[$this->urgencyLevel];
    }

    public function getDonationID(): ?int {
        return $this->donationID;
    }

    public function getUrgencyLevel(): string {
        return $this->urgencyLevel;
    }


}
