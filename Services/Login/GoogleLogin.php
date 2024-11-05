<?php

class GoogleLogin implements ILoginStrategy {
    private $userModel;

    public function __construct() {
        $this->userModel = new User(); 
    }

    public function login(array $userCredentials) {
        $token = $userCredentials['token'];

        // Here you would typically validate the Google token
        $user = $this->userModel->findByGoogleToken($token);

        if (!$user) {
            throw new Exception("Invalid Google token or user not registered.");
        }

        return $user;
    }
}
