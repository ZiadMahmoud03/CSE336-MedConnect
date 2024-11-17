<?php

class MediumUrgencyDonation extends DonationDecorator {
    private float $amount;

    public function __construct(Donate $wrappedDonation, float $amount) {
        parent::__construct($wrappedDonation);
        $this->amount = $amount;
    }

    // Implement the abstract method calculateImpact
    public function calculateImpact(): float {
        // Calculate the base impact from the wrapped donation

        return 2.0;
    }


}