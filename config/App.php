<?php
class App
{
	private $controller = 'Home';
	private $method 	= 'index';

	private function splitURL()
	{
		$URL = $_GET['url'] ?? 'home';
		$URL = explode("/", trim($URL,"/"));
		return $URL;	
	}

	public function loadController()
	{
		$URL = $this->splitURL();

		/** select controller **/
        $controllerName = ucfirst($URL[0]). 'Controller';
		$filename = "Controller/". $controllerName.".php";
		if(file_exists($filename))
		{
			require $filename;
			$this->controller = $controllerName;
			unset($URL[0]);
		}else{

			// $filename = "../app/controllers/_404.php";
			// require $filename;
			// $this->controller = "_404";
            echo "404 Controller not found";
            return;
		}

		$controller = new $this->controller;

		/** select method **/
		if(!empty($URL[1]))
		{
			if(method_exists($controller, $URL[1]))
			{
				$this->method = $URL[1];
				unset($URL[1]);
			}	
		}

		call_user_func_array([$controller,$this->method], $URL);

	}	

}


