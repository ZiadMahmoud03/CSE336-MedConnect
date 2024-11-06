<?php 

class InAppNotification implements IObserver {
    private $subject;

    public function __construct(ISubject $subject) {
        $this->subject = $subject;
    }

    
    public function update($notificationType, $message) {
        if ($notificationType === "InApp") {
            echo "InApp Notification: $message\n";
        } 
    }
}
