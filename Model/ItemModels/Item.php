<?php

abstract class Item {
    protected int $itemID;
    protected string $name;
    protected int $quantityAvailable;

    public function __construct(int $itemID, string $name, int $quantityAvailable) {
        $this->itemID = $itemID;
        $this->name = $name;
        $this->quantityAvailable = $quantityAvailable;
    }

    abstract public function checkAvailability(); 
}

