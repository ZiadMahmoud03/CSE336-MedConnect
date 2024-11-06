<?php
class User extends Person {
    private DonationDetails $donationHistory;
    private int $nationalID;
    private Event $registeredEvents;
    private array $skills;
    private bool $isVolunteer;

    public function __construct(
        int $personID, 
        string $name, 
        string $email, 
        int $phone, 
        Address $address, 
        DonationDetails $donationHistory, 
        int $nationalID, 
        Event $registeredEvents, 
        array $skills, 
        bool $isVolunteer
    ) {
        parent::__construct($personID, $name, $email, $phone, $address);
        $this->donationHistory = $donationHistory;
        $this->nationalID = $nationalID;
        $this->registeredEvents = $registeredEvents;
        $this->skills = $skills;
        $this->isVolunteer = $isVolunteer;
    }

    // Methods matching the diagram
    public function trackDonationHistory() {}
    public function trackDonationStatus() {}
    public function setRecurringDonations() {}
    public function receiveReminder() {}
    public function fillDonationForm() {}
    public function choosePickUpOrDropOff() {}
    public function receiveNotification() {}
    
    public function signUpForEvent(Event $event) {
        $this->registeredEvents = $event; 
    }

    public function updateSkills(array $newSkills) {
        $this->skills = $newSkills; // Update skills list
    }

    public function checkAvailability() {}
}

