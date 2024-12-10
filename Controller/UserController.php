<?php
require_once("Framework\CookieHandler\CookieHandler.php");
include_once("Framework/ViewSystem/ViewSystem.php");

class UserController
{
    public function View()
    {
        ViewSystem::PrintView("User");
    }

    public function Login()
    {
        ViewSystem::PrintView("UserLogin");
    }

    public function Sign()
    {
    }
}   

?>