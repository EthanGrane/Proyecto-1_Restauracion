<?php
require_once("Framework\CookieHandler\CookieHandler.php");
include_once("Framework/ViewSystem/ViewSystem.php");

class UserController
{
    public function View()
    {
        ViewSystem::PrintView("User");
    }

    public function Log()
    {
    }

    public function Sign()
    {
    }
}   

?>