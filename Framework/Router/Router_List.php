<?php
class Router_List
{
    public static $Routes = [
        "/" => ["controller" => "Main", "action" => ["GET" => "index"]],

        "/404" => ["controller" => "Main", "action" => ["GET" => "PageNotFound"]],

        /* Product Controller */
        "/menu" => ["controller" => "Product", "action" => ["GET" => "view"]],
        
        /* Cart Controller */
        // GET
        "/cart" => ["controller" => "Cart", "action" => ["GET" => "view"]],
        // POST
        "/cart/add" => ["controller" => "Cart", "action" => ["POST" => "Add"]],
        "/cart/remove" => ["controller" => "Cart", "action" => ["POST" => "Remove"]],
        "/cart/clear" => ["controller" => "Cart", "action" => ["POST" => "Clear"]],

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
        "/api" => ["controller" => "Main", "action" => ["GET" => "api"]],
    ];
}
?>
