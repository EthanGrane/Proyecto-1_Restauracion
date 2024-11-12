<?php

include_once("./Router.php");

$currentView = Router::GetView($_SERVER['REQUEST_URI']);
Router::GetPage($currentView["view"],$currentView["query"]);

?>