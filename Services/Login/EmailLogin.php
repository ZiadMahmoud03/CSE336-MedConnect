<?php 

class EmailLogin implements ILoginStrategy{
    public function login(array $userCredentials) {
        $email = $userCredentials['email'];
        $password = $userCredentials['password'];

        // Waiting For UserModel
        $user = UserModel::findByEmail($email);

        if ($user && password_verify($password, $user->password)) {
            return $user; 
        }

        throw new Exception("Invalid email or password.");
    }
}