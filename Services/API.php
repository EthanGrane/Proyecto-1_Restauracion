<?php

function GetDB()
{
    $users = [
        ["id" => 1, "nombre" => "admin", "password" => "12345"],
        ["id" => 2, "nombre" => "pepe", "password" => "54321"],
        ["id" => 3, "nombre" => "maria", "password" => "15243"],
    ];

    return $users;
}

function GetUserById($id)
{
    $users = GetDB();

    foreach ($users as $k) {
        if ($k["id"] == $id)
            return $k;
    }

    return null;
}

function SendResponse($data, $status = 200)
{
    http_response_code($status);
    echo json_encode([
        "status" => $status,
        "data" => $data,
    ]);
}

function GET()
{
    if (isset($_GET["id"])) {
        $result = GetUserById($_GET["id"]);

        if (isset($result)) {
            SendResponse($result);
        } else {
            SendResponse(null, 404);
        }
    }
}

function POST()
{
    $post = json_decode(file_get_contents("php://input",true));
    
    print_r($post);
}

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



$method = $_SERVER["REQUEST_METHOD"];

$response = "";
switch ($method) {
    case "GET":
        GET();
        break;
    case "POST":
        POST();
        break;
    default:
        SendResponse(null);
        break;
}

?>