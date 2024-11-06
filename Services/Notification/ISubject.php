<?php
Interface ISubject{
    public function subscribe(IObserver $observer);
    public function unsubscribe(IObserver $observer);
    public function notifySubscribers($notificationType,$message);
}