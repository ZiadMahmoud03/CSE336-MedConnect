<?php

class EmailLogin implements ILoginStrategy {
    private $userModel;

    public function __construct() {
        $this->userModel = new User(); 
    }

    public function login(array $userCredentials) {
       // regex ="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$";
        $email = $userCredentials['email'];
        $password = $userCredentials['password'];

        //checkemail
        $user = $this->userModel->authenticateByEmail($email, $password);

        if (!$user) {
            throw new Exception("Invalid email or password.");
        }

        return $user;
    }
}
