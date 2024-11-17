<?php

require "ISubject.php";
require "IObserver.php";

class NotificationSubject implements ISubject {
    private $observers = [];
    private $message;

    // Subscribe an observer to a specific notification type
    public function subscribe(IObserver $observer, $notificationType) {
        if (!isset($this->observers[$notificationType])) {
            $this->observers[$notificationType] = [];
        }
        $this->observers[$notificationType][] = $observer;
    }

    // Unsubscribe an observer from a specific notification type
    public function unsubscribe(IObserver $observer, $notificationType) {
        if (isset($this->observers[$notificationType])) {
            // Remove the observer by filtering out the matching observer object
            $this->observers[$notificationType] = array_filter(
                $this->observers[$notificationType],
                fn($subscriber) => $subscriber !== $observer
            );
            // Re-index the array to prevent gaps
            $this->observers[$notificationType] = array_values($this->observers[$notificationType]);
        }
    }

    // Notify all observers based on notificationType
    public function notifySubscribers() {
        foreach ($this->observers as $notificationType => $observers) {
            foreach ($observers as $observer) {
                $observer->update($notificationType, $this->message);
            }
        }
    }

    // Notify new message to all observers
    public function newMessage() {
        $this->notifySubscribers();
    }

    // Set the message and trigger the notification to all subscribed observers
    public function setMessage($message) {
        $this->message = $message;
        $this->newMessage();  // Notify all observers after setting the message
    }
}
