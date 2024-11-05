<?php
class Donor extends Person {
    private DonationDetails $donationHistory;
    private int $nationalID;

    public function __construct(int $personID, string $name, string $email, int $phone, Address $address, DonationDetails $donationHistory, int $nationalID) {
        parent::__construct($personID, $name, $email, $phone, $address);
        $this->donationHistory = $donationHistory;
        $this->nationalID = $nationalID;
    }

    public function trackDonationHistory() {}
    public function trackDonationStatus() {}
    public function setRecurringDonations() {}
    public function receiveReminder() {}
    public function fillDonationForm() {}
    public function choosePickUpOrDropOff() {}
    public function receiveNotification() {}
}

?>