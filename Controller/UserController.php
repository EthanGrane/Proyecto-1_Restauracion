<?php
require_once("Framework/CookieHandler/CookieHandler.php");
require_once("Framework/SessionManager/SessionManager.php");
include_once("Framework/ViewSystem/ViewSystem.php");
include_once("Framework/DAO/DAO.php");

class UserController
{
    public function View()
    {
        self::CheckUserIsLogged();

        ViewSystem::PrintView("User");
    }

    public function ViewLogin()
    {        
        if (SessionManager::GetUserSession()["UserID"] == null) 
        {
            ViewSystem::PrintView("UserLogin");
        } 
        else 
        {
            header("Location: /user");
        }
    }

    public function Login()
    {
        $mail = $_POST["email"];
        $password = $_POST["password"];

        $dao = null;
        try 
        {
            $dao = new DAO(true);
            $validation = $dao->ValidateUser($mail, $password);

            if ($validation) 
            {
                $data = $dao->GetUserDataByMailAndPassword($mail, $password);

                SessionManager::SetUserSession(
                    $data["id_user"],
                    $data["name"],
                    $data["mail"],
                    $data["password"]
                );
                
                header("Location: /user");
            } 
        } 
        catch (Exception $e) 
        {
            SessionManager::SetException($e->getMessage());
        } 
        finally 
        {
            if($dao != null)
                $dao->CloseConnection();
            
            header("Location: /login");
        }

    }

    public function ViewSignin()
    {
        if (SessionManager::GetUserSession()["UserID"] == null) {
            ViewSystem::PrintView("UserSignin");
        } else {
            header("Location: /user");
        }

    }

    public function Signin()
    {
        try 
        {
            $username = $_POST["name"];
            $email = $_POST["email"];
            $password = $_POST["password"];

            $dao = new DAO();
            $dao->AddUserToBBDD($username, $email, $password);

            $data = $dao->GetUserDataByMailAndPassword($email, $password);
            SessionManager::SetUserSession($data["id_user"], $data["name"], $data["mail"], $data["password"]);

            $dao->CloseConnection();

            header("Location: /user");
        } 
        catch (Exception $e) 
        {
            SessionManager::SetException($e->getMessage());
            header("Location: /signin");
        }
    }

    public function Logout()
    {
        header("Location: /login");
        SessionManager::DestroyUserSession();
    }

    private static function CheckUserIsLogged()
    {
        if (SessionManager::GetUserSession()["UserID"] == null) {
            header("Location: /login");
            exit();
        }
    }
}

?>