<?php

class SMSNotification implements IObserver {
    private $subject;

    public function __construct(ISubject $subject) {
        $this->subject = $subject;

    }
    public function update($notificationType, $message) {
        if ($notificationType === "SMS") {
            echo "SMS Notification: $message\n";
        } 
    }

}