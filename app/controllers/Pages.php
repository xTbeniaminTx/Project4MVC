<?php

  class Pages extends Controller {
    public function __construct() {
         
    }
    
    public function index() {

        $loader = new \Twig\Loader\FilesystemLoader(APPROOT.'/views/pages');
        $twig = new \Twig\Environment($loader, [
            'auto_load' => true,
            'debug' => true
        ]);

        $vue = $twig->load('home.html.twig');
        echo $vue->render([
            'titre' => "salut",
            'ben' => 'Beniamin Tolan'
        ]);
    }
   
    public function contact() {
        $loader = new \Twig\Loader\FilesystemLoader(APPROOT.'/views/pages');
        $twig = new \Twig\Environment($loader, [
            'auto_load' => true,
            'debug' => true
        ]);

        $vue = $twig->load('contact.html.twig');
        echo $vue->render([
            'titre' => "salut",
            'ben' => 'Beniamin Tolan'
        ]);
    }
  }