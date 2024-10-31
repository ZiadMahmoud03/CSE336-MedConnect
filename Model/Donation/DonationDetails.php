<?php

class DonationDetails {
    private int $donationDetailsID;
    private int $donationID;
    private int $medicineID;
    private int $equipmentID;
    private int $quantity;

    public function __construct(int $donationDetailsID, int $donationID, int $medicineID, int $equipmentID, int $quantity) {
        $this->donationDetailsID = $donationDetailsID;
        $this->donationID = $donationID;
        $this->medicineID = $medicineID;
        $this->equipmentID = $equipmentID;
        $this->quantity = $quantity;
    }

    public function getDetails() {}
}

?>