<?php

class CookieHandler
{
    #region Private Methods
    private static function CreateCookie($cookieName, $values, $expire = 3600)
    {
        if (is_array($values)) {
            $values = json_encode($values);
        }

        setcookie($cookieName, $values, time() + $expire, "/", "", false, true);
    }

    private static function GetCookie($cookieName)
    {
        if (isset($_COOKIE[$cookieName])) {
            $value = $_COOKIE[$cookieName];
            $decoded = json_decode($value, true);
            return $decoded ?? $value;
        }

        return null;
    }

    private static function DeleteCookie($cookieName)
    {
        setcookie($cookieName, "", time() - 3600, "/");
        unset($_COOKIE[$cookieName]);
    }

    #endregion
    
    public static function AddToCart($productId)
    {
        $cart = self::GetCookie('user_cart') ?? [];

        $cartArray = $cart;
        array_push($cartArray,$productId);

        var_dump($productId);

        self::CreateCookie('user_cart', $cartArray, 3600 * 24 * 7);
    }
    
    public static function GetCart()
    {
        return self::GetCookie('user_cart') ?? [];
    }

    public static function RemoveFromCart($productId)
    {
        $cart = self::GetCookie('user_cart') ?? [];
        $cart = array_filter($cart, function ($id) use ($productId) {
            return $id !== $productId;
        });
        self::CreateCookie('user_cart', $cart, 3600 * 24 * 7); // 7 días
    }

    public static function ClearCart()
    {
        self::DeleteCookie('user_cart');
    }
}

?>
