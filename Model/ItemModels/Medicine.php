<?php

ob_start();
require_once "../config/db-conn-setup.php";
ob_end_clean();

class Medicine extends Item {

    private ?string $expiryDate;
    private ?int $medicineID;

    public function __construct(
        ?int $medicineID = null, 
        ?int $itemID = null, 
        ?string $name = null, 
        ?int $quantityAvailable = null, 
        ?string $expiryDate = null, 
        ?string $description = null
    ) { 
        parent::__construct($itemID ?? 0, $name ?? "", $quantityAvailable ?? 0, $description ?? "");
    
        // Validate and set expiryDate
        if ($expiryDate !== null && !$this->isValidDate($expiryDate)) { 
            throw new InvalidArgumentException("Invalid expiry date format. Expected Y-m-d format."); 
        } 
        $this->expiryDate = $expiryDate;
    
        $this->medicineID = $medicineID ?? 0; 
    }

    public function insertMedicine(): bool {
        try {
            $itemID = $this->getOrCreateItemID(); // Check or create the item in the Item table
    
            // Get the database connection
            $conn = Database::getInstance();
    
            // Insert the medicine into the Medicine table
            $query = "INSERT INTO Medicine (expiry_date, item_id) VALUES (?, ?)";
            $stmt = $conn->prepare($query); // Use $conn, not $configs->conn
            $stmt->bind_param("si", $this->expiryDate, $itemID);
            $stmt->execute();
    
            if ($stmt->affected_rows > 0) {
                $this->medicineID = $stmt->insert_id; // Get the new medicine ID
                return true;
            }
    
            return false;
        } catch (mysqli_sql_exception $e) {
            error_log("Database error in insertMedicine: " . $e->getMessage());
            throw new Exception("Error inserting new medicine");
        }
    }
       
    public function checkAvailability(): bool {
        try {
            // Get the database connection
            $conn = Database::getInstance();
    
            // Use prepared statement to prevent SQL injection
            $query = "SELECT i.quantity_available 
                      FROM Item i 
                      JOIN Medicine m ON i.item_id = m.item_id 
                      WHERE m.medicine_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $this->medicineID);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result && $row = $result->fetch_assoc()) {
                // Check if the medicine is not expired
                $isNotExpired = strtotime($this->expiryDate) > time();
                return $row['quantity_available'] > 0 && $isNotExpired;
            }
            return false;
        } catch (mysqli_sql_exception $e) {
            error_log("Database error in checkAvailability: " . $e->getMessage());
            throw new Exception("Error checking medicine availability");
        }
    }
    
    public function checkExpiry(): array {
        try {
            // Get the database connection
            $conn = Database::getInstance();
    
            $query = "SELECT expiry_date FROM Medicine WHERE medicine_id = ?";
            $stmt = $conn->prepare($query);
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
    

    public function getDescription(): string {
        try {
            // Get the database connection
            $conn = Database::getInstance();
    
            // SQL query to fetch the description from the database
            $query = "SELECT i.description 
                      FROM Item i 
                      JOIN Medicine m ON i.item_id = m.item_id 
                      WHERE m.medicine_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $this->medicineID);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result && $row = $result->fetch_assoc()) {
                return $row['description'] ?: "No description available.";
            }
    
            return "Description not found.";
        } catch (mysqli_sql_exception $e) {
            error_log("Database error in getDescription: " . $e->getMessage());
            throw new Exception("Error fetching medicine description");
        }
    }
    

    public function updateField(string $field, $value): bool {
        try {
            // Validate the field name to prevent SQL injection
            $validFields = ['name', 'description', 'expiry_date', 'quantity_available'];
            if (!in_array($field, $validFields)) {
                throw new Exception("Invalid field name: $field");
            }
    
            // Get the database connection
            $conn = Database::getInstance();
    
            // SQL query to update the field
            $query = "UPDATE Item i 
                      JOIN Medicine m ON i.item_id = m.item_id 
                      SET i.$field = ? 
                      WHERE m.medicine_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("si", $value, $this->medicineID);
            $stmt->execute();
    
            return $stmt->affected_rows > 0;
        } catch (mysqli_sql_exception $e) {
            error_log("Database error in updateField: " . $e->getMessage());
            throw new Exception("Error updating field $field");
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

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    // Method to check if medicine is near expiry
    public function isNearExpiry(int $thresholdDays = 30): bool {
        $expiryTimestamp = strtotime($this->expiryDate);
        $currentTimestamp = time();
        $daysRemaining = floor(($expiryTimestamp - $currentTimestamp) / (60 * 60 * 24));
        
        return $daysRemaining > 0 && $daysRemaining <= $thresholdDays;
    }
}


