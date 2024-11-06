<?php
require_once 'NotificationSubject.php';
require_once 'EmailNotification.php';
require_once 'SMSNotification.php';
require_once "InAppNotification.php";

// Step 1: Create the subject
$subject = new NotificationSubject();

// Step 2: Create observers (SMS, Email, InApp)
$emailObserver = new EmailNotification($subject);
$smsObserver = new SMSNotification($subject);
$inAppObserver = new InAppNotification($subject);

// Step 3: Subscribe observers to the subject
$subject->subscribe($emailObserver);
$subject->subscribe($smsObserver);
$subject->subscribe($inAppObserver);

// Step 4: Notify observers with different types of messages
echo "Notifying observers with different types:\n";

// Send an SMS notification
$subject->notifySubscribers("SMS", "This is an SMS notification");

// Send an Email notification
$subject->notifySubscribers("Email", "This is an Email notification");

// Send an In-App notification
$subject->notifySubscribers("InApp", "This is an In-App notification");

// Step 5: Unsubscribe one observer and notify again
$subject->unsubscribe($smsObserver);

echo "\nNotifying observers after unsubscribing SMS:\n";
$subject->notifySubscribers("SMS", "This is another SMS notification");
$subject->notifySubscribers("Email", "This is another Email notification");
$subject->notifySubscribers("InApp", "This is another In-App notification");

