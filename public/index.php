<?php

if($_GET)
{
    $request = $_GET['action'];
}
else
{
    $request = "";
}

require_once('../app/Router.php');

$routeur = new Router($request);
$routeur->renderController();