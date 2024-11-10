
<?php

class Person {
    private int $personID;
    private string $name;
    private string $email;
    private string $phone;
    private Address $address; // Assuming Address is a separate class

    public function __construct(int $personID, string $name, string $email, string $phone, Address $address) {
        $this->personID = $personID;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->address = $address;
    }

    public function login(string $email, string $password): bool {
        // Get the database connection
        $db = Database::getInstance();
        
        // Prepare the SQL statement to prevent SQL injection
        $stmt = $db->prepare("SELECT * FROM Person WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Check if a user with the given email exists
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            // Compare the provided password with the stored password
            if ($user['password'] === $password) {
                // Set user properties (optional)
                $this->personID = $user['person_id'];
                $this->name = $user['name'];
                $this->email = $user['email'];
                $this->phone = $user['phone'];
                // Assuming Address object needs to be set here
                $this->address = new Address($user['address_id']); // You may want to fetch address details as well
                return true; // 
            }
        }
        return false; 
    }

    public function createAccount(string $email, string $password, string $name, string $phone, Address $address): bool {
        // Assuming $address is a valid Address object
        $db = Database::getInstance();

        // Prepare the SQL statement to prevent SQL injection
        $stmt = $db->prepare("INSERT INTO Person (name, email, phone, password, address_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $name, $email, $phone, $password, $address->getAddressID()); // Assuming Address has a getAddressID() method
        
        // Execute the query and return true if successful
        return $stmt->execute();
    }

    public function updateProfile(string $email, string $newPassword): bool {
        $db = Database::getInstance();

        // Prepare the SQL statement to update user details
        $stmt = $db->prepare("UPDATE Person SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $newPassword, $email);
        
        // Execute the query and return true if successful
        return $stmt->execute();
    }

    // Getters for properties
    public function getPersonID(): int {
        return $this->personID;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPhone(): string {
        return $this->phone;
    }

    public function getAddress(): Address {
        return $this->address;
    }
}

?>
