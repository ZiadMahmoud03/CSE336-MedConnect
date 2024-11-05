<?php

class HospitalAdmin extends Person {
    private int $hospitalID;

    public function __construct(int $personID, string $name, string $email, int $phone, Address $address, int $hospitalID) {
        parent::__construct($personID, $name, $email, $phone, $address);
        $this->hospitalID = $hospitalID;
    }

    public function uploadRequiredItems() {}
    public function notifyExpiringMedicine() {}
    public function manageItems() {}
    public function updateDonationRequest() {}
    public function reviewDonation() {}
    public function receiveNotification() {}
}

?>