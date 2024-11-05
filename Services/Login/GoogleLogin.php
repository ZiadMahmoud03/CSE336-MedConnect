<?php 

class GoogleLogin implements ILoginStrategy {
    public function login(array $userCredentials) {

        $token = $userCredentials['token'];

        // Assume GoogleAuthService handles Google authentication (will be implemented later)
        $user = GoogleAuthService::authenticate($token);

        if ($user) {
            return $user; 
        }

        throw new Exception("Google login failed.");
    }
}
