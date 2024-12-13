<?php
include_once("Framework/Router/Router.php");

$currentView = Router::GetView($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

if ($currentView) 
{
    Router::GetPage($currentView["view"], $currentView["query"]);
} 
?>