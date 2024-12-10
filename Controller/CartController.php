<?php
require_once("Framework\CookieHandler\CookieHandler.php");

class CartController
{
    
    public function Add($id)
    {
        CookieHandler::AddToCart((int)$id["id"]);
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