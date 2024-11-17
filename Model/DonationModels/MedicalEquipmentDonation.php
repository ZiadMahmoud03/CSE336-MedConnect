<?php

class MedicalEquipmentDonation extends DonationDecorator {
    private array $equipmentList;

    public function __construct(Donate $wrappedDonation, array $equipmentList) {
        parent::__construct($wrappedDonation);
        $this->equipmentList = $equipmentList;
    }

    public function makeDonation() {}
}

?>