<?php

class Medicine extends Item {
    private string $expiryDate;

    public function __construct(int $itemID, string $name, int $quantityAvailable, string $expiryDate) {
        parent::__construct($itemID, $name, $quantityAvailable);
        $this->expiryDate = $expiryDate;
    }

    public function checkAvailability() {}
    public function checkExpiry() {}
}

?>