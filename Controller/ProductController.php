<?php

include_once("Framework/ViewSystem/ViewSystem.php");
include_once("Framework/DAO/ProductDAO.php");
include_once("Framework/ViewSystem/ViewSystem.php");
include_once("Framework/CookieHandler/CookieHandler.php");

class ProductController
{
    public function view()
    {
        // Inicializar variables
        $primaryProducts = [];
        $drinkProducts = [];
        $cart = [];

        try {
            $productDao = new ProductDAO();
            $primaryProducts = $productDao->GetAllProductsByType("Primary");
            $drinkProducts = $productDao->GetAllProductsByType("Drink");
        } catch (Exception $e) {
            $productDao = null;
        } finally {
            $productDao->CloseConnection();
        }

        // Obtener carrito desde cookies
        $cart = CookieHandler::GetCart();

        ViewSystem::PrintView("Menu", null, [
            "primaryProducts" => $primaryProducts, 
            "drinkProducts" => $drinkProducts,
            "cart" => $cart
        ]);
    }
}
