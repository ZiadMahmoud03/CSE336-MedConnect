<?php

trait Controller {
    public function view($name,$data = []) {
        // Extract data to make variables accessible in the view
        if(!empty($data))
			extract($data);
        
        $viewFile = "./View/" . ucfirst($name) . "View.php";
       // echo $viewFile;  // Print out the view file path
        
        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            echo "404 View not found";
        }
    }
}
