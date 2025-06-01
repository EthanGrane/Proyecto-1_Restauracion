<?php

require_once("Framework/DAO/OrderDAO.php");
require_once("Framework/DAO/ProductDAO.php");
require_once("Framework/DAO/DiscountDAO.php");

class OrderController
{

    public function CreateNewOrder($userID, $discountCode, $productIdsArray)
    {
        $date = date("Y-m-d");

        $orderDao = new OrderDAO();
        $productDao = new ProductDAO();
        $discountDao = new DiscountDAO();

        // Recoje toda la informacion sobre los productos. (mismo codigo que en Cart.php seccion try{})
        $cartItems = [];
        $cartData = $productDao->GetProductsDataByIDs($productIdsArray);
        foreach ($productIdsArray as $productId) {
            for ($i = 0; $i < count($cartData); $i++) {
                if ($productId == $cartData[$i]["id"]) {
                    array_push($cartItems, $cartData[$i]);
                    continue;
                }
            }
        }

        // Calcula el precio total antes del IVA
        $totalPrice = 0.0;
        for ($i = 0; $i < count($cartItems); $i++) {
            $sum = $cartItems[$i]["price"];
            $totalPrice += $sum;
            echo ("Total Price += $sum");
        }
        echo ("Total Price before VAT: $totalPrice");

        // IVA: Agregar el 10% de IVA al total
        $totalPriceWithVAT = $totalPrice * 1.1; // IVA del 10%
        echo ("Total Price with VAT: $totalPriceWithVAT");

        // Resta el descuento al precio total (con IVA ya aplicado)
        $total_price = $totalPriceWithVAT;

        if ($discountCode != null) {
            $discountData = $discountDao->GetDiscountDataByCode($discountCode);
            $discountValue = 0.0;

            echo ("Discount product_type:" . $discountData["discount_type"]);
            echo ("Discount Value:" . $discountData["value"]);

            if ($discountData["discount_type"] == 0) {
                // Descuento en porcentaje
                $discountValue = $total_price * ($discountData["value"] * 0.01);
                $discountValue = number_format($discountValue, 2, '.', '');
            } elseif ($discountData["discount_type"] == 1) {
                // Descuento fijo
                $discountValue = $discountData["value"];
                $discountValue = number_format($discountValue, 2, '.', '');
            }

            // Aplica el descuento al precio con IVA
            $total_price -= $discountValue;
            echo ("Final Price with discount: $total_price");
        } else {
            $discountData["id"] = null;
        }

        $total_price = number_format($total_price, 2, '.', '');

        $orderId = $orderDao->CreateOrder($userID, $discountData["id"], $total_price, $date);

        // Inserta los productos en la orden
        for ($i = 0; $i < count($productIdsArray); $i++) {
            $orderDao->CreateOrderProduct($productIdsArray[$i], $orderId);
        }
    }
}
