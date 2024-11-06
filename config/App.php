<?php

class App {

    private $controller = 'BaseViewController';  // Default controller
    private $method = 'index';     // Default method

    private function split_url() {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $segments = explode('/', trim($path, '/'));
        return $segments;
    }
    
    public function loadController() {
        $segments = $this->split_url();

        // Set default controller to "BaseviewController" if no controller is specified
        $controllerName = !empty($segments[0]) ? ucfirst($segments[0]) . "Controller" : "BaseviewController";

        $filename = "Controller/" . $controllerName . ".php";
        if (file_exists($filename)) {
            require $filename;
            $this->controller = $controllerName;
        } else {
            echo "404 Controller not found";
            return;  // Exit if controller file not found
        }

        // Instantiate the controller
        if (class_exists($this->controller)) {
            $controller = new $this->controller;

            // Call the method dynamically, defaults to 'index'
            if (method_exists($controller, $this->method)) {
                call_user_func_array([$controller, $this->method], []);
            } else {
                echo "404 Method not found";
            }
        } else {
            echo "404 Controller class not found";
        }
    }
}
