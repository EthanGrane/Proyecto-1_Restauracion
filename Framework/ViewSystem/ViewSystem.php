<?php

class ViewSystem
{
    public const TEMPLATE_PATH = "Views\Layout\Templates\Template_View.php";
    public const VIEW_FOLDER = "Views\\";
    public const RESOURCES_PATH = "Views\Resources\\";

    public static function PrintView($viewName, $title = null)
    {
        $viewPath = self::VIEW_FOLDER . $viewName . ".php";
        require_once(self::TEMPLATE_PATH);
    }

    public static function PrintProductCard($name, $description, $type)
    {
        $url = $type . "_" . $name . ".png";
        $url = self::RESOURCES_PATH . $url;

        require("Views\Layout\Templates\Template_ProductCard.php");
    }
}

?>