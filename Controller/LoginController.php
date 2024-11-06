<?php
require_once "./Services/Login/ILoginStrategy.php";
require_once "./Services/Login/EmailLogin.php";
require_once "./Services/Login/FacebookLogin.php";
require_once "./Services/Login/GoogleLogin.php";

class LoginController
{
    use Controller;

    private $loginStrategy;

    public function index()
    {
        $data = [];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            
            $userCredentials = [
                'email' => $_POST['email'],
                'password' => $_POST['password']
            ];

            try {
                
                switch ($_POST['login_type']) {
                    case 'email':
                        $this->loginStrategy = new EmailLogin();
                        break;
                    
                    case 'facebook':
                        $this->loginStrategy = new FacebookLogin();
                        break;
                    
                    case 'google':
                        $this->loginStrategy = new GoogleLogin();
                        break;
                    
                    default:
                        throw new Exception("Invalid login method");
                }
                
                
                $user = $this->loginStrategy->login($userCredentials);

                // Set session variables after successful authentication
                $_SESSION['USER'] = $user;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_type'] = $user['type'];  // Admin or Donor

                
                switch ($_SESSION['user_type']) {
                    case 'Donor':
                        $this->view('donordashboard');  // Load the donor dashboard view directly
                        break;

                    case 'Admin':
                        $this->view('admindashboard');  // Load the admin dashboard view directly
                        break;

                    default:
                        throw new Exception("Unknown user type");
                }

                exit;  
            } catch (Exception $e) {
                error_log($e->getMessage());
                $data['errors'] = ['email' => $e->getMessage()];
            }
        }

        // Load the login view, passing any errors
        $this->view('login', $data);
    }
}
