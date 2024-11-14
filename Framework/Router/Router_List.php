<?php
class Router_List
{
    public static $Routes =
    [
        "/" =>                  ["controller" => "Main","action" => "index"],
        "/Products" =>          ["controller" => "Product","action" => "view"],
        "/AdminPanel" =>        ["controller" => "Admin","action" => "index"],
        "/api" =>               ["controller" => "Main","action" => "api"],
    ];
}
?>