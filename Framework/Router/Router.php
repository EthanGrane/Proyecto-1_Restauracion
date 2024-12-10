<?php

include_once("Framework/Router/Router_List.php");

/*
 *  Enruta el url al controlador y action correspondiente.
 */

class Router
{
    static bool $DebugMode = true;

    public static function GetView($url)
    {
        $parsedUrl = parse_url($url);
        $view = null;
        if(isset(Router_List::$Routes[$parsedUrl['path']]))
        {
            $view = Router_List::$Routes[$parsedUrl['path']];   
        }
        else
        {
            if(self::$DebugMode)
            {
                echo "Route not exist.";
            }
        }

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
                {
                    $controllerClass->$action($query);
                }
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