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
        var_dump($_POST["id"]);
        $id = $_POST["id"];

        CookieHandler::AddToCart($id);
        header("Location: /Menu");
    }

    public function Remove($id)
    {
        CookieHandler::RemoveFromCart((int)$id);
        header("Location: /Cart");
    }

    public function Clear()
    {
        CookieHandler::ClearCart();
        header("Location: /Cart");
    }
}   

?>