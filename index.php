<?php
include_once("Framework/Router/Router.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$currentView = Router::GetView($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

if ($currentView) 
{
    Router::GetPage($currentView["view"], $currentView["query"]);
} 
?>