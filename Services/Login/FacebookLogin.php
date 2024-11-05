<?php

class FacebookLogin implements ILoginStrategy {
    private $userModel;

    public function __construct() {
        $this->userModel = new User(); 
    }

    public function login(array $userCredentials) {
        $token = $userCredentials['token'];

        // Validate Facebook token and check user in the database
        $user = $this->userModel->findByFacebookToken($token);

        if (!$user) {
            throw new Exception("Invalid Facebook token or user not registered.");
        }

        return $user;
    }
}
