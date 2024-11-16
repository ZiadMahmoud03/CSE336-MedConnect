<?php

class SignUpController{
    use Controller;

    public function index(){
        $this->view("signup");
    }
}