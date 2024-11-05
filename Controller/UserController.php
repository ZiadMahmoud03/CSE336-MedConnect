<?php
class UserController {
    protected $userService;

    public function __construct() {
        $this->userService = new UserService(); 
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Call service to register user
            $user = $this->userService->register($username, $email, $password);

            if ($user) {
                // Redirect to a success page or login
                header('Location: /login');
                exit();
            } else {
                // Handle registration failure
                $_SESSION['error'] = 'Registration failed.';
            }
        }

        // Show registration form
        require 'views/register.php';
    }

    public function updateProfile() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id']; // Assuming user ID is stored in session
            $username = $_POST['username'];
            $email = $_POST['email'];

            // Call service to update user profile
            $updated = $this->userService->updateProfile($userId, $username, $email);

            if ($updated) {
                // Redirect to a success page
                header('Location: /profile');
                exit();
            } else {
                // Handle update failure
                $_SESSION['error'] = 'Update failed.';
            }
        }

        // Show profile update form
        $userId = $_SESSION['user_id'];
        $user = $this->userService->getUserById($userId);
        require 'views/update_profile.php';
    }

    public function deleteProfile() {
        $userId = $_SESSION['user_id']; // Assuming user ID is stored in session
        $deleted = $this->userService->deleteProfile($userId);

        if ($deleted) {
            // Redirect to a success page or login after deletion
            header('Location: /goodbye');
            exit();
        } else {
            // Handle deletion failure
            $_SESSION['error'] = 'Deletion failed.';
        }
    }

    public function viewProfile() {
        $userId = $_SESSION['user_id']; // Assuming user ID is stored in session
        $user = $this->userService->getUserById($userId);

        if ($user) {
            require 'views/profile.php'; // Show user profile view
        } else {
            // Handle user not found
            $_SESSION['error'] = 'User not found.';
            header('Location: /login');
            exit();
        }
    }
}
