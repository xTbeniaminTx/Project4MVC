<?php
session_start ();

require_once '../vendor/autoload.php';
require_once 'config/config.php';
include_once('controllers/BaseController.php');
include_once('controllers/AdminController.php');

class Router
{
	private $request;

	private $routes = 	[ 
							"" 				=> ["controllers"=> 'BaseController', "method" => 'home'],
							"home" 			=> ["controllers"=> 'BaseController', "method" => 'home'],
							"contact" 			=> ["controllers"=> 'BaseController', "method" => 'contact'],
						];

	private $routesAdmin = 	[ 
							"adminView" 		=> ["controllers"=> 'AdminController', "method" => 'adminView']
						];

	public function __construct($request)
	{
		$this->request = $request;
	}

	public function renderController()
	{
		$request = $this->request;

		try
		{
			if(key_exists($request, $this->routes))
			{
				$controller = $this->routes[$request]['controllers'];
				$method 	= $this->routes[$request]['method'];
				
				$currentController = new $controller();
				$currentController->$method();
			}
			elseif (key_exists($request, $this->routesAdmin)) 
			{
				if (isset($_SESSION['login'])) 
				{
					$controller = $this->routesAdmin[$request]['controllers'];
					$method 	= $this->routesAdmin[$request]['method'];
					
					$currentController = new $controller();
					$currentController->$method();
				}
				else
				{
					throw new Exception(' vous n\'avez pas accès, veuillez vous connecter');
				}
			}
			else
			{
				throw new Exception(' 404 aucune page trouvée');
			}
		}
		catch(Exception $e)
		{
			$messageError = new Frontend();
			$message = $messageError->error($e);
		}
	}
}