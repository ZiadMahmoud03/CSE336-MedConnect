<?php

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

    abstract public function checkAvailability(); 

    abstract public function getDescription(): string;
}
