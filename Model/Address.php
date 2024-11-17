<?php

ob_start();
require_once "config/db-conn-setup.php";  // Database connection setup
ob_end_clean();  

class Address {
    private ?int $addressID;
    private ?string $name;
    private ?int $parentID;


    public function __construct(?int $addressID = null, ?string $name = null, ?int $parentID = null) {
        $this->addressID = $addressID;
        $this->name = $name;
        $this->parentID = $parentID;
    }

    // Getters
    public function getAddressID(): ?int {
        return $this->addressID;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function getParentID(): ?int {
        return $this->parentID;
    }

    // Setters
    public function setAddressID(?int $addressID): void {
        $this->addressID = $addressID;
    }

    public function setName(?string $name): void {
        $this->name = $name;
    }

    public function setParentID(?int $parentID): void {
        $this->parentID = $parentID;
    }

    // Save address to the database (insert or update)
    public function save(): bool {
        if ($this->addressID === null) {
            
            $query = "INSERT INTO Address (name, parent_id) VALUES ('{$this->name}', '{$this->parentID}')";
            return run_query($query);
        } else {
            
            $query = "UPDATE Address SET name = '{$this->name}', parent_id = '{$this->parentID}' WHERE address_id = {$this->addressID}";
            return run_query($query);
        }
    }

    // Fetch address by ID
    public static function findByID(int $addressID): ?Address {
        $query = "SELECT * FROM Address WHERE address_id = {$addressID}";
        $result = run_select_query($query);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new Address($row['address_id'], $row['name'], $row['parent_id']);
        }
        return null;
    }

    // Fetch all addresses
    public static function findAll(): array {
        $query = "SELECT * FROM Address";
        $result = run_select_query($query);
        $addresses = [];

        while ($row = $result->fetch_assoc()) {
            $addresses[] = new Address($row['address_id'], $row['name'], $row['parent_id']);
        }
    
        return $addresses;
    }
}
?>
