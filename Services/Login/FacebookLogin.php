<?php

class FacebookLogin implements ILoginStrategy {
    public function login(array $userCredentials) {
        
        $token = $userCredentials['token'];

        // Assume FacebookAuthService handles Facebook authentication (will be implemented later)
        $user = FacebookAuthService::authenticate($token);

        if ($user) {
            return $user; 
        }

        throw new Exception("Facebook login failed.");
    }
}
