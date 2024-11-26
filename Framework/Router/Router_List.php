<?php
class Router_List
{
    public static $Routes =
    [
        "/" =>                  ["controller" => "Main","action" => "index"],
        "/Products" =>          ["controller" => "Product","action" => "view"],
        
        /* ADMIN PANEL ROUTES */
        "/AdminPanel" =>        ["controller" => "Admin","action" => "index"],
        "/AdminPanel/Users" =>        ["controller" => "Admin","action" => "users"],
        "/api" =>               ["controller" => "Main","action" => "api"],
    ];
}
?>