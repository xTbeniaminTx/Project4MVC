<?php
session_start();

require_once '../vendor/autoload.php';
require_once 'config/config.php';

// Load Helpers
require_once 'helpers/session_helper.php';

require_once('libraries/Database.php');
require_once('controllers/Controller.php');
require_once('controllers/BaseController.php');
require_once('controllers/AdminController.php');

class Router
{
    private $request;
    private $error;

    public function __construct($request)
    {
        $this->request = $request;
    }

    private $routes = [
        "" => ["controllers" => 'BaseController', "method" => 'home'],
        "home" => ["controllers" => 'BaseController', "method" => 'home'],
        "contact" => ["controllers" => 'BaseController', "method" => 'contact'],
        "chapters" => ["controllers" => 'BaseController', "method" => 'chapters'],
        "showChapter" => ["controllers" => 'BaseController', "method" => 'showChapter'],
        "editComment" => ["controllers" => 'BaseController', "method" => 'editComment'],
        "bio" => ["controllers" => 'BaseController', "method" => 'bio'],
        "unapprouve" => ["controllers" => 'BaseController', "method" => 'unapprouve'],
    ];

    private $routesAdmin = [

        "adminView" => ["controllers" => 'AdminController', "method" => 'adminView'],
        "adminComments" => ["controllers" => 'AdminController', "method" => 'adminComments'],
        "approuve" => ["controllers" => 'AdminController', "method" => 'approuve'],
        "adminChapters" => ["controllers" => 'AdminController', "method" => 'adminChapters'],
        "addChapter" => ["controllers" => 'AdminController', "method" => 'addChapter'],
        "editChapter" => ["controllers" => 'AdminController', "method" => 'editChapter'],
        "deleteChapter" => ["controllers" => 'AdminController', "method" => 'deleteChapter'],
        "deleteComment" => ["controllers" => 'AdminController', "method" => 'deleteComment'],
        "adminLogin" => ["controllers" => 'AdminController', "method" => 'adminLogin'],
        "logout" => ["controllers" => 'AdminController', "method" => 'logout'],
    ];


    public function renderController()
    {
        $request = $this->request;

        try {
            if (key_exists($request, $this->routes)) {
                $controller = $this->routes[$request]['controllers'];
                $method = $this->routes[$request]['method'];

                $currentController = new $controller();
                $currentController->$method();
            } elseif (key_exists($request, $this->routesAdmin)) {
//                if (isset($_SESSION['login'])) {
                    $controller = $this->routesAdmin[$request]['controllers'];
                    $method = $this->routesAdmin[$request]['method'];

                    $currentController = new $controller();
                    $currentController->$method();
//                } else {
//                    throw new Exception(' vous n\'avez pas accès, veuillez vous connecter');
//                }
            } else {
                throw new Exception(' 404 aucune page trouvée');
            }
        } catch (Exception $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }
}