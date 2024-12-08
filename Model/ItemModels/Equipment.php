<?php

ob_start();
require_once "../config/db-conn-setup.php";
ob_end_clean();

class Equipment extends Item {
    private ?string $condition;
    private ?int $equipmentID;

    public function __construct( 
        ?int $equipmentID = null, 
        ?int $itemID = null, ?string $name = null, 
        ?int $quantityAvailable = null, 
        ?string $condition = null, 
        ?string $description = null 
    ) { 
        parent::__construct($itemID ?? 0, $name ?? "", $quantityAvailable ?? 0, $description ?? ""); 
        $this->condition = $condition ?? ""; 
        $this->equipmentID = $equipmentID ?? 0; 
    }
    
    public function insertEquipment(): bool {
        try {
            $itemID = $this->getOrCreateItemID(); // Check or create the item in the Item table
        
            // Get the database connection
            $conn = Database::getInstance();
        
            // Insert the equipment into the Equipment table
            $query = "INSERT INTO Equipment
                      (equipment_condition, item_id) VALUES (?, ?)";
        
            $stmt = $conn->prepare($query); // Use $conn, not $configs->conn
            $stmt->bind_param("si", $this->condition, $itemID);
            $stmt->execute();
        
            if ($stmt->affected_rows > 0) {
                $this->equipmentID = $stmt->insert_id; // Get the new equipment ID
                return true;
            }
        
            return false;
        } catch (mysqli_sql_exception $e) {
            error_log("Database error in insertEquipment: " . $e->getMessage());
            throw new Exception("Error inserting new equipment");
        }
    }
    

    public function checkAvailability(): bool {
        try {
            // Get the database connection
            $conn = Database::getInstance();
    
            // Use prepared statement to prevent SQL injection
            $query = "SELECT i.quantity_available 
                      FROM Item i 
                      JOIN Equipment m ON i.item_id = m.item_id 
                      WHERE m.equipment_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $this->equipmentID);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result && $row = $result->fetch_assoc()) {
                return $row['quantity_available'] > 0;
            }
            return false;
        } catch (mysqli_sql_exception $e) {
            error_log("Database error in checkAvailability: " . $e->getMessage());
            throw new Exception("Error checking equipment availability");
        }
    }
    
    public function checkCondition(): string {
        try {
            // Get the database connection
            $conn = Database::getInstance();
    
            $query = "SELECT `equipment_condition` 
                      FROM Equipment 
                      WHERE equipment_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $this->equipmentID);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result && $row = $result->fetch_assoc()) {
                $this->condition = $row['equipment_condition'];
                return $this->condition ?: "Condition not set";
            }
            return "Error retrieving condition";
        } catch (mysqli_sql_exception $e) {
            error_log("Database error in checkCondition: " . $e->getMessage());
            throw new Exception("Error checking equipment condition");
        }
    }
    

    public function getDescription(): string {
        try {
            // Get the database connection
            $conn = Database::getInstance();
    
            $query = "SELECT i.description 
                      FROM Item i 
                      JOIN Equipment e ON i.item_id = e.item_id 
                      WHERE e.equipment_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $this->equipmentID);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result && $row = $result->fetch_assoc()) {
                return $row['description'] ?: "No description available.";
            }
    
            return "Description not found.";
        } catch (mysqli_sql_exception $e) {
            error_log("Database error in getDescription: " . $e->getMessage());
            throw new Exception("Error fetching equipment description");
        }
    }
    

    // Getters and setters
    public function getCondition(): string {
        return $this->condition;
    }

    public function setCondition(string $condition): void {
        $this->condition = $condition;
    }

    public function getEquipmentID(): int {
        return $this->equipmentID;
    }
}