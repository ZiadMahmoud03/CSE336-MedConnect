<?php

class User {
    // Simulate user data
    private $users = [
        ['id' => 1, 'email' => 'admin@example.com', 'password' => 'adminpass', 'type' => 'Admin'],
        ['id' => 2, 'email' => 'donor@example.com', 'password' => 'donorpass', 'type' => 'Donor'],
    ];

    public function authenticateByEmail($email, $password) {
        // Search for a user matching the email and password
        foreach ($this->users as $user) {
            if ($user['email'] === $email && $user['password'] === $password) {
                return $user; // Return user details on success
            }
        }
        return false; // Return false if no match is found
    }
}
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
