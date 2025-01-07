<?php
    /*
     * Sensible a mayusculas
     */
class Router_List
{
    public static $Routes = [
        "/" => ["controller" => "Main", "action" => ["GET" => "index"]],
        "/aboutus" => ["controller" => "Main", "action" => ["GET" => "about"]],
        "/location" => ["controller" => "Main", "action" => ["GET" => "location"]],
        "/statuscode" => ["controller" => "Main", "action" => ["GET" => "StatusCode"]],

        /* Product Controller */
        "/menu" => ["controller" => "Product", "action" => ["GET" => "view"]],
        
        /* Cart Controller */
            // GET
        "/cart" => ["controller" => "Cart", "action" => ["GET" => "view"]],
        
            // POST
        "/cart/add" => ["controller" => "Cart", "action" => ["POST" => "Add"]],
        "/cart/remove" => ["controller" => "Cart", "action" => ["POST" => "Remove"]],
        "/cart/clear" => ["controller" => "Cart", "action" => ["POST" => "Clear"]],
        "/cart/checkout" => ["controller" => "Cart", "action" => ["POST" => "Checkout"]],
        "/cart/finish" => ["controller" => "Cart", "action" => ["POST" => "Finish"]],

        /* User Controller */
            // GET
        "/user" => ["controller" => "User", "action" => ["GET" => "view"]],
        "/login" => ["controller" => "User", "action" => ["GET" => "viewlogin"]],
        "/signin" => ["controller" => "User", "action" => ["GET" => "viewsignin"]],
        "/user/logout" => ["controller" => "User", "action" => ["GET" => "logout"]],
            // POST
        "/user/signin" => ["controller" => "User", "action" => ["POST" => "signin"]],
        "/user/login" => ["controller" => "User", "action" => ["POST" => "login"]],

        /* ADMIN PANEL */
            // GET
        "/adminpanel" => ["controller" => "Admin", "action" => ["GET" => "index"]],
        "/adminpanel/users" => ["controller" => "Admin", "action" => ["GET" => "users"]],
        "/adminpanel/products" => ["controller" => "Admin", "action" => ["GET" => "products"]],
        "/adminpanel/discounts" => ["controller" => "Admin", "action" => ["GET" => "discounts"]],
        "/api" => ["controller" => "Main", "action" => ["GET" => "api", "POST" => "api"]],
    ];
}
?>
