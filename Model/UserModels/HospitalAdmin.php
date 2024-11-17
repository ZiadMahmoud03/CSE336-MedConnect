<?php
require_once "config/db-conn-setup.php";  
require_once "Address.php";  
require_once "Item.php"; 
require_once "Person.php";

class HospitalAdmin extends Person {
    private ?int $adminID;
    private ?int $hospitalID;

    // Constructor for initializing HospitalAdmin model
    public function __construct(?int $adminID = null, ?int $hospitalID = null, Address $address = null) {
        parent::__construct($adminID, null, null, null, $address);  // Call the parent constructor (Person)
        $this->adminID = $adminID;
        $this->hospitalID = $hospitalID;
    }

    // Method to upload required items for the hospital
    public function uploadRequiredItems(string $itemName, int $quantity, string $description): bool {
        $db = Database::getInstance();

        // Insert a new item into the hospital's inventory (Item table)
        $stmt = $db->prepare("INSERT INTO Item (name, quantity_available, description, hospital_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sisi", $itemName, $quantity, $description, $this->hospitalID);

        return $stmt->execute();
    }

    // Method to notify the admin about expiring medicine
    public function notifyExpiringMedicine(): array {
        $db = Database::getInstance();

        $stmt = $db->prepare("SELECT * FROM Medicine WHERE expiry_date <= DATE_ADD(CURRENT_DATE, INTERVAL 30 DAY) AND hospital_id = ?");
        $stmt->bind_param("i", $this->hospitalID);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $expiringMedicines = [];

        while ($row = $result->fetch_assoc()) {
            $expiringMedicines[] = $row;  // Add expiring medicines to the array
        }
        return $expiringMedicines;  // Return the expiring medicines list
    }

    // Method to manage hospital items (adding/updating/removing)
    public function manageItems(int $itemID, string $name, int $quantity, string $description): bool {
        $db = Database::getInstance();

        // Update or insert the item into the hospital's inventory
        $stmt = $db->prepare("UPDATE Item SET name = ?, quantity_available = ?, description = ? WHERE item_id = ? AND hospital_id = ?");
        $stmt->bind_param("sisis", $name, $quantity, $description, $itemID, $this->hospitalID);

        return $stmt->execute();
    }

    // Method to update a donation request from a user
    public function updateDonationRequest(int $donationID, int $status): bool {
        $db = Database::getInstance();

        // Update the donation request status (0 = Pending, 1 = Accepted, 2 = Rejected)
        $stmt = $db->prepare("UPDATE Donation SET status = ? WHERE donation_id = ? AND hospital_id = ?");
        $stmt->bind_param("iii", $status, $donationID, $this->hospitalID);

        return $stmt->execute();
    }

    // Method to review a donation made by a user
    public function reviewDonation(int $donationID, string $comments, int $status): bool {
        $db = Database::getInstance();

        // Review donation: add comments and update status (approved/rejected)
        $stmt = $db->prepare("UPDATE Donation SET status = ?, comments = ? WHERE donation_id = ? AND hospital_id = ?");
        $stmt->bind_param("issi", $status, $comments, $donationID, $this->hospitalID);

        return $stmt->execute();
    }

    // Method to receive notifications (just for tracking notifications in this case)
    
    /* public function receiveNotification(string $message): bool {
        $db = Database::getInstance();

        // Insert the notification into a hypothetical 'Notifications' table
        $stmt = $db->prepare("INSERT INTO Notifications (hospital_id, message) VALUES (?, ?)");
        $stmt->bind_param("is", $this->hospitalID, $message);

        return $stmt->execute();
    } */
    
    // Getters and Setters 
    public function getAdminID(): ?int {
        return $this->adminID;
    }

    public function getHospitalID(): ?int {
        return $this->hospitalID;
    }

    public function setHospitalID(int $hospitalID): void {
        $this->hospitalID = $hospitalID;
    }
}
?>
