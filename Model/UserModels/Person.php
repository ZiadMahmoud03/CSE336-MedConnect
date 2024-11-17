<?php

require_once "config/db-conn-setup.php";
require_once "Address.php"; 

abstract class Person {
    protected? int $personID;
    protected ?string $firstName;
    protected ?string $lastName;
    protected ?string $email;
    protected ?string $phone;
    protected ?Address $address;

    // Constructor for Person class
    public function __construct(?int $personID = null, ?string $firstName = null, ?string $lastName = null, ?string $email = null, ?string $phone = null, ?Address $address = null) {
        $this->personID = $personID;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phone = $phone;
        $this->address = $address;
    }

    // Getters and Setters
    public function getPersonID(): ?int {
        return $this->personID;
    }

    public function setPersonID(int $personID): void {
        $this->personID = $personID;
    }

    public function getFirstName(): ?string {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void {
        $this->firstName = $firstName;
    }

    public function getLastName(): ?string {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void {
        $this->lastName = $lastName;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function getPhone(): ?string {
        return $this->phone;
    }

    public function setPhone(string $phone): void {
        $this->phone = $phone;
    }

    public function getAddress(): ?Address {
        return $this->address;
    }

    public function setAddress(Address $address): void {
        $this->address = $address;
    }

    // Save the person data into the database
    public function save(): bool {
        $db = Database::getInstance();

        if ($this->personID === null) {
            // Insert new person
            $stmt = $db->prepare("INSERT INTO Person (first_name, last_name, email, phone, address_id) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssi", $this->firstName, $this->lastName, $this->email, $this->phone, $this->address->getAddressID());
        } else {
            // Update existing person
            $stmt = $db->prepare("UPDATE Person SET first_name = ?, last_name = ?, email = ?, phone = ?, address_id = ? WHERE person_id = ?");
            $stmt->bind_param("ssssii", $this->firstName, $this->lastName, $this->email, $this->phone, $this->address->getAddressID(), $this->personID);
        }

        return $stmt->execute();
    }

    // Method to create account (registration)
    public function createAccount(string $password): bool {
        $db = Database::getInstance();

        // Prepare the SQL statement to insert the person data
        $stmt = $db->prepare("INSERT INTO Person (first_name, last_name, email, phone, password, address_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $this->firstName, $this->lastName, $this->email, $this->phone, $password, $this->address->getAddressID());

        // Execute the query
        return $stmt->execute();
    }

    // Method to update the profile
    public function updateProfile(string $newPassword): bool {
        $db = Database::getInstance();

        // Prepare the SQL statement to update the password
        $stmt = $db->prepare("UPDATE Person SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $newPassword, $this->email);

        // Execute the query
        return $stmt->execute();
    }

    // Method to login
    public function login(string $email, string $password): bool {
        $db = Database::getInstance();

        // Prepare the SQL statement to retrieve the person
        $stmt = $db->prepare("SELECT * FROM Person WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the person exists and if the password matches
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if ($user['password'] === $password) {
                // Set object properties on successful login
                $this->personID = $user['person_id'];
                $this->firstName = $user['first_name'];
                $this->lastName = $user['last_name'];
                $this->email = $user['email'];
                $this->phone = $user['phone'];
                $this->address = new Address($user['address_id']); 

                return true;
            }
        }
        return false;
    }
}
?>
