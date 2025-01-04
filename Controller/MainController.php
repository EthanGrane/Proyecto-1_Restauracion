<?php

include_once("Framework/ViewSystem/ViewSystem.php");

class MainController
{
    public function index()
    {
        ViewSystem::PrintView("Index");
    }

    public function api()
    {
        include_once("Services/API.php");
    }

    public function StatusCode()
    {
        ViewSystem::PrintView("StatusCode");
    }
}

?>