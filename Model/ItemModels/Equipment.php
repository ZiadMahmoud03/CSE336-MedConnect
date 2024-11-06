<?php

ob_start();
require_once "01-db-conn-setup.php";
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

        // Query to check quantity available from Item based on item_id
        $query = "SELECT i.quantity_available 
                  FROM $configs->DB_NAME.Item i 
                  JOIN $configs->DB_NAME.Equipment m ON i.item_id = m.item_id 
                  WHERE m.equipment_id = $this->equipmentID";
        $result = run_select_query($query);

        if ($result && $row = $result->fetch_assoc()) {
            return $row['quantity_available'] > 0;
        } else {
            return false; // Or handle the error as needed
        }
    }

    public function checkCondition() {
        global $configs;

        // Fixing the variable reference here
        $query = "SELECT `equipment_condition` FROM $configs->DB_NAME.Equipment WHERE equipment_id = $this->equipmentID";
        $result = run_select_query($query);

        if ($result && $row = $result->fetch_assoc()) {
            $this->condition = $row['equipment_condition'];
            return $this->condition ?: "Condition not set";
        } else {
            return "Error retrieving condition"; 
        }
    }
}
