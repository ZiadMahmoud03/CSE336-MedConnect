<?php 

class InAppNotificationObserver implements IObserver {
    private $subject;

    public function __construct(ISubject $subject) {
        $this->subject = $subject;
        $this->subject->subscribe($this);  // Subscribe this observer to the subject
    }

    public function update($notificationType, $message) {
        // Store the notification in the database
        //addNotificationToDatabase($notificationType, $message);
        
        // Output the notification (you can trigger an AJAX request to update the UI)
        echo "In-App Notification: $message\n";
    }
}
