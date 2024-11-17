<?php

//require_once "Model/UserModels/User.php";
require_once "View/SignupView.php";

/*
 * Class SignUpController
 * all of the following code is assuming that the User class is already created,
 * and the save function is working
 */

class SignUpController
{
    use Controller;

    public function index()
    {
        // Display the sign-up form
        $this->view("SignupView");
    }

    public function register()
    {
        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get form data
            $name = $_POST['name'] ?? null;
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;

            // Validate inputs
            if (empty($name) || empty($email) || empty($password)) {
                echo "All fields are required!";
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "Invalid email format!";
                return;
            }

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Create a new user
            // $user = new User();
            // $user->setname() = $name;
            // $user->setemail() = $email;
            // $user->setpassword() = $hashedPassword;

            // // Save user to the database
            // if ($user->save()) { // assuming this save function save that user to database 
            //     echo "Sign-up successful!";
            //     header("Location: /login"); // Redirect to login page
            //     exit;
            // } else {
            //     echo "Failed to register user. Please try again.";
            // }
        }
    }
}
