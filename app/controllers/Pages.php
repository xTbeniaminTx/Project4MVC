<?php

  class Pages extends Controller {
    public function __construct() {
         
    }
    
    public function index() {
        require_once '../vendor/autoload.php';
        $loader = new \Twig\Loader\FilesystemLoader(APPROOT.'/views');
        $twig = new \Twig\Environment($loader, [
            'auto_load' => true,
        ]);

        $vue = $twig->load('pages/home.html.twig');
        echo $vue->render(['titre' => "salut"]);
    }
   
    public function about() {
       $this->view('pages/about');
    }
  }