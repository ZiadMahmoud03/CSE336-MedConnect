<?php

ob_start();
require_once "config/db-conn-setup.php";
ob_end_clean();

class Equipment extends Item {
    private string $condition;
    private int $equipmentID;

    public function __construct(int $equipmentID, int $itemID, string $name, int $quantityAvailable, string $condition) {
        parent::__construct($itemID, $name, $quantityAvailable);
        $this->condition = $condition;
        $this->equipmentID = $equipmentID;
    }

    public function checkAvailability(): bool {
        global $configs;
        
        try {
            // Use prepared statement to prevent SQL injection
            $query = "SELECT i.quantity_available 
                      FROM {$configs->DB_NAME}.Item i 
                      JOIN {$configs->DB_NAME}.Equipment m ON i.item_id = m.item_id 
                      WHERE m.equipment_id = ?";
                      
            $stmt = $configs->conn->prepare($query);
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
        global $configs;
        
        try {
            $query = "SELECT `equipment_condition` 
                      FROM {$configs->DB_NAME}.Equipment 
                      WHERE equipment_id = ?";
                      
            $stmt = $configs->conn->prepare($query);
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