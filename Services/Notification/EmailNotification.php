<?php

require_once 'IObserver.php';

class EmailNotification implements IObserver {
    private Isubject $subject;
    private $message;

    private $notificationType = "Email";
    public function __construct(ISubject $subject) {
        $this->subject = $subject;
        $this->subject->subscribe($this, $this->notificationType);
    }

    // public function update($notificationType, $message) {
    //     $this->notificationType = $notificationType;
    //     $this->message = $message;
    //     if ($notificationType === "Email") {
    //         echo "Email Notification: $message\n";
    //     } 
    // }
    public function update($notificationType, $message) {
        // Only handle "SMS" notifications
        if ($notificationType === $this->notificationType) {
            $this->message = $message;
            echo "Email Notification: $message\n";
        }
    }
}
