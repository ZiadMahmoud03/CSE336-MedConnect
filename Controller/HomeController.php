<?php 

class HomeController  {
    use Controller;
    public function index() {
        //echo "Home Controller is here";
        $this->view("home");
    }
}

