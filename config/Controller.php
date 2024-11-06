<?php

trait Controller {
    public function view($name,$data = []) {
        // Extract data to make variables accessible in the view
        //extract($data); , 
        if(!empty($data))
			extract($data);
        // Construct the path to the view file
        $viewFile = "./View/" . ucfirst($name) . "View.php";
       // echo $viewFile;  // Print out the view file path
        // Check if the view file exists and include it
        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            echo "404 View not found";
        }
    }
}
