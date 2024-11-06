<?php

abstract class Person {
    private int $personID;
    private string $name;
    private string $email;
    private int $phone;
    private Address $address;

    public function __construct(int $personID, string $name, string $email, int $phone, Address $address) {
        $this->personID = $personID;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->address = $address;
    }

    public function login(string $email, string $password): bool {
        // Check if email and password match
        return true;
    }

    public function createAccount(string $email, string $password): bool {
        // Create a new account
        //funtion tepmorarily returns boolean value, will be modified later
        return true;
    }

    public function updateProfile(string $email, string $password): bool {
        // Update profile details
        //funtion tepmorarily returns boolean value, will be modified later
        return true;
        
    }

}
?>