<?php

include_once("Framework/ViewSystem/ViewSystem.php");

class ProductController
{
    public function view()
    {
        ViewSystem::PrintView("Products", "Menu");
    }

    public function buy()
    {
        ViewSystem::PrintView("Cart", "Cart");
    }
}

?>