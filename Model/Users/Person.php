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

}
?>