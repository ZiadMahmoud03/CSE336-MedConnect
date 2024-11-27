<?php
ob_start();
require_once "config/db-conn-setup.php";
require_once "../Model/DonationModels/Donate.php";
ob_end_clean();
abstract class DonationDecorator implements Donate {
    protected Donate $wrappedDonation;

    public function __construct(Donate $wrappedDonation) {
        $this->wrappedDonation = $wrappedDonation;
    }

    public function makeDonation() {
        $this->wrappedDonation->makeDonation();
    }

    abstract public function calculateImpact();
}



