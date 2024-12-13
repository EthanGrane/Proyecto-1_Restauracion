<?php
require_once("Framework\CookieHandler\CookieHandler.php");
require_once("Framework\SessionManager\SessionManager.php");
include_once("Framework/ViewSystem/ViewSystem.php");

class UserController
{
    public function View()
    {
        self::CheckUserIsLogged();

        ViewSystem::PrintView("User");
    }

    public function ViewLogin()
    {
        ViewSystem::PrintView("UserLogin");
    }

    public function Login()
    {
        SessionManager::SetUserSession(
            "0"
        );
        
        echo "Verifing login...";
    }

    public function ViewSignin()
    {
        ViewSystem::PrintView("UserSignin");
    }

    public function Signin()
    {
        SessionManager::SetUserSession(
            "0"
        );

        echo "Verifing signin...";
    }

    public function Logout()
    {
        header("Location: \login");
        SessionManager::DestroyUserSession();
    }

    private static function CheckUserIsLogged()
    {
        // Si la session es null (no estas registrado)
        if(SessionManager::GetUserSession() == null)
        {
            header("Location: \login");
            exit();
        }
    }
}   

?>