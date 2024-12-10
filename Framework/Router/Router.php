<?php

include_once("Framework/Router/Router_List.php");

/*
 *  Enruta el url al controlador y action correspondiente.
 */

class Router
{
    protected static bool $DebugMode = true;

    public static function GetView(string $request, string $method)
    {
        $parsedUrl = parse_url($request);
        $path = self::normalizePath($parsedUrl['path'] ?? '/');

        // La ruta esta almacenada en Router_List.php ?
        if (!isset(Router_List::$Routes[$path])) {
            if (self::$DebugMode) {
                echo "Route not exist: $path";
            }

            return null;
        }

        $view = Router_List::$Routes[$path];
        // El controller y el action existen para esta ruta?
        if (!isset($view['controller']) || !isset($view['action'][$method])) {
            if (self::$DebugMode) {
                echo "Invalid controller or action for route: $path";
            }

            return null;
        }

        $query = [];
        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $query);
        }

        return ["view" => $view, "query" => $query];
    }

    private static function normalizePath(string $path): string
    {
        // Convertir a minúsculas todo y eliminar "/" extra
        $path = strtolower($path);
        $path = trim($path, '/');

        return "/$path";
    }

    public static function GetPage(array $view, array $query = [])
    {
        if ($view === null) {
            echo "View not found.";
            return;
        }

        $controllerName = $view["controller"] . "Controller";

        if (!file_exists("controller/$controllerName.php")) {
            echo "Controller file not found: $controllerName.php";
            return;
        }

        include_once("controller/$controllerName.php");

        if (!class_exists($controllerName)) {
            echo "Controller class not found: $controllerName";
            return;
        }

        $controllerInstance = new $controllerName();

        $httpMethod = $_SERVER['REQUEST_METHOD']; // Detectar método HTTP (GET, POST, etc.)
        $action = $view["action"][$httpMethod] ?? null;

        if ($action === null || !method_exists($controllerInstance, $action)) {
            echo "Action not found for method: $httpMethod in controller: $controllerName";
            return;
        }

        // Ejecutar el método del controlador con o sin parámetros
        if (!empty($query)) {
            $controllerInstance->$action($query);
        } else {
            $controllerInstance->$action();
        }
    }

}

?>