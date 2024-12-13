<?php

class SessionManager
{
    private static function EnsureSessionStarted()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    #region USER Sessions

    private static function EnsureUserSessionExists()
    {
        self::EnsureSessionStarted();
        if (!array_key_exists("UserID", $_SESSION)) {
            $_SESSION["UserID"] = null;
        }
    }

    public static function GetUserSession()
    {
        self::EnsureSessionStarted();
        self::EnsureUserSessionExists();
        return $_SESSION["UserID"];
    }

    public static function SetUserSession($userID)
    {
        self::EnsureSessionStarted();
        $_SESSION["UserID"] = $userID;
    }

    public static function DestroyUserSession()
    {
        self::EnsureSessionStarted();
        unset($_SESSION["UserID"]);
    }

    #endregion

}

?>