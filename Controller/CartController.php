<?php

require_once("Framework\CookieHandler\CookieHandler.php");
require_once("Framework\SessionManager\SessionManager.php");
require_once("Framework\DAO\DAO.php");
require_once("Framework/ViewSystem/ViewSystem.php");

class CartController
{
    public function view()
    {
        ViewSystem::PrintView("/Cart");
    }

    public function Checkout()
    {
        $cart = CookieHandler::GetCart();
        if(count($cart) == 0)
        {
            header("Location: /Cart");
            exit;
        }

        $userSession = SessionManager::GetUserSession();
        if($userSession["UserID"] == null)
        {
            header("Location: /Login");
            exit;
        }

        ViewSystem::PrintView("/Checkout");
    }

    public function Add()
    {
        $id = $_POST["id"];

        CookieHandler::AddToCart($id);
        header("Location: /Menu");
    }

    public function Remove()
    {
        $id = $_POST["id"];

        CookieHandler::RemoveFromCart($id);
        header("Location: /Cart");
    }

    public function Clear()
    {
        CookieHandler::ClearCart();
        header("Location: /Cart");
    }

    public function Finish()
    {
        $cart = CookieHandler::GetCart();
        $userSession = SessionManager::GetUserSession();
                
        $dao = new DAO(true);
        $dao->CreateNewOrder($userSession["UserID"],0, $cart);
        $dao->CloseConnection();

        CookieHandler::ClearCart();
        header("Location: /User");
    }
}   

?>