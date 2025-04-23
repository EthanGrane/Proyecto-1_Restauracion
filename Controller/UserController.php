<?php
require_once("Model/User.php");
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
        if (SessionManager::GetUserSession()["UserID"] == null) {
            ViewSystem::PrintView("UserLogin");
        } else {
            header("Location: /user");
        }
    }

    public function Login()
    {
        $mail = $_POST["email"];
        $password = $_POST["password"];

        $dao = null;
        try {
            $dao = new DAO(true);
            $validation = $dao->ValidateUser($mail, $password);

            if ($validation) {
                $data = $dao->GetUserDataByMailAndPassword($mail, $password);

                SessionManager::SetUserSession(
                    $data["id"],
                    $data["name"],
                    $data["mail"],
                    $data["password"]
                );

                header("Location: /user");
            }
        } catch (Exception $e) {
            SessionManager::SetException($e->getMessage());
        } finally {
            if ($dao != null)
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
        try {
            $name = $_POST["name"];
            $mail = $_POST["mail"];
            $password = $_POST["password"];

            // Crear el objeto User
            $user = new User($name, $mail, $password);
            $dao = new DAO();

            // Validar los datos del usuario (esto está ahora en el modelo User)
            $user->ValidateUserData($dao->GetConnection());

            // Añadir usuario a la base de datos
            $dao->AddUserToBBDD($user);

            // Obtener los datos del usuario recién creado
            $data = $dao->GetUserDataByMailAndPassword($mail, $password);
            SessionManager::SetUserSession($data["id"], $data["name"], $data["mail"], $data["password"]);

            $dao->CloseConnection();

            header("Location: /user");
        } catch (Exception $e) {
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