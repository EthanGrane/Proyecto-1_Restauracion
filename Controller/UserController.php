<?php
require_once("Model/User.php");
require_once("Framework/CookieHandler/CookieHandler.php");
require_once("Framework/SessionManager/SessionManager.php");
include_once("Framework/ViewSystem/ViewSystem.php");
include_once("Framework/DAO/UserDAO.php");
include_once("Framework/DAO/OrderDAO.php");
include_once("Framework/DAO/ProductDAO.php");
include_once("Framework/DAO/DiscountDAO.php");
include_once("Framework/DAO/ProductOrderDAO.php");

class UserController
{
    public function View()
    {
        self::CheckUserIsLogged();

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
                $orderId = $order->id;
                $product_orders = $productOrderDao->GetProductsOrderByOrderId($orderId);
                $productsID = is_array($product_orders) ? array_column($product_orders, 'product_id') : [];
                $productData = !empty($productsID) ? $productDao->GetProductsDataByIDs($productsID) : [];

                $discount = null;
                $discountValue = 0;

                if (!empty($order->discount_id)) {
                    $discount = $discountDao->GetDiscountDataById($order->discount_id);

                    if (is_array($discount)) {
                        if ($discount->discount_type == 0) {
                            $discountValue = number_format($order->total_price * ($discount->value * 0.01), 2, '.', '');
                        } elseif ($discount->discount_type == 1) {
                            $discountValue = number_format($discount->value, 2, '.', '');
                        }
                    }
                }

                $userOrders[] = [
                    "date" => $order->date,
                    "total_price" => $order->total_price,
                    "products" => $productData,
                    "discount_value" => $discountValue
                ];
            }
        }


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

        try {
            error_log("Iniciando Login");
            $userDao = new UserDAO();
            error_log("DAO creado");

            if (!User::Authenticate($mail, $password, $userDao)) {
                throw new Exception("Usuario Incorrecto");
            }

            $userData = $userDao->GetUserDataByMailAndPassword($mail, $password);
            error_log("Datos obtenidos: " . print_r($userData, true));

            if ($userData === null) {
                throw new Exception("No se encontró el usuario en la base de datos.");
            }

            SessionManager::SetUserSession(
                $userData->id,
                $userData->name,
                $userData->mail,
                $userData->password
            );

            error_log("Sesión creada correctamente");
            header("Location: /user");
            exit();
        } catch (Exception $e) {
            error_log("Excepción: " . $e->getMessage());
            SessionManager::SetException($e->getMessage());
        } finally {
            $userDao->CloseConnection();

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

            $user = new User();
            $user->name = $name;
            $user->mail = $mail;
            $user->password = $password;

            $userDao = new UserDAO();

            $user->ValidateUserData($userDao->GetConnection());

            $userDao->AddUserToBBDD($user);

            $user = $userDao->GetUserDataByMailAndPassword($user->GetMail(), $user->GetPassword());
            SessionManager::SetUserSession(
                $user->id,
                $user->name,
                $user->mail,
                $user->password
            );

            $userDao->CloseConnection();

            error_log("SignIn Completed");
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
