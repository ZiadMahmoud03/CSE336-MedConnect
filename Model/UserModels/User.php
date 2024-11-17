<?php

ob_start();  

require_once "config/db-conn-setup.php";  
require_once "Model/Address.php";  
require_once "Model/UserModels/Person.php";  

ob_end_clean();  


class User extends Person {
    private ?int $userID;
    private ?DonationDetails $donationHistory;
    private ?string $nationalID;
    private ?array $registeredEvents;
    private ?array $skills;
    private ?bool $isVolunteer;

    public function __construct(?int $userID = null, ?DonationDetails $donationHistory = null, ?string $nationalID = null, 
                                ?array $registeredEvents = null, ?array $skills = null, ?bool $isVolunteer = null, Address $address = null, ?string $firstName = null, ?string $lastName = null, ?string  $email = null, ?string  phone = null) {
        
        parent::__construct(null, $firstName, $lastName, $email, $phone, $address);
        $this->userID = $userID;
        $this->donationHistory = $donationHistory;
        $this->nationalID = $nationalID;
        $this->registeredEvents = $registeredEvents;
        $this->skills = $skills;
        $this->isVolunteer = $isVolunteer;
        $this->address = $address ?? new Address();  // Address should not be Null
    }

    public function signUpForEvent(Event $event): bool {
        $db = Database::getInstance();

        $stmt = $db->prepare("INSERT INTO user_events (user_id, event_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $this->userID, $event->getEventID());

        return $stmt->execute();
    }

   /* public function trackDonationHistory(): array {
        $db = Database::getInstance();

        $stmt = $db->prepare("SELECT * FROM DonationDetails WHERE user_id = ?");
        $stmt->bind_param("i", $this->userID);
        $stmt->execute();
        $result = $stmt->get_result();

        $donationHistory = [];
        while ($row = $result->fetch_assoc()) {
            // Assuming DonationDetails class properly handles $row array
            $donationHistory[] = new DonationDetails($row); 
        }
        return $donationHistory;
    }

    public function trackDonationStatus(): string {
        $db = Database::getInstance();

        $stmt = $db->prepare("SELECT status FROM DonationDetails WHERE user_id = ?");
        $stmt->bind_param("i", $this->userID);
        $stmt->execute();
        $result = $stmt->get_result();

        $status = $result->fetch_assoc()['status'];
        return $status ?: 'No donation status found';
    }
        */

    /* public function updateSkills(array $newSkills): bool {
        $this->skills = $newSkills;  

        $db = Database::getInstance();
        $skills = implode(",", $newSkills);  // Store skills as a comma-separated string
        $stmt = $db->prepare("UPDATE User SET skills = ? WHERE user_id = ?");
        $stmt->bind_param("si", $skills, $this->userID);

        return $stmt->execute();
    }
        */

    public function checkAvailability(): bool {
        return $this->isVolunteer ?? false;
    }

    public function updateProfile(string $newPassword, string $newEmail, string $newPhone, Address $newAddress): bool {
        $db = Database::getInstance();

        $stmt = $db->prepare("UPDATE Person SET email = ?, password = ?, phone = ?, address_id = ? WHERE user_id = ?");
        $stmt->bind_param("ssssi", $newEmail, $newPassword, $newPhone, $newAddress->getAddressID(), $this->userID);
        
        return $stmt->execute();
    }

    //Removed Address
    public function createAccount(string $email, string $password, string $firstName, string $lastName, string $phone, string $nationalID): bool {
        $db = Database::getInstance();

        $stmt = $db->prepare("INSERT INTO Person (firstName,lastName, email, phone, password, nationalID) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $name, $email, $phone, $password, $nationalID);

        return $stmt->execute();
    }

    public function getUserID(): int {
        return $this->userID;
    }

    public function getSkills(): array {
        return $this->skills;
    }

    public function getAddress(): Address {
        return $this->address;
    }

    public function setUserID(int $userID): void {
        $this->userID = $userID;
    }

    public function setDonationHistory(DonationDetails $donationHistory): void {
        $this->donationHistory = $donationHistory;
    }

    public function setIsVolunteer(bool $isVolunteer): void {
        $this->isVolunteer = $isVolunteer;
    }

    public function authenticateByEmail(string $email, string $password): bool {
        $db = Database::getInstance();
        
        $stmt = $db->prepare("SELECT * FROM Person WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        // Check if a user with the given email exists
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Compare the provided password with the stored password
            if ($user['password'] === $password) {

                $this->userID = $user['person_id'];
                $this->name = $user['name'];
                $this->email = $user['email'];
                $this->phone = $user['phone'];

                $this->address = new Address($user['address_id']); 
                return true; // Authentication successful
            }
        }
        return false; // Authentication failed
    }
    
}
?>
