<?php
Interface ISubject{
    public function subscribe(IObserver $observer,$type);
    public function unsubscribe(IObserver $observer,$type);
    // public function notifySubscribers($notificationType,$message);
    public function notifySubscribers();
}