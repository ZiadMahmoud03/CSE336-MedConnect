<?php

require_once 'IObserver.php';

class EmailNotification implements IObserver {
    private $subject;

    public function __construct(ISubject $subject) {
        $this->subject = $subject;
    }

    public function update($notificationType, $message) {
        if ($notificationType === "Email") {
            echo "Email Notification: $message\n";
        } 
    }
    
}
