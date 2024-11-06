<?php
class EmailNotification implements IObserver {
    private $subject;

    public function __construct(ISubject $subject) {
        $this->subject = $subject;
        $this->subject->subscribe($this);  // Subscribe this observer to the subject
    }

    public function update($notificationType, $message) {
        // Check if the notification type is 'email'
        if ($notificationType == 'email') {
            // Set the recipient's email
            $to = 'recipient@example.com';  
    
            // Subject of the email
            $subject = 'Class Canceled';  // You can adjust this based on your requirements
    
            // Prepare email headers
            $headers = 'From: sender@example.com';
    
            // Send the email
            if (mail($to, $subject, $message, $headers)) {
                echo "Email sent: $subject - $message\n";
            } else {
                echo "Failed to send email.\n";
            }
        } else {
            echo "Invalid notification type.\n"; // Handle other notification types if needed
        }
    }
    
}
