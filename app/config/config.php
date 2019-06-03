<?php 

//DB Parameters
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'blog');


//App Root
define('APPROOT', dirname(dirname(__FILE__)));

define('URLROOT', '');

define('SITENAME', 'Blog JF');

$loader = new \Twig\Loader\FilesystemLoader(APPROOT.'/views/pages');
$twig = new \Twig\Environment($loader, [
    'auto_load' => true,
    'debug' => true
]);