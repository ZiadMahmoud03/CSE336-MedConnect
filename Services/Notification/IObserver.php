<?php

Interface IObserver{
    public function update($notificationType, $message);
}