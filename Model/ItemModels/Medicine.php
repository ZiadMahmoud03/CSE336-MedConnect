<?php

ob_start();
require_once "01-db-conn-setup.php";
ob_end_clean();

class Medicine extends Item {
    private string $expiryDate;
    private int $medicineID;

    public function __construct(int $medicineID,int $itemID, string $name, int $quantityAvailable, string $expiryDate) {
        parent::__construct($itemID, $name, $quantityAvailable);
        $this->expiryDate = $expiryDate;
        $this->medicineID = $medicineID;
    }

    public function checkAvailability(): bool {
        global $configs;

        // Query to check quantity available from Item based on item_id
        $query = "SELECT i.quantity_available 
                  FROM $configs->DB_NAME.Item i 
                  JOIN $configs->DB_NAME.Medicine m ON i.item_id = m.item_id 
                  WHERE m.medicine_id = $this->itemID";
        $result = run_select_query($query);

        if ($result && $row = $result->fetch_assoc()) {
            return $row['quantity_available'] > 0;
        } else {
            return false;
        }
    }

    public function checkExpiry() {
        global $configs;
    
        // Query to fetch expiry date for this medicine ID
        $query = "SELECT expiry_date FROM $configs->DB_NAME.Medicine WHERE medicine_id = $this->medicineID";
        $result = run_select_query($query);
    
        if ($result && $row = $result->fetch_assoc()) {
            // Update the class attribute with the fetched expiry date
            $this->expiryDate = $row['expiry_date'];
    
            // Now, use the updated $expiryDate to determine if the medicine is expired
            if (!$this->expiryDate) {
                return "Expiry date not set";
            } else {
                return (strtotime($this->expiryDate) < time()) ? "Expired" : "Not expired";
            }
        } else {
            return "Error retrieving expiry date"; // Handle the error as needed
        }
    }
    
}
