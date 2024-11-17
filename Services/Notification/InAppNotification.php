<?php 

class InAppNotification implements IObserver {
    private ISubject $subject;
    private $message;

    private $notificationType = "InApp";

    public function __construct(ISubject $subject) {
        $this->subject = $subject;
        $this->subject->subscribe($this, $this->notificationType);
    }

    
    // public function update($notificationType, $message) {
    //     $this->notificationType = $notificationType;
    //     $this->message = $message;
    //     if ($notificationType === "InApp") {
    //         echo "InApp Notification: $message\n";
    //     } 
    // }
    public function update($notificationType, $message) {
        // Only handle "SMS" notifications
        if ($notificationType === $this->notificationType) {
            $this->message = $message;
            echo "InApp Notification: $message\n";
        }
    }
}
