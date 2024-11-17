<?php

class VolunteerDetails {
    private int $volunteerID;
    private int $eventID;
    private int $hours;

    public function __construct(int $volunteerID, int $eventID, int $hours) {
        $this->volunteerID = $volunteerID;
        $this->eventID = $eventID;
        $this->hours = $hours;
    }

    // Method to retrieve volunteer details
    public function getDetails(): array {
        // Code to retrieve and return volunteer details
        return [
            "volunteerID" => $this->volunteerID,
            "eventID" => $this->eventID,
            "hours" => $this->hours
        ];
    }

    // Getters and Setters for private attributes (optional)
    public function getVolunteerID(): int {
        return $this->volunteerID;
    }

    public function getEventID(): int {
        return $this->eventID;
    }

    public function getHours(): int {
        return $this->hours;
    }
}

?>
