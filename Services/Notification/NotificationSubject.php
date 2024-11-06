<?php

require_once 'ISubject.php';
class NotificationSubject implements ISubject {
    private $observers = [];
    private $state;

    // Subscribe an observer
    public function subscribe(IObserver $observer) {
        $this->observers[] = $observer;
          echo "Observer subscribed. Total observers: " . count($this->observers) . "\n";
    }

    // Unsubscribe an observer
    public function unsubscribe(IObserver $observer) {
        foreach ($this->observers as $key => $obs) {
            if ($obs === $observer) {
                $observerType = get_class($obs); 
                unset($this->observers[$key]);
                echo "$observerType unsubscribed. Total observers: " . count($this->observers) . "\n";
                break;
            }
        }
        $this->observers = array_values($this->observers); // Reindex array
    }

    public function setState($state) {
        $this->state = $state;
       // $this->notifySubscribers($notificationType, $message);
    }

    // Notify all observers
    public function notifySubscribers($notificationType, $message) {
        echo "Notifying observers with type: $notificationType\n";
        foreach ($this->observers as $observer) {
            $observer->update($notificationType, $message);
        }
    }
}
