<?php
class Router_List
{
    public static $Routes =
    [
        "/" =>                  ["controller" => "Main","action" => "index"],
        "/Menu" =>          ["controller" => "Product","action" => "view"],
        "/Cart" =>          ["controller" => "Product","action" => "buy"],
        
        /* ADMIN PANEL ROUTES */
        "/AdminPanel" =>        ["controller" => "Admin","action" => "index"],
        "/AdminPanel/Users" =>        ["controller" => "Admin","action" => "users"],
        "/api" =>               ["controller" => "Main","action" => "api"],
    ];
}
?>