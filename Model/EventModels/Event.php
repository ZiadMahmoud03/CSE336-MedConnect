<?php

class Event {
    private int $eventID;
    private string $name;
    private DateTime $date;
    private string $location;
    private string $description;
    private array $volunteerList = []; // Assuming a list of volunteer IDs or volunteer objects

    public function __construct(int $eventID, string $name, DateTime $date, string $location, string $description) {
        $this->eventID = $eventID;
        $this->name = $name;
        $this->date = $date;
        $this->location = $location;
        $this->description = $description;
    }

    // Method to create a new event
    public function createEvent() {
        // Code to create an event in the database
    }

    // Method to update the event
    public function updateEvent() {
        // Code to update event details in the database
    }

    // Method to delete the event
    public function deleteEvent() {
        // Code to delete the event from the database
    }

    // Method to notify volunteers about the event
    public function notifyVolunteers() {
        foreach ($this->volunteerList as $volunteer) {
            // Code to send notification to each volunteer
        }
    }

    // Getters and Setters for private attributes (optional)
    public function getEventID(): int {
        return $this->eventID;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getDate(): DateTime {
        return $this->date;
    }

    public function getLocation(): string {
        return $this->location;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getVolunteerList(): array {
        return $this->volunteerList;
    }
}

?>