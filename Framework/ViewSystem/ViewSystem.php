<?php

class ViewSystem
{
    public const TEMPLATE_PATH = "./Framework/ViewSystem/ViewTemplate.php";
    public const VIEW_FOLDER = "Views/";

    public static function PrintView($viewName)
    {
        $viewPath = self::VIEW_FOLDER . $viewName . ".php";
        require_once(self::TEMPLATE_PATH);
    }
}

?>