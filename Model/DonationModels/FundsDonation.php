<?php

class FundsDonation extends DonationDecorator {
    private float $amount;

    public function __construct(Donate $wrappedDonation, float $amount) {
        parent::__construct($wrappedDonation);
        $this->amount = $amount;
    }

    public function makeDonation() {}
}

?>