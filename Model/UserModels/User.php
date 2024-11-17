<?php

ob_start();
require_once "config/db-conn-setup.php";  // Include the database connection setup
ob_end_clean();  // Clean up the output buffer

class User {
    private ?int $userID;  // User ID can be null
    private ?string $name;  // Name can be null
    private ?string $email;  // Email can be null
    private ?string $phone;  // Phone can be null
    private ?string $password;  // Password can be null
    private ?Address $address;  // Address can be null
    private ?bool $isVolunteer;  // Volunteer status can be null

    // Constructor with default null values for parameters
    public function __construct(
        ?int $userID = null, 
        ?string $name = null, 
        ?string $email = null, 
        ?string $phone = null, 
        ?string $password = null, 
        ?Address $address = null, 
        ?bool $isVolunteer = null

        
    ) {
        $this->userID = $userID;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->password = $password;
        $this->address = $address;
        $this->isVolunteer = $isVolunteer;
    }

    // Authenticate by email and password
    public static function authenticateByEmail(string $email, string $password): ?User {
        // Database query to find the user by email
        $query = "SELECT * FROM Person INNER JOIN User ON Person.person_id = User.person_id WHERE Person.email = ?";
        $conn = Database::getInstance();
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);  // Bind email parameter

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            // Check if password matches
            if ($row['password'] === $password) {
                // Return User object if password matches
                return new User(
                    $row['user_id'], 
                    $row['first_name'] . ' ' . $row['last_name'],  // Concatenate first and last names
                    $row['email'], 
                    $row['phone'], 
                    $row['password'],
                    new Address($row['address_id']),  // Assuming Address object with the provided address_id
                    $row['is_volunteer']
                );
            }
        }
        
        return null; // Return null if no match found
    }

    // Getter methods
    public function getUserID(): ?int {
        return $this->userID;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function getPhone(): ?string {
        return $this->phone;
    }

    public function getPassword(): ?string {
        return $this->password;
    }

    public function getAddress(): ?Address {
        return $this->address;
    }

    public function getIsVolunteer(): ?bool {
        return $this->isVolunteer;
    }

    // Save or update user in the database
    public function save(): bool {
        $conn = Database::getInstance();
        if ($this->userID === null) {
            // Insert a new user
            $query = "INSERT INTO Person (first_name, last_name, email, phone, password, address_id) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssssi", $this->name, $this->email, $this->phone, $this->password, $this->address?->getAddressID(), $this->address?->getAddressID());
            return $stmt->execute();
        } else {
            // Update an existing user
            $query = "UPDATE Person SET first_name = ?, last_name = ?, email = ?, phone = ?, password = ?, address_id = ? WHERE person_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssssssi", $this->name, $this->email, $this->phone, $this->password, $this->address?->getAddressID(), $this->userID);
            return $stmt->execute();
        }
    }
}
?>

<?php
require_once "config/db-conn-setup.php"; // Database connection setup

class User {
    private ?int $userID;
    private ?string $email;
    private ?string $password;
    private ?string $name;
    private ?string $phone;
    private ?Address $address;
    private ?bool $isVolunteer; 
    

    public function __construct(?int $userID = null, ?string $email = null, ?string $password = null, ?string $name = null, ?string $phone = null, ?Address $address = null) {
        $this->userID = $userID;
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->phone = $phone;
        $this->address = $address;
    }

    // Create a new account
    public function createAccount(string $email, string $password, string $name, string $phone, Address $address): bool {
        $db = Database::getInstance();

        // Prepare the SQL statement to prevent SQL injection
        $stmt = $db->prepare("INSERT INTO Person (name, email, phone, password, address_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $name, $email, $phone, $password, $address->getAddressID()); // Assuming Address has a getAddressID() method
        
        // Execute the query and return true if successful
        return $stmt->execute();
    }

    // Update user profile with a new password
    public function updateProfile(string $email, string $newPassword): bool {
        $db = Database::getInstance();

        // Prepare the SQL statement to update user details
        $stmt = $db->prepare("UPDATE Person SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $newPassword, $email);
        
        // Execute the query and return true if successful
        return $stmt->execute();
    }

    // Function to authenticate a user by email and password
    public function authenticate(string $email, string $password): bool {
        $db = Database::getInstance();
        
        // Prepare the SQL statement to check if the user exists
        $stmt = $db->prepare("SELECT password FROM Person WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // If a user is found, verify the password
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['password'] === $password) {
                return true;
            }
        }
        
        return false; // Return false if authentication fails
    }

    // Track donation history for the user
    public function trackDonationHistory($userId) {
        $db = Database::getInstance();
        $query = "SELECT * FROM DonationDetails WHERE user_id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC); // Return donation history
        } else {
            return "No donation history found.";
        }
    }

    // Track donation status for a user (optional additional function)
    public function trackDonationStatus($userId) {
        $db = Database::getInstance();
        $query = "SELECT * FROM Donation WHERE user_id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC); // Return donation status details
        } else {
            return "No donation status found.";
        }
    }

    // Set recurring donations for a user (functionality to be implemented as needed)
    public function setRecurringDonations($userId, $donationDetails): bool {
        $db = Database::getInstance();

        // Assuming recurring donations are tracked in a donations table, implement this function
        $query = "INSERT INTO RecurringDonations (user_id, donation_details) VALUES (?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("is", $userId, $donationDetails);

        return $stmt->execute();
    }

    // Receive reminder notifications for donations
    public function receiveReminder($userId): bool {
        // Assuming a reminder system is in place, implement logic to send reminders to the user
        // For simplicity, we'll assume a function that returns true if a reminder was sent
        return true;
    }

    // Fill out a donation form
    public function fillDonationForm($userId, $formDetails): bool {
        $db = Database::getInstance();

        // Insert donation form details into the database
        $query = "INSERT INTO DonationForms (user_id, form_details) VALUES (?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("is", $userId, $formDetails);

        return $stmt->execute();
    }

    // Choose pickup or drop-off for donations
    public function choosePickUpOrDropOff($userId, $pickupOption): bool {
        // Implement logic for the user to choose between pickup or drop-off
        // Here we just simulate it
        return true;
    }

    // Receive notification about a donation event
    public function receiveNotification($userId, $message): bool {
        // Implement logic to send notification to the user
        // For simplicity, assume a function that returns true when a notification is sent
        return true;
    }

    // Sign up for an event
    public function signUpForEvent(Event $event, $userId): bool {
        $db = Database::getInstance();

        // Insert user signup details for the event
        $query = "INSERT INTO EventSignups (event_id, user_id) VALUES (?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("ii", $event->getEventID(), $userId);

        return $stmt->execute();
    }

    // Update skills of the user
    public function updateSkills($userId, $newSkills): bool {
        $db = Database::getInstance();

        // Assuming skills are stored in a serialized format
        $skillsSerialized = serialize($newSkills);
        $query = "UPDATE User SET skills = ? WHERE user_id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("si", $skillsSerialized, $userId);

        return $stmt->execute();
    }

    // Check availability (for event or donation)
    public function checkAvailability($userId): bool {
        // Check user availability based on events or donation status
        // Simulate logic to check availability
        return true;
    }
}
?>
