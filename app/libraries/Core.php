<?php
  /*
   * App Core Class
   * Creates URL & loads core controller
   * URL FORMAT - /controller/method/params
   */

  class Core {
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];
    
    public function __construct() {
//       print_r($this -> getUrl());
      
      $url = $this -> getUrl();
      
      // Regarde dans le controleurs pour la premiere valeur index
      if(file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
        //si existant, set comme controleur
        $this->currentController = ucwords($url[0]);
        //uset 0 index
        unset($url[0]);
      }
      
      //require le controleur
      require_once '../app/controllers/' . $this->currentController . '.php';
      
      //initiation de la clase controller
      $this->currentController = new $this->currentController;
      
      //verifier la deuxieme part d url
      if(isset($url[1])) {
        //verifier si la methode existe dans le controller
        if(method_exists($this->currentController, $url[1])) {
          $this->currentMethod = $url[1];
          //uset 1 index
          unset($url[1]);
          
        }
      }
      
      //obtenir les parametres
      $this->params = $url ? array_values($url) : [];
      
      //appeler un calback avec l array de parms
      call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
      
    }
    
    public function getUrl() {
      if(isset($_GET['url'])) {
        $url = rtrim($_GET['url'], '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);
        return $url;
      }
    }
  }