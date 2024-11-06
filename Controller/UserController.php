<?php



class UserModel {
    
        // Static array to simulate a database of users
        private static $users = [
            1 => ['email' => '', 'password' => 'hashedpassword1', 'national_id' => '123456789'],
            2 => ['email' => 'jane@example.com', 'password' => 'hashedpassword2', 'national_id' => '987654321']
        ];
        private static $donationHistory = [
            1 => [
                ['donation_type' => 'medicine', 'amount' => 100, 'date' => '2024-01-10'],
                ['donation_type' => 'equipment', 'amount' => 50, 'date' => '2024-02-15']
            ],
            2 => [
                ['donation_type' => 'money', 'amount' => 200, 'date' => '2024-03-05']
            ]
        ];
        // Register a new user
        public static function register($email, $password, $nationalId) {
            // Check if the email already exists
            foreach (self::$users as $user) {
                if ($user['email'] === $email) {
                    return false; // Email is already taken
                }
            }
    
            // Add a new user with a simulated ID
            $newUserId = count(self::$users) + 1;
            self::$users[$newUserId] = [
                'email' => $email,
                'password' => password_hash($password, PASSWORD_BCRYPT),
                'national_id' => $nationalId
            ];
    
            return true; // User registered successfully
        }
    
        // Update user profile by ID
        public static function updateProfile($userId, $email, $nationalId) {
            // Check if user exists
            if (!isset(self::$users[$userId])) {
                return false; // User not found
            }
    
            // Update user data
            self::$users[$userId]['email'] = $email;
            self::$users[$userId]['national_id'] = $nationalId;
    
            return true; // Profile updated successfully
        }
    
        // Get user by ID
        public static function getUserById($userId) {
            // Return user if exists, otherwise return null
            return isset(self::$users[$userId]) ? self::$users[$userId] : null;
        }
    
        // Delete a user profile by ID
        public static function deleteProfile($userId) {
            // Check if user exists
            if (!isset(self::$users[$userId])) {
                return false; // User not found
            }
    
            // Remove user
            unset(self::$users[$userId]);
    
            return true; // Profile deleted successfully
        }
        public static function trackDonationHistory($userId) {
            // Check if the user exists
            if (isset(self::$donationHistory[$userId])) {
                return self::$donationHistory[$userId];
            } else {
                return "No donation history found for this user.";
            }
        }
}



class UserController {

    // Register new user
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $nationalId = $_POST['national_id'];

            // Use UserModel to register user
            $user = UserModel::register($email, $password, $nationalId);

            if ($user) {
                // Registration successful
                echo "User registered successfully!";
            } else {
                // Handle registration failure
                echo "Email is already taken!";
            }
        }

        // Show registration form (just for testing purposes)
        echo '<form method="POST">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="text" name="national_id" placeholder="National ID" required>
                <button type="submit">Register</button>
              </form>';
    }

    // Update user profile
    public function updateProfile() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];  // Assuming user_id is stored in the session
            $email = $_POST['email'];
            $nationalId = $_POST['national_id'];

            // Use UserModel to update profile
            $updated = UserModel::updateProfile($userId, $email, $nationalId);

            if ($updated) {
                echo "Profile updated successfully!";
            } else {
                echo "Update failed.";
            }
        }

        // Show profile update form
        $userId = $_SESSION['user_id'];  // Assuming user_id is stored in session
        $user = UserModel::getUserById($userId);

        if ($user) {
            echo '<form method="POST">
                    <input type="email" name="email" value="' . $user['email'] . '" required>
                    <input type="text" name="national_id" value="' . $user['national_id'] . '" required>
                    <button type="submit">Update Profile</button>
                  </form>';
        } else {
            echo "User not found.";
        }
    }

    // Delete user profile
    public function deleteProfile() {
        $userId = $_SESSION['user_id'];  // Assuming user_id is stored in the session
        $deleted = UserModel::deleteProfile($userId);

        if ($deleted) {
            echo "Profile deleted successfully!";
        } else {
            echo "Profile deletion failed.";
        }
    }

    // View user profile
    public function viewProfile() {
        $userId = $_SESSION['user_id'];  // Assuming user_id is stored in session
        $user = UserModel::getUserById($userId);

        if ($user) {
            echo "Email: " . $user['email'] . "<br>";
            echo "National ID: " . $user['national_id'] . "<br>";
        } else {
            echo "User not found.";
        }
    }

    public function trackDonationHistory() {
        $userId = $_SESSION['user_id'];  // Assuming user_id is stored in session

        // Get donation history from UserModel
        $donations = UserModel::trackDonationHistory($userId);

        // Display the donation history
        if (is_array($donations)) {
            echo "Donation History for User ID $userId:<br>";
            foreach ($donations as $donation) {
                echo "Type: " . $donation['donation_type'] . ", Amount: " . $donation['amount'] . ", Date: " . $donation['date'] . "<br>";
            }
        } else {
            echo $donations;  // If no history found, display the error message
        }
    }
}
