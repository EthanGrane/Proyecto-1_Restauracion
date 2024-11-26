<?php

class ViewSystem
{
    public const TEMPLATE_PATH = "Views\Layout\Templates\Template_View.php";
    public const VIEW_FOLDER = "Views\\";

    public static function PrintView($viewName)
    {
        $viewPath = self::VIEW_FOLDER . $viewName . ".php";
        require_once(self::TEMPLATE_PATH);
    }

    public static function PrintProductCard($name, $description, $url)
    {
        require("Views\Layout\Templates\Template_ProductCard.php");
    }
}

?>