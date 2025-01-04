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
    
    public function Checkout()
    {
        $discountCode = $_POST["discountCode"];
        if($discountCode != "")
        {
            $dao = new DAO();
            $isValid = $dao->IsDiscountCodeValid($discountCode);

            if(!$isValid)
            {
                SessionManager::SetException("Codigo de Descuento no es valido.");
                header("Location: /Cart");
                exit;
            }
        }

        $cart = json_decode($_POST["cartItems"],true);
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

    public function Finish()
    {
        $cart = json_decode($_POST["cartItems"],true);
        $userSession = SessionManager::GetUserSession();
        
        $dao = new DAO(true);

        $dao->CreateNewOrder($userSession["UserID"],$_POST["discountCode"], $cart);
        $dao->CloseConnection();

        CookieHandler::ClearCart();
        header("Location: /User");
    }
}   

?>