<?php

echo"Login form goes here";
class LoginController {
    private $loginStrategy;

    // Method to set the login strategy dynamically
    public function setLoginStrategy(ILoginStrategy $strategy) {
        $this->loginStrategy = $strategy;
    }

    // Main login method that uses the selected strategy
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $loginType = $_POST['login_type']; // e.g., 'email', 'google', 'facebook'
            $userCredentials = [
                'username' => $_POST['username'] ?? null,
                'password' => $_POST['password'] ?? null,
                'token' => $_POST['token'] ?? null,
            ];

            // Choose the strategy based on login type
            switch ($loginType) {
                case 'google':
                    $this->setLoginStrategy(new GoogleLogin());
                    break;
                case 'email':
                    $this->setLoginStrategy(new EmailLogin());
                    break;
                case 'facebook':
                    $this->setLoginStrategy(new FacebookLogin());
                    break;
                default:
                    $_SESSION['error'] = "Invalid login type.";
                    header('Location: /login');
                    exit();
            }

            try {
                // Authenticate using the chosen strategy
                $user = $this->loginStrategy->login($userCredentials);

                // Start session and store user data on successful login
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_type'] = $user['type']; // 'Donor' or 'Admin'

                // Redirect based on user type
                if ($user['type'] === 'Admin') {
                    header('Location: /admin/dashboard');
                } else {
                    header('Location: /donor/dashboard');
                }
                exit();

            } catch (Exception $e) {
                // Handle login failure
                $_SESSION['error'] = $e->getMessage();
                header('Location: /login');
                exit();
            }
        }
    }

    public function showLoginForm() {
        require 'views/login.php';
    }
    
}
