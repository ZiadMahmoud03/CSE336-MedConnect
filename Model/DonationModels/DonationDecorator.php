<?php

abstract class DonationDecorator implements Donate {
    protected Donate $wrappedDonation;

    public function __construct(Donate $wrappedDonation) {
        $this->wrappedDonation = $wrappedDonation;
    }

    abstract public function makeDonation();
}

?>

