<?php

ob_start();
require_once "../config/db-conn-setup.php";
ob_end_clean();

abstract class Item {
    protected ?int $itemID;
    protected ?string $name;
    protected ?int $quantityAvailable;
    protected ?string $description;

    public function __construct(
        ?int $itemID = null, 
        ?string $name = null, 
        ?int $quantityAvailable = null, 
        ?string $description = null
    ) {
        $this->itemID = $itemID;
        $this->name = $name;
        $this->quantityAvailable = $quantityAvailable;
        $this->description = $description;
    }

    // Abstract methods to be implemented by child classes
    abstract public function checkAvailability(): bool;

    abstract public function getDescription(): string;

    // Getter methods
    public function getName(): string {
        return $this->name ?? '';
    }

    public function getQuantityAvailable(): int {
        return $this->quantityAvailable ?? 0;
    }

    public function getItemID(): ?int {
        return $this->itemID;
    }

    public function getDescriptionValue(): string {
        return $this->description ?? '';
    }

    // Protected function for getting or creating the item ID
    protected function getOrCreateItemID(): int {
        // Get the database connection
        $conn = Database::getInstance(); 
    
        // Define table name directly or use constants
        $itemTable = 'Item'; // Or use $configs->DB_ITEM_TABLE if passed correctly
        
        try {
            // Check if the item already exists
            $queryCheck = "SELECT item_id FROM $itemTable WHERE name = ?";
            $stmtCheck = $conn->prepare($queryCheck);
            $name = $this->getName();
            $stmtCheck->bind_param("s", $name);
            $stmtCheck->execute();
            $resultCheck = $stmtCheck->get_result();
    
            if ($resultCheck && $row = $resultCheck->fetch_assoc()) {
                return $row['item_id'];
            }
    
            // Insert the new item
            $queryInsert = "INSERT INTO $itemTable (name, quantity_available, description) VALUES (?, ?, ?)";
            $stmtInsert = $conn->prepare($queryInsert);
            $quntity = $this->getQuantityAvailable();
            $description = $this->getDescriptionValue();
            $stmtInsert->bind_param("sis", $name, $quntity, $description);
            $stmtInsert->execute();
    
            if ($stmtInsert->affected_rows > 0) {
                return $stmtInsert->insert_id;
            }
    
            throw new Exception("Error creating new item.");
        } catch (mysqli_sql_exception $e) {
            error_log("Database error: " . $e->getMessage());
            throw new Exception("Database operation failed.");
        }
    }
    
}
