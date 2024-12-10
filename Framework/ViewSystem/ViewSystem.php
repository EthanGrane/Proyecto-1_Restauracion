<?php

class ViewSystem
{
    public const TEMPLATE_PATH = "Views\Layout\Templates\Template_View.php";
    public const VIEW_FOLDER = "Views\\";
    public const RESOURCES_PATH = "Views\Resources\\";

    public static function PrintView($viewName, $title = null)
    {
        if($title == null)
            $title = $viewName;
        
        $viewPath = self::VIEW_FOLDER . $viewName . ".php";
        require_once(self::TEMPLATE_PATH);
    }

    public static function PrintProductCard($name, $description, $type, $id)
    {
        $url = $type . "_" . $name . ".png";
        $url = self::RESOURCES_PATH . $url;

        require("Views\Layout\Templates\Template_ProductCard.php");
    }

    public static function PrintCartItem($data)
    {
        $name = $data["name"];
        $price = $data["price"];
        $type = $data["type"];
        $id = $data["id_products"];
        
        require("Views\Layout\Templates\Template_CartItem.php");
    }
}

?>