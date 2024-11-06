<?php

class SMSNotification implements IObserver {
    private $subject;

    public function __construct(ISubject $subject) {
        $this->subject = $subject;
        $this->subject->subscribe($this);  // Subscribe this observer to the subject
    }
    public function update($notificationType, $message) {
        if ($notificationType == "SMS") {
            echo "SMS Notification: " . $message . "\n";
        }
    }

}