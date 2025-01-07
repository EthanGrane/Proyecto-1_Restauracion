<?php

// Definir los headers de la API
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Requerir el archivo DAO
require_once("Framework/DAO/DAO.php");

// Función para enviar la respuesta de la API
function SendResponse($data, $status = 200)
{
    http_response_code($status);
    echo json_encode([
        "status" => $status,
        "data" => $data,
    ]);
}

#region USER
// Obtener todos los usuarios solo si el usuario es un administrador
function GetAllUsers()
{
    if (isset($_GET["mail"]) && isset($_GET["password"])) {
        $userMail = $_GET["mail"];
        $userPassword = $_GET["password"];

        $dao = new DAO();

        // Verificar el usuario con las credenciales
        $user = $dao->GetUserDataByMailAndPassword($userMail, $userPassword);
        if ($user == null) {
            SendResponse("Usuario no encontrado o credenciales incorrectas", 404);
            return;
        }

        // Solo los administradores pueden obtener todos los usuarios
        if ($user["role"] == 1) {
            $users = $dao->GetAllUsersFromBBDD();
            SendResponse($users);
        } else {
            SendResponse("No tienes permisos para realizar esta acción", 403);
        }

        $dao->CloseConnection();
    } else {
        SendResponse("Faltan parámetros", 400);
    }
}

function EditUser()
{
    if (isset($_GET["adminMail"]) && isset($_GET["adminPassword"]) && isset($_GET["userName"]) && isset($_GET["userMail"]) && isset($_GET["userRole"])) {
        $adminMail = $_GET["adminMail"];
        $adminPassword = $_GET["adminPassword"];
        $userName = $_GET["userName"];
        $userMail = $_GET["userMail"];
        $userRole = $_GET["userRole"];

        if (isset($_GET["userPassword"]))
            $userPassword = $_GET["userPassword"];

        $dao = new DAO();

        $user = $dao->GetUserDataByMailAndPassword($adminMail, $adminPassword);
        if ($user == null) {
            SendResponse("Admin not found", 404);
            return;
        }
        if ($user["role"] != 1) {
            SendResponse("User is not admin", 403);
            return;
        }

        if ($userPassword == "")
            $updatedUser = $dao->UpdateUserWithoutPassword($userName, $userMail, $userRole);
        else
            $updatedUser = $dao->UpdateUser($userName, $userMail, $userPassword, $userRole);

        SendResponse($updatedUser);
        $dao->CloseConnection();

    } else {
        SendResponse("Faltan parámetros", 400);
    }
}

#endregion

#region PRODUCTS

function GetAllProducts()
{
    $dao = new DAO();

    $data = $dao->GetAllProducts();
    SendResponse($data);

    $dao->CloseConnection();
}

function EditProduct()
{
    if (
        isset($_GET["adminMail"]) &&
        isset($_GET["adminPassword"]) &&
        isset($_GET["productName"]) &&
        isset($_GET["productDescription"]) &&
        isset($_GET["productPrice"]) &&
        isset($_GET["productType"]) &&
        isset($_GET["productId"]) &&
        isset($_GET["productState"])
    ) {
        $adminMail = $_GET["adminMail"];
        $adminPassword = $_GET["adminPassword"];
        $productName = $_GET["productName"];
        $productDescription = $_GET["productDescription"];
        $productPrice = $_GET["productPrice"];
        $productType = $_GET["productType"];
        $productId = $_GET["productId"];
        $productState = $_GET["productState"];

        $dao = new DAO();

        if (VerifyAdmin($adminMail, $adminPassword)) {
            $updatedProduct = $dao->UpdateProduct($productId, $productName, $productDescription, $productPrice, $productType, $productState);
            if ($updatedProduct) {
                SendResponse("Product updated successfully", 200);
            } else {
                SendResponse("Failed to update product", 500);
            }
        }
        $dao->CloseConnection();

    } else {
        SendResponse("Faltan parámetros", 400);
    }
}

function AddNewProduct()
{
    if (
        isset($_GET["adminMail"]) &&
        isset($_GET["adminPassword"]) &&
        isset($_GET["productName"]) &&
        isset($_GET["productDescription"]) &&
        isset($_GET["productPrice"]) &&
        isset($_GET["productType"]) &&
        isset($_GET["productState"])
    ) {
        $adminMail = $_GET["adminMail"];
        $adminPassword = $_GET["adminPassword"];
        $productName = $_GET["productName"];
        $productDescription = $_GET["productDescription"];
        $productPrice = $_GET["productPrice"];
        $productType = $_GET["productType"];
        $productState = $_GET["productState"];


        $dao = new DAO();

        if (VerifyAdmin($adminMail, $adminPassword)) {
            $result = $dao->AddNewProduct($productName, $productDescription, $productPrice, $productType, $productState);
            if ($result) {
                SendResponse("Producto añadido con éxito", 200);
            } else {
                SendResponse("Error al añadidir el producto", 500);
            }
        }

        $dao->CloseConnection();

    } else {
        SendResponse("Faltan parámetros", 400);
    }
}

function DeleteProduct()
{
    if (
        isset($_GET["productId"]) &&
        isset($_GET["adminMail"]) &&
        isset($_GET["adminPassword"])
    ) {
        $adminMail = $_GET["adminMail"];
        $adminPassword = $_GET["adminPassword"];
        $productId = $_GET["productId"];

        if (VerifyAdmin($adminMail, $adminPassword)) {
            $dao = new DAO();
            $result = $dao->DeleteProduct($productId);

            if ($result) {
                SendResponse("Producto eliminado con éxito", 200);
            } else {
                SendResponse("Error al eliminar el producto", 500);
            }

            $dao->CloseConnection();
        }
    }
}


#endregion

#region DISCOUNTS

function GetAllDiscounts()
{
    if (
        isset($_GET["adminMail"]) &&
        isset($_GET["adminPassword"])
    ) {
        $adminMail = $_GET["adminMail"];
        $adminPassword = $_GET["adminPassword"];

        if (VerifyAdmin($adminMail, $adminPassword)) {
            $dao = new DAO();
            $result = $dao->GetAllDiscounts();
            SendResponse($result);
            $dao->CloseConnection();
        }
    } else {

    }
}

function CreateDiscount()
{
    
}

function DeleteDiscount()
{
    if (
        isset($_GET["adminMail"]) &&
        isset($_GET["adminPassword"]) &&
        isset($_GET["discountId"])
    ) {
        $adminMail = $_GET["adminMail"];
        $adminPassword = $_GET["adminPassword"];
        $discountId = $_GET["discountId"];

        if (VerifyAdmin($adminMail, $adminPassword)) {
            $dao = new DAO();
            $result = $dao->GetAllDiscounts();
            if ($result) {
                SendResponse("Producto eliminado con éxito", 200);
            } else {
                SendResponse("Error al eliminar el producto", 500);
            }
            $dao->CloseConnection();
        }
    } else {

    }
}

#endregion

function VerifyAdmin($adminMail, $adminPassword)
{
    $isAdmin = true;
    $dao = new DAO();

    $admin = $dao->GetUserDataByMailAndPassword($adminMail, $adminPassword);
    if ($admin == null) {
        SendResponse("Admin not found", 404);
        $isAdmin = false;
    }
    if ($admin["role"] != 1) {
        SendResponse("User is not admin", 403);
        $isAdmin = false;
    }

    $dao->CloseConnection();

    return $isAdmin;
}

function GET()
{
    if (!isset($_GET["method"]))
        SendResponse("Falta method", 400);

    switch ($_GET["method"]) {
        case "GetAllUsers":
            GetAllUsers();
            break;

        case "EditUser":
            EditUser();
            break;

        case "GetAllProducts":
            GetAllProducts();
            break;

        case "EditProduct":
            EditProduct();
            break;

        case "CreateProduct":
            AddNewProduct();
            break;

        case "DeleteProduct":
            DeleteProduct();
            break;

        case "GetAllDiscounts":
            GetAllDiscounts();
            break;
        case "DeleteDiscounts":
            DeleteDiscount();
            break;
    }

}

function POST()
{

}

$method = $_SERVER["REQUEST_METHOD"];

switch ($method) {
    case "GET":
        GET();
        break;
    case "POST":
        POST();
        break;
    default:
        SendResponse("Método no permitido", 405);
        break;
}

?>