<?php

require_once "Model/UserModels/User.php";

class UserController {
    use Controller;
    // Register new user
    public function index(){}
    public function register() {
        $this->view("signup");
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo "<pre>";
            print_r($_POST);
            echo "</pre>";
            //************** */
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $con_password = $_POST['con_password'];
            $nationalId = $_POST['national_id'];
            $phone_number = $_POST['phone_number'];
    
            // Use UserModel to register user
            $user = new User();
            if ($user->createAccount($email, $password, $first_name, $last_name, $phone_number, $nationalId)) {
                echo "User registered successfully!";
                $this->view('home');
            } else {
                echo "Error: Registration failed. Please try again.";
            }
        }
    }
            // if ($user) {
            //     // Registration successful
            //     echo "User registered successfully!";
            // } else {
            //     // Handle registration failure
            //     echo "Email is already taken!";
            // }
        }

        // // Show registration form (just for testing purposes)
        // echo '<form method="POST">
        //         <input type="email" name="email" placeholder="Email" required>
        //         <input type="password" name="password" placeholder="Password" required>
        //         <input type="text" name="national_id" placeholder="National ID" required>
        //         <button type="submit">Register</button>
        //       </form>';
   // }

    // // Update user profile
    // public function updateProfile() {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $userId = $_SESSION['user_id'];  // Assuming user_id is stored in the session
    //         $email = $_POST['email'];
    //         $nationalId = $_POST['national_id'];

    //         // Use UserModel to update profile
    //         $updated = UserModel::updateProfile($userId, $email, $nationalId);

    //         if ($updated) {
    //             echo "Profile updated successfully!";
    //         } else {
    //             echo "Update failed.";
    //         }
    //     }

    //     // Show profile update form
    //     $userId = $_SESSION['user_id'];  // Assuming user_id is stored in session
    //     $user = UserModel::getUserById($userId);

    //     if ($user) {
    //         echo '<form method="POST">
    //                 <input type="email" name="email" value="' . $user['email'] . '" required>
    //                 <input type="text" name="national_id" value="' . $user['national_id'] . '" required>
    //                 <button type="submit">Update Profile</button>
    //               </form>';
    //     } else {
    //         echo "User not found.";
    //     }
    // }

    // // Delete user profile
    // public function deleteProfile() {
    //     $userId = $_SESSION['user_id'];  // Assuming user_id is stored in the session
    //     $deleted = UserModel::deleteProfile($userId);

    //     if ($deleted) {
    //         echo "Profile deleted successfully!";
    //     } else {
    //         echo "Profile deletion failed.";
    //     }
    // }

    // // View user profile
    // public function viewProfile() {
    //     $userId = $_SESSION['user_id'];  // Assuming user_id is stored in session
    //     $user = UserModel::getUserById($userId);

    //     if ($user) {
    //         echo "Email: " . $user['email'] . "<br>";
    //         echo "National ID: " . $user['national_id'] . "<br>";
    //     } else {
    //         echo "User not found.";
    //     }
    // }

    // public function trackDonationHistory() {
    //     $userId = $_SESSION['user_id'];  // Assuming user_id is stored in session

    //     // Get donation history from UserModel
    //     $donations = UserModel::trackDonationHistory($userId);

    //     // Display the donation history
    //     if (is_array($donations)) {
    //         echo "Donation History for User ID $userId:<br>";
    //         foreach ($donations as $donation) {
    //             echo "Type: " . $donation['donation_type'] . ", Amount: " . $donation['amount'] . ", Date: " . $donation['date'] . "<br>";
    //         }
    //     } else {
    //         echo $donations;  // If no history found, display the error message
    //     }
    // }
//}
