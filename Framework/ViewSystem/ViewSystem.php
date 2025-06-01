<?php

class ViewSystem
{
    public const TEMPLATE_PATH = "Views/Layout/Templates/Template_View.php";
    public const ADMIN_TEMPLATE_PATH = "Views/AdminPanel/AdminTemplate.php";
    public const VIEW_FOLDER = "Views/";
    public const ADMIN_VIEW_FOLDER = "Views/AdminPanel/";
    public const RESOURCES_PATH = "Views/Resources/";

    // Ahora PrintView puede anviar parametros/datos a la view, antes solo mostraba y dentro de la view se aplicaba la logica
    public static function PrintView($viewName, $title = null, $data = [])
    {
        if ($title === null)
            $title = $viewName;

        if (is_array($data)) {
            extract($data);
        }

        $viewPath = self::VIEW_FOLDER . $viewName . ".php";
        require_once(self::TEMPLATE_PATH);
    }


    public static function PrintAdminView($viewName, $title = null)
    {
        if ($title == null)
            $title = $viewName;

        $viewPath = self::ADMIN_VIEW_FOLDER . $viewName . ".php";
        require_once(self::ADMIN_TEMPLATE_PATH);
    }

    public static function PrintProductCard(Product $product)
    {
        $url = $product->product_type . "_" . $product->name . ".png";
        $url = self::RESOURCES_PATH . $url;

        require("Views/Layout/Templates/Template_ProductCard.php");
    }


    public static function PrintCartItem(Product $product)
    {
        $name = $product->name;
        $price = $product->price;
        $type = $product->product_type;
        $id = $product->id;

        require("Views/Layout/Templates/Template_CartItem.php");
    }
}
