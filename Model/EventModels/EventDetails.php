<?php

class EventDetails {
    private int $eventDetailsID;
    private int $eventID;
    private int $volunteerID;
    private string $attendance;

    public function __construct(int $eventDetailsID, int $eventID, int $volunteerID, string $attendance) {
        $this->eventDetailsID = $eventDetailsID;
        $this->eventID = $eventID;
        $this->volunteerID = $volunteerID;
        $this->attendance = $attendance;
    }

    // Method to retrieve event details
    public function getDetails(): array {
        // Code to retrieve and return event details
        return [
            "eventDetailsID" => $this->eventDetailsID,
            "eventID" => $this->eventID,
            "volunteerID" => $this->volunteerID,
            "attendance" => $this->attendance
        ];
    }

    // Getters and Setters for private attributes (optional)
    public function getEventDetailsID(): int {
        return $this->eventDetailsID;
    }

    public function getEventID(): int {
        return $this->eventID;
    }

    public function getVolunteerID(): int {
        return $this->volunteerID;
    }

    public function getAttendance(): string {
        return $this->attendance;
    }
}

?>