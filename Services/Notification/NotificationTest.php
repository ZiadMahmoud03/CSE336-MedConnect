<?php
require 'NotificationSubject.php';
require 'EmailNotification.php';
require 'SMSNotification.php';
require 'InAppNotification.php';

// Step 1: Create the subject
$subject = new NotificationSubject();

// Step 2: Create observers (SMS, Email, InApp)
$emailObserver = new EmailNotification($subject);
$smsObserver = new SMSNotification($subject);
$inAppObserver = new InAppNotification($subject);

// Step 3: Notify observers with different types of messages
echo "Notifying observers with different types:\n";
$subject->setMessage("This is an a new notification");

echo "\nNotifying observers after unsubscribing SMS:\n";
// Unsubscribe SMS observer
$subject->unsubscribe($smsObserver, 'SMS');

// Notify again with a new message
$subject->setMessage("This is a new message after SMS unsubscribed");
