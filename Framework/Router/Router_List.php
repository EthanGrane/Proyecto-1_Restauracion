<?php
class Router_List
{
    public static $Routes = [
        "/" => ["controller" => "Main", "action" => ["GET" => "index"]],

        /* Product Controller */
        "/menu" => ["controller" => "Product", "action" => ["GET" => "view"]],
        
        /* Cart Controller */
        "/cart" => ["controller" => "Cart", "action" => ["GET" => "view"]],
        "/cart/add" => ["controller" => "Cart", "action" => ["POST" => "Add"]],
        "/cart/remove" => ["controller" => "Cart", "action" => ["POST" => "Remove"]],
        "/cart/clear" => ["controller" => "Cart", "action" => ["POST" => "Clear"]],

        /* User Controller */
        "/user" => ["controller" => "User", "action" => ["GET" => "view"]],
        "/login" => ["controller" => "User", "action" => ["POST" => "login"]],
        "/user/signin" => ["controller" => "User", "action" => ["POST" => "sign"]],

        /* ADMIN PANEL */
        "/adminpanel" => ["controller" => "Admin", "action" => ["GET" => "index"]],
        "/adminpanel/users" => ["controller" => "Admin", "action" => ["GET" => "users"]],
        "/api" => ["controller" => "Main", "action" => ["GET" => "api"]],
    ];
}
?>
