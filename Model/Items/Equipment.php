<?php

class Equipment extends Item {
    private string $condition;

    public function __construct(int $itemID, string $name, int $quantityAvailable, string $condition) {
        parent::__construct($itemID, $name, $quantityAvailable);
        $this->condition = $condition;
    }

    public function checkAvailability() {}
    public function checkCondition() {}
}

?>