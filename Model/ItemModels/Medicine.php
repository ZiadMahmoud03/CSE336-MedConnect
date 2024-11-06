<?php

ob_start();
require_once "config/db-conn-setup.php";
ob_end_clean();

class Medicine extends Item {
    private string $expiryDate;
    private int $medicineID;

    public function __construct(int $medicineID, int $itemID, string $name, int $quantityAvailable, string $expiryDate) {
        parent::__construct($itemID, $name, $quantityAvailable);
        
        // Validate expiry date format
        if (!$this->isValidDate($expiryDate)) {
            throw new InvalidArgumentException("Invalid expiry date format. Expected Y-m-d format.");
        }
        
        $this->expiryDate = $expiryDate;
        $this->medicineID = $medicineID;
    }

    public function checkAvailability(): bool {
        global $configs;

        try {
            // Use prepared statement to prevent SQL injection
            $query = "SELECT i.quantity_available 
                      FROM {$configs->DB_NAME}.Item i 
                      JOIN {$configs->DB_NAME}.Medicine m ON i.item_id = m.item_id 
                      WHERE m.medicine_id = ?";
                      
            $stmt = $configs->conn->prepare($query);
            $stmt->bind_param("i", $this->medicineID); // Fixed: using medicineID instead of itemID
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $row = $result->fetch_assoc()) {
                $isNotExpired = strtotime($this->expiryDate) > time();
                return ($row['quantity_available'] > 0 && $isNotExpired);
            }
            return false;
        } catch (mysqli_sql_exception $e) {
            error_log("Database error in checkAvailability: " . $e->getMessage());
            throw new Exception("Error checking medicine availability");
        }
    }

    public function checkExpiry(): array {
        global $configs;
    
        try {
            $query = "SELECT expiry_date 
                      FROM {$configs->DB_NAME}.Medicine 
                      WHERE medicine_id = ?";
                      
            $stmt = $configs->conn->prepare($query);
            $stmt->bind_param("i", $this->medicineID);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result && $row = $result->fetch_assoc()) {
                $this->expiryDate = $row['expiry_date'];
                
                if (!$this->expiryDate) {
                    return [
                        'status' => 'unknown',
                        'message' => 'Expiry date not set',
                        'days_remaining' => null
                    ];
                }
                
                $expiryTimestamp = strtotime($this->expiryDate);
                $currentTimestamp = time();
                $daysRemaining = floor(($expiryTimestamp - $currentTimestamp) / (60 * 60 * 24));
                
                if ($expiryTimestamp < $currentTimestamp) {
                    return [
                        'status' => 'expired',
                        'message' => 'Expired',
                        'days_remaining' => $daysRemaining
                    ];
                } else {
                    return [
                        'status' => 'valid',
                        'message' => 'Not expired',
                        'days_remaining' => $daysRemaining
                    ];
                }
            }
            
            return [
                'status' => 'error',
                'message' => 'Error retrieving expiry date',
                'days_remaining' => null
            ];
            
        } catch (mysqli_sql_exception $e) {
            error_log("Database error in checkExpiry: " . $e->getMessage());
            throw new Exception("Error checking medicine expiry");
        }
    }

    // Helper method to validate date format
    private function isValidDate(string $date): bool {
        $datetime = DateTime::createFromFormat('Y-m-d', $date);
        return $datetime && $datetime->format('Y-m-d') === $date;
    }

    // Getters and setters
    public function getExpiryDate(): string {
        return $this->expiryDate;
    }

    public function getMedicineID(): int {
        return $this->medicineID;
    }

    // Method to check if medicine is near expiry
    public function isNearExpiry(int $thresholdDays = 30): bool {
        $expiryTimestamp = strtotime($this->expiryDate);
        $currentTimestamp = time();
        $daysRemaining = floor(($expiryTimestamp - $currentTimestamp) / (60 * 60 * 24));
        
        return $daysRemaining > 0 && $daysRemaining <= $thresholdDays;
    }
}