<?php

class SessionManager
{
    private static function EnsureSessionStarted()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    private static function EnsureUserSessionExists()
    {
        self::EnsureSessionStarted();
        if (!array_key_exists("UserID", $_SESSION)) {
            $_SESSION["UserID"] = null;
        }
        if (!array_key_exists("UserName", $_SESSION)) {
            $_SESSION["UserName"] = null;
        }
        if (!array_key_exists("UserMail", $_SESSION)) {
            $_SESSION["UserMail"] = null;
        }
        if (!array_key_exists("Exception", $_SESSION)) {
            $_SESSION["Exception"] = null;
        }
    }

    #region USER Sessions

    public static function GetUserSession()
    {
        self::EnsureSessionStarted();
        self::EnsureUserSessionExists();

        return [
            "UserID" => $_SESSION["UserID"],
            "UserName" => $_SESSION["UserName"],
            "UserMail" => $_SESSION["UserMail"]
        ];
    }

    public static function SetUserSession($userID, $userName, $userMail)
    {
        self::EnsureSessionStarted();
        $_SESSION["UserID"] = $userID;
        $_SESSION["UserName"] = $userName;
        $_SESSION["UserMail"] = $userMail;
    }

    public static function DestroyUserSession()
    {
        self::EnsureSessionStarted();
        unset($_SESSION["UserID"]);
        unset($_SESSION["UserName"]);
        unset($_SESSION["UserMail"]);
    }

    #endregion

    #region Exceptions

    public static function SetException($value)
    {
        self::EnsureSessionStarted();
        self::EnsureUserSessionExists();

        $_SESSION["Exception"] = $value;
    }

    public static function GetException()
    {
        self::EnsureSessionStarted();
        self::EnsureUserSessionExists();

        $value = $_SESSION["Exception"];
        $_SESSION["Exception"] = null;
        return $value;
    }

    #endregion
}

?>