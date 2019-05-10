<?php 

define('APPROOT', dirname(dirname(__FILE__)));

define('URLROOT', '');

define('SITENAME', 'Blog Jean F');

$loader = new \Twig\Loader\FilesystemLoader(APPROOT.'/views/pages');
$twig = new \Twig\Environment($loader, [
    'auto_load' => true,
    'debug' => true
]);