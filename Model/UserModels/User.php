<?php
class User extends Person {
    private DonationDetails $donationHistory;
    private int $nationalID;
    private Event $registeredEvents;
    private array $skills;
    private bool $isVolunteer;

    public function __construct(
        int $personID, 
        string $name, 
        string $email, 
        int $phone, 
        Address $address, 
        DonationDetails $donationHistory, 
        int $nationalID, 
        Event $registeredEvents, 
        array $skills, 
        bool $isVolunteer
    ) {
        parent::__construct($personID, $name, $email, $phone, $address);
        $this->donationHistory = $donationHistory;
        $this->nationalID = $nationalID;
        $this->registeredEvents = $registeredEvents;
        $this->skills = $skills;
        $this->isVolunteer = $isVolunteer;
    }

    public function trackDonationHistory() {
        // $query = "SELECT * FROM DonationDetails WHERE user_id = {$this->personID}";
        // $result = run_select_query($query);
        
        // if ($result) {
        //     while ($row = $result->fetch_assoc()) {
        //         print_r($row); // Output or process donation history records
        //     }
        // }
    }

    public function trackDonationStatus() {
        // $query = "SELECT status FROM Donations WHERE user_id = {$this->personID}";
        // $result = run_select_query($query);

        // if ($result) {
        //     while ($row = $result->fetch_assoc()) {
        //         print_r($row); // Output or process donation status records
        //     }
        // }
    }

    public function setRecurringDonations() {
        // $query = "UPDATE Donations SET is_recurring = 1 WHERE user_id = {$this->personID}";
        // run_query($query);
    }

    public function receiveReminder() {
        $query = "SELECT reminder FROM Reminders WHERE user_id = {$this->personID}";
        $result = run_select_query($query);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                print_r($row); // Output or process reminder records
            }
        }
    }

    public function fillDonationForm() {
        // $query = "INSERT INTO DonationForm (user_id) VALUES ({$this->personID})";
        // run_query($query);
    }

    public function choosePickUpOrDropOff() {
        // $query = "UPDATE DonationPreferences SET pickup_or_dropoff = 'pickup' WHERE user_id = {$this->personID}";
        // run_query($query);
    }

    public function receiveNotification() {
        // $query = "SELECT notification FROM Notifications WHERE user_id = {$this->personID}";
        // $result = run_select_query($query);

        // if ($result) {
        //     while ($row = $result->fetch_assoc()) {
        //         print_r($row); // Output or process notifications
        //     }
        // }
    }

    public function signUpForEvent(Event $event) {
        // $query = "INSERT INTO EventSignUps (user_id, event_id) VALUES ({$this->personID}, {$event->getId()})";
        // run_query($query);
    }

    public function updateSkills(array $newSkills) {
        // $skillsString = implode(",", $newSkills);
        // $query = "UPDATE Users SET skills = '$skillsString' WHERE user_id = {$this->personID}";
        // run_query($query);
    }

    public function checkAvailability() {
    //     $query = "SELECT availability FROM Users WHERE user_id = {$this->personID}";
    //     $result = run_select_query($query);

    //     if ($result) {
    //         $availability = $result->fetch_assoc()['availability'];
    //         echo "Availability: $availability";
    //     }
    }

    public function authenticateByEmail(string $email, string $password): mixed {
        // Get the database connection
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
                return $user; // Return user details on successful authentication
            }
        }
        return false; // Return false if no match is found
    }
}