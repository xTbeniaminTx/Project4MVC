<?php

  class Pages extends Controller {
    public function __construct() {
         
    }
    
    public function index() {
        require_once '../vendor/autoload.php';
        $loader = new \Twig\Loader\FilesystemLoader(APPROOT.'/views/pages');
        $twig = new \Twig\Environment($loader, [
            'auto_load' => true,
        ]);

        $vue = $twig->load('home.html.twig');
        echo $vue->render([
            'titre' => "salut",
            'ben' => 'Beniamin Tolan'
        ]);
    }
   
    public function about() {
       $this->view('pages/about');
    }
  }