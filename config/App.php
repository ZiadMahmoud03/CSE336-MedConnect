<?php
class App {

private $controller = 'HomeController';  // Default controller
private $method = 'index';     // Default method
private $params = [];          // Parameters for method

private function split_url() {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $segments = explode('/', trim($path, '/'));
    return $segments;
}

public function loadController() {
    $segments = $this->split_url();

    // Set default controller to "BaseViewController" if no controller is specified
    $controllerName = !empty($segments[0]) ? ucfirst($segments[0]) . "Controller" : "HomeController";

    // Check if controller exists
    $filename = "Controller/" . $controllerName . ".php";
    if (file_exists($filename)) {
        require_once $filename;
        $this->controller = $controllerName;
    } else {
        echo "404 Controller not found";
        return;
    }

    // Instantiate the controller
    if (class_exists($this->controller)) {
        $controller = new $this->controller;

        // Check if a method is specified and exists
        if (!empty($segments[1])) {
            $this->method = $segments[1];
            array_shift($segments); // Remove method from segments
        }

        // If there are more than two segments, the rest are considered parameters
        $this->params = !empty($segments) ? $segments : [];

        // Call the method dynamically with parameters
        if (method_exists($controller, $this->method)) {
            call_user_func_array([$controller, $this->method], $this->params);
        } else {
            echo "404 Method not found";
        }
    } else {
        echo "404 Controller class not found";
    }
}
}
