<?php
require_once("Model/User.php");
require_once("Framework/CookieHandler/CookieHandler.php");
require_once("Framework/SessionManager/SessionManager.php");
include_once("Framework/ViewSystem/ViewSystem.php");
include_once("Framework/DAO/DAO.php");
include_once("Framework/DAO/OrderDAO.php");
include_once("Framework/DAO/ProductDAO.php");
include_once("Framework/DAO/DiscountDAO.php");
include_once("Framework/DAO/ProductOrderDAO.php");

class UserController
{
    public function View()
    {
        self::CheckUserIsLogged();

        $dao = new DAO();
        $orderDao = new OrderDAO();
        $discountDao = new DiscountDAO();
        $productDao = new ProductDAO();
        $productOrderDao = new ProductOrderDAO();

        $userSession = SessionManager::GetUserSession();

        $userOrders = [];

        if ($userSession !== null && isset($userSession["UserID"])) {
            $orders = $orderDao->GetOrdersByUserId($userSession["UserID"]);

            if (!is_array($orders)) {
                $orders = [];
            }

            foreach ($orders as $order) {
                $orderId = $order["id"];
                $ordersProducts = $productOrderDao->GetProductsOrderByOrderId($orderId);
                $productsID = is_array($ordersProducts) ? array_column($ordersProducts, 'product_id') : [];
                $productData = !empty($productsID) ? $productDao->GetProductsDataByIDs($productsID) : [];

                $discount = null;
                $discountValue = 0;

                if (!empty($order["discount_id"])) {
                    $discount = $discountDao->GetDiscountDataById($order["discount_id"]);

                    if (is_array($discount)) {
                        if ($discount["discount_type"] == 0) {
                            $discountValue = number_format($order["total_price"] * ($discount["value"] * 0.01), 2, '.', '');
                        } elseif ($discount["discount_type"] == 1) {
                            $discountValue = number_format($discount["value"], 2, '.', '');
                        }
                    }
                }

                $userOrders[] = [
                    "date" => $order["date"],
                    "total_price" => $order["total_price"],
                    "products" => $productData,
                    "discount_value" => $discountValue
                ];
            }
        }

        $dao->CloseConnection();

        ViewSystem::PrintView("User", "User", [
            "userOrders" => $userOrders,
            "userSession" => $userSession
        ]);
    }

    public function ViewLogin()
    {
        if (SessionManager::GetUserSession()["UserID"] == null) {
            ViewSystem::PrintView("UserLogin");
        } else {
            header("Location: /user");
        }
    }
    public function Login()
    {
        $mail = $_POST["email"];
        $password = $_POST["password"];

        $dao = null;
        try {
            error_log("Iniciando Login");
            $dao = new DAO(true);
            error_log("DAO creado");

            $user = User::Authenticate($mail, $password, $dao);
            error_log("Usuario autenticado: " . $user->GetMail());

            $data = $dao->GetUserDataByMailAndPassword($mail, $password);
            error_log("Datos obtenidos: " . print_r($data, true));

            if ($data === null) {
                throw new Exception("No se encontró el usuario en la base de datos.");
            }

            SessionManager::SetUserSession(
                $data["id"],
                $user->GetName(),
                $user->GetMail(),
                $user->GetPassword()
            );

            error_log("Sesión creada correctamente");
            header("Location: /user");
            exit();
        } catch (Exception $e) {
            error_log("Excepción: " . $e->getMessage());
            SessionManager::SetException($e->getMessage());
        } finally {
            if ($dao != null)
                $dao->CloseConnection();

            error_log("Redirigiendo a login");
            header("Location: /login");
            exit();
        }
    }

    public function ViewSignin()
    {
        if (SessionManager::GetUserSession()["UserID"] == null) {
            ViewSystem::PrintView("UserSignin");
        } else {
            header("Location: /user");
        }
    }

    public function Signin()
    {
        try {
            $name = $_POST["name"];
            $mail = $_POST["mail"];
            $password = $_POST["password"];

            $user = new User($name, $mail, $password);
            $dao = new DAO();

            $user->ValidateUserData($dao->GetConnection());

            $dao->AddUserToBBDD($user);

            $data = $dao->GetUserDataByMailAndPassword($user->GetMail(), $user->GetPassword());
            SessionManager::SetUserSession(
                $data["id"],
                $data["name"],
                $data["mail"],
                $data["password"]
            );

            $dao->CloseConnection();

            header("Location: /user");
        } catch (Exception $e) {
            SessionManager::SetException($e->getMessage());
            header("Location: /signin");
        }
    }

    public function Logout()
    {
        header("Location: /login");
        SessionManager::DestroyUserSession();
    }

    private static function CheckUserIsLogged()
    {
        if (!User::CheckUserIsLogged()) {
            header("Location: /login");
            exit();
        }
    }
}
