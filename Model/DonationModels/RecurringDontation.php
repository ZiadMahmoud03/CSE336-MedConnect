<?php

class RecurringDonation extends DonationDecorator {
    private int $frequency;

    public function __construct(Donate $wrappedDonation, int $frequency) {
        parent::__construct($wrappedDonation);
        $this->frequency = $frequency;
    }

    public function makeDonation() {}
}

?>