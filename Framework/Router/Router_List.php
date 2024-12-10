<?php
class Router_List
{
    public static $Routes =
    [
        "/" =>                  ["controller" => "Main","action" => "index"],

        /* Product Controller */
        "/Menu" =>          ["controller" => "Product","action" => "view"],
        "/Cart" =>          ["controller" => "Product","action" => "buy"],
        
        /* Cart Controller */
        "/Cart/Add" =>          ["controller" => "Cart","action" => "Add"],
        "/Cart/Remove" =>          ["controller" => "Cart","action" => "Remove"],
        "/Cart/Clear" =>          ["controller" => "Cart","action" => "Clear"],
        
        /* User Contorller */
        "/User" =>                  ["controller" => "User","action" => "View"],
        "/User/Login" =>            ["controller" => "User","action" => "Log"],
        "/User/Signin" =>           ["controller" => "User","action" => "Sign"],

        /* ADMIN PANEL */
        "/AdminPanel" =>        ["controller" => "Admin","action" => "index"],
        "/AdminPanel/Users" =>        ["controller" => "Admin","action" => "users"],
        "/api" =>               ["controller" => "Main","action" => "api"],
    ];
}
?>