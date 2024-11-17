<?php

ob_start();
require_once "config/db-conn-setup.php";
require_once "Donate.php";
ob_end_clean();

class BasicDonation implements Donate {
    private ?int $donationID;
    private ?int $medicineID;
    private ?int $quantity;
    private string $urgencyLevel;

    private const URGENCY_LEVELS = ['low', 'medium', 'high'];

    public function __construct(
        ?int $donationID = null, 
        ?int $medicineID = null, 
        ?int $quantity = null, 
        string $urgencyLevel = 'low'
    ) {
        $this->donationID = $donationID;
        $this->medicineID = $medicineID;
        $this->quantity = $quantity;

        // Validate and set the urgency level
        if (!in_array($urgencyLevel, self::URGENCY_LEVELS)) {
            throw new InvalidArgumentException("Invalid urgency level. Allowed values: " . implode(', ', self::URGENCY_LEVELS));
        }
        $this->urgencyLevel = $urgencyLevel;
    }

    public function makeDonation() {
        // Implementation for making a donation
    }

    // Function to calculate urgency based on urgency level and quantity
    public function calculateImpact(): float {
        $urgencyFactors = [
            'low' => 1.0,
            'medium' => 1.5,
            'high' => 2.0
        ];

        $urgencyFactor = $urgencyFactors[$this->urgencyLevel];
        return ($this->quantity ?? 0) * $urgencyFactor;
    }

    // Getters and setters for urgency level
    public function getUrgencyLevel(): string {
        return $this->urgencyLevel;
    }

    public function setUrgencyLevel(string $urgencyLevel): void {
        
    }
}


