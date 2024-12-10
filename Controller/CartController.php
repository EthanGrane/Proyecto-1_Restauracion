<?php

require_once("Framework\CookieHandler\CookieHandler.php");
require_once("Framework/ViewSystem/ViewSystem.php");

class CartController
{
    public function view()
    {
        ViewSystem::PrintView("Cart");
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
}   

?>