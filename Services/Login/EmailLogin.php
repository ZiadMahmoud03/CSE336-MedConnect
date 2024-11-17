<?php

class EmailLogin implements ILoginStrategy {
    private $userModel;

    public function __construct() {
        $this->userModel = new User(); 
    }

    public function login(array $userCredentials) {
        $email = trim($userCredentials['email']);  // Trim whitespace
        $password = trim($userCredentials['password']);  // Trim whitespace

        // Debugging: Check values of email and password
        //var_dump($email, $password);

        $user = $this->userModel->authenticateByEmail($email, $password);

        // Debug: Check the result of authentication
       //var_dump($user);

        if (!$user) {
            throw new Exception("Invalid email or password.");
            //return false;
        }

        return $user;
    }
}
