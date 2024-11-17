<?php

ob_start();
require_once "config/db-conn-setup.php";
ob_end_clean();

class Payment {
    private ?int $paymentID;
    private ?string $type;
    private ?float $amount;
    
    // Valid payment types
    private const VALID_PAYMENT_TYPES = [
        'credit_card',
        'debit_card',
        'paypal',
        'other_online'
    ];

    public function __construct(
        ?int $paymentID = null,
        ?string $type = "credit_card",
        ?float $amount = null
    ) {
        $this->paymentID = $paymentID;
        $this->type = $type;
        $this->amount = $amount;
        
        // Validate payment type
        if ($type !== null && !in_array($type, self::VALID_PAYMENT_TYPES)) {
            throw new InvalidArgumentException("Invalid payment type. Only online payment methods are allowed.");
        }
    }

    public function getPaymentID(): ?int {
        return $this->paymentID;
    }

    public function setPaymentID(int $paymentID): void {
        $this->paymentID = $paymentID;
    }

    public function getType(): ?string {
        return $this->type;
    }

    public function getAmount(): ?float {
        return $this->amount;
    }

    public function recordPayment(int $userID, int $donationID): bool {
        global $configs;
        try {
            $query = "INSERT INTO Payment (type, amount, userID, donationID) VALUES (?, ?, ?, ?)";
            $stmt = $configs->conn->prepare($query);
            $stmt->bind_param("sdii", $this->type, $this->amount, $userID, $donationID);
            
            if ($stmt->execute()) {
                // Set the paymentID after successful insertion
                $this->paymentID = $stmt->insert_id;
                return true;
            }
            return false;
        } catch (mysqli_sql_exception $e) {
            error_log("Error recording payment: " . $e->getMessage());
            return false;
        }
    }

    public function getPaymentInfo(?int $specificPaymentID = null): ?array {
        global $configs;
        try {
            $paymentIDToUse = $specificPaymentID ?? $this->paymentID;
            
            if ($paymentIDToUse === null) {
                throw new InvalidArgumentException("No payment ID provided");
            }

            $query = "SELECT p.*, u.email, d.campaign_name 
                     FROM Payment p 
                     LEFT JOIN User u ON p.userID = u.userID 
                     LEFT JOIN Donation d ON p.donationID = d.donationID 
                     WHERE p.paymentID = ?";
            
            $stmt = $configs->conn->prepare($query);
            $stmt->bind_param("i", $paymentIDToUse);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } catch (mysqli_sql_exception $e) {
            error_log("Error fetching payment info: " . $e->getMessage());
            return null;
        }
    }

    public function validatePayment(): bool {
        // Basic validation
        if ($this->amount === null || $this->amount <= 0) {
            throw new InvalidArgumentException("Invalid payment amount");
        }

        if ($this->type === null || !in_array($this->type, self::VALID_PAYMENT_TYPES)) {
            throw new InvalidArgumentException("Invalid payment type");
        }

        return true;
    }

    public static function getAllPaymentTypes(): array {
        return self::VALID_PAYMENT_TYPES;
    }
}