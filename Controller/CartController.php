<?php

require_once("Framework/CookieHandler/CookieHandler.php");
require_once("Framework/SessionManager/SessionManager.php");
require_once("Framework/ViewSystem/ViewSystem.php");
require_once("Controller/OrderController.php");
require_once("Framework/DAO/DAO.php");

require_once("Framework/DAO/ProductDAO.php");
require_once("Framework/DAO/DiscountDAO.php");
require_once("Framework/DAO/OrderDAO.php");

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
        if ($discountCode != "") {
            $dao = new DAO();
            $isValid = $dao->IsDiscountCodeValid($discountCode);

            if (!$isValid) {
                SessionManager::SetException("Código de descuento no es válido.");
                header("Location: /Cart");
                exit;
            }
        }

        $cart = json_decode($_POST["cartItems"], true);
        if (count($cart) == 0) {
            header("Location: /Cart");
            exit;
        }

        if ($discountCode != "") {
            if (count($cart) <= 3) {
                SessionManager::SetException("Códigos de descuento aplicables con más de 3 productos.");
                header("Location: /Cart");
            }
        }

        $userSession = SessionManager::GetUserSession();
        if ($userSession["UserID"] == null) {
            header("Location: /Login");
            exit;
        }

        $cartItems = [];
        $discountValue = 0;
        $totalPrice = 0.0;
        $iva = 0.0;
        $totalConIVA = 0.0;
        $precioFinal = 0.0;
        $discountData = null;

        try {
            $productDao = new ProductDAO();
            $discountDao = new DiscountDAO();

            $cartData = $productDao->GetProductsDataByIDs($cart);

            if ($discountCode != "") {
                $discountData = $discountDao->GetDiscountDataByCode($discountCode);
            }

            foreach ($cart as $productId) {
                foreach ($cartData as $data) {
                    if ($productId == $data["id"]) {
                        $cartItems[] = $data;
                        $totalPrice += $data["price"];
                        break;
                    }
                }
            }

            // Cálculo de descuento
            if (!empty($discountCode) && isset($discountData)) {
                if ($discountData["discount_type"] == 0) {
                    $discountValue = number_format($totalPrice * ($discountData["value"] / 100), 2, '.', '');
                } elseif ($discountData["discount_type"] == 1) {
                    $discountValue = number_format($discountData["value"], 2, '.', '');
                }
            }

            $iva = number_format($totalPrice * 0.1, 2, '.', '');
            $totalConIVA = number_format($totalPrice * 1.1, 2, '.', '');
            $precioFinal = number_format($totalConIVA - $discountValue, 2, '.', '');
        } catch (Exception $e) {
            $cartItems = [];
            $discountValue = 0;
            $totalPrice = 0.0;
            $iva = 0.0;
            $totalConIVA = 0.0;
            $precioFinal = 0.0;
        } finally {
            $productDao->CloseConnection();
            $discountDao->CloseConnection();
        }

        ViewSystem::PrintView("/Checkout", null, data: [
            "userSession" => $userSession,
            "cartItems" => $cartItems,
            "discountCode" => $discountCode,
            "discountValue" => $discountValue,
            "totalPrice" => $totalPrice,
            "iva" => $iva,
            "totalConIVA" => $totalConIVA,
            "precioFinal" => $precioFinal
        ]);
    }

    public function Finish()
    {
        $cart = json_decode($_POST["cartItems"], true);
        $userSession = SessionManager::GetUserSession();
        var_dump($userSession);

        $orderController = new OrderController();
        $orderController->CreateNewOrder($userSession["UserID"], $_POST["discountCode"], $cart);

        CookieHandler::ClearCart();
        header("Location: /User");
    }
}
