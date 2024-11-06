<?php

class NotificationSubject implements ISubject {
    private $observers = [];
    private $state;

    // Subscribe an observer
    public function subscribe(IObserver $observer) {
        $this->observers[] = $observer;
    }

    // Unsubscribe an observer
    public function unsubscribe(IObserver $observer) {
        $index = array_search($observer, $this->observers);
        if ($index !== false) {
            unset($this->observers[$index]);
        }
    }

    // Notify all observers
    public function notifySubscribers($notificationType, $message) {
        foreach ($this->observers as $observer) {
            $observer->update($notificationType, $message);
        }
    }
}
