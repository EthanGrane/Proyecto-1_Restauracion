<?php

/*
 *  Enruta el url al controlador y action correspondiente.
 */

class Router
{
    static $Routes =
    [
        "/" => ["controller" => "Main","action" => "index"],
    ];

    public static function GetView($url)
    {
        $parsedUrl = parse_url($url);
        $view = null;
        if(isset(self::$Routes[$parsedUrl['path']]))
            $view = self::$Routes[$parsedUrl['path']];   

        $query = [];
        if (isset($parsedUrl['query'])) 
        {
            parse_str($parsedUrl['query'], $query);
        }
        
        return ["view" => $view, "query" => $query];
    }

    public static function GetPage($view, $query = [])
    {        
        if($view == null)
        {
            return;
        }

        if(!isset($view["controller"]))
        {
            echo "Controller dosent exist.";
        }
        else
        {
            $controller_name = $view["controller"] . "Controller";
            include_once("controller/$controller_name.php");

            if(class_exists($controller_name))
            {
                $controllerClass = new $controller_name();

                if(isset($view["action"]) && method_exists($controllerClass,$view["action"]))
                {
                    $action = $view["action"];
                }
                else
                {
                    $action = "null";
                }

                if(count($query) != 0)
                    $controllerClass->$action($query);
                else
                    $controllerClass->$action();

            }
            else
            {
                echo "Controller name dosent exist. $controller_name";
            }
        }
    }
}

?>