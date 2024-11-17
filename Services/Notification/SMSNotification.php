<?php

class SMSNotification implements IObserver {
    private ISubject $subject;
    private $message;
    private $notificationType = "SMS";

    public function __construct(ISubject $subject) {
        $this->subject = $subject;
        $this->subject->subscribe($this, $this->notificationType);
    }

    // Update method to handle notifications of type "SMS"
    public function update($notificationType, $message) {
        if ($notificationType === $this->notificationType) {
            $this->message = $message;
            echo "SMS Notification: $message\n";
        }
    }
}
