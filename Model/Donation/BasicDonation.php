<?php

class BasicDonation implements Donate {
    private int $donationID;
    private int $medicineID;
    private int $quantity;

    public function __construct(int $donationID, int $medicineID, int $quantity) {
        $this->donationID = $donationID;
        $this->medicineID = $medicineID;
        $this->quantity = $quantity;
    }

    public function makeDonation() {}
}

?>