<?php

  require_once '../app/bootstrap.php';

  //Initialisation de nouveau libraire
  $init = new Core;

/**
 * Twig
 */
require_once dirname(__DIR__) . 'vendor/autoload.php';
Twig_Autoloader::register();


/**
 * Autoloader
 */
spl_autoload_register(function ($class) {
    $root = dirname(__DIR__);   // get the parent directory
    $file = $root . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_readable($file)) {
        require $root . '/' . str_replace('\\', '/', $class) . '.php';
    }
});

  

