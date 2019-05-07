<?php 

require_once 'config/config.php';


spl_autoload_register(function ($class) {
    $root = dirname(APPROOT);   // get the parent directory
    $file = $root . '/app/controllers' . str_replace('\\', '/', $class) . '.php';
    if (is_readable($file)) {
        require $root . '/app/controllers' . str_replace('\\', '/', $class) . '.php';
    }
});