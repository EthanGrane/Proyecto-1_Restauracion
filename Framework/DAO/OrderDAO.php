<?php

require_once("Model/User.php");
require_once("Model/Order.php");

class OrderDAO
{
    private $conn;

    public function __construct()
    {
        $this->OpenConnection();
    }

    private function OpenConnection()
    {
        $env = parse_ini_file('.env');
        $servername = $env['DB_HOST'];
        $username = $env['DB_USER'];
        $password = $env['DB_PASS'];
        $database = $env['DB_NAME'];
        $port = $env['DB_PORT'];

        $this->conn = new mysqli($servername, $username, $password, $database, $port);
    }

    public function CloseConnection()
    {
        $this->conn->close();
    }

    public function GetConnection()
    {
        return $this->conn;
    }

    public function DebugPrint($message)
    {

        echo "<table style='border: solid blue 1px'>
                <th style='font-family: consolas; color: cyan; font-size: 12px'>$message</th>
            </table>";
    }

    #region order
    public function GetOrdersByUserId($userID)
    {
        $query = "SELECT * FROM `Order` WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();


        $orders = [];
        while ($row = $result->fetch_object('Order')) {
            $orders[] = $row;
        }

        $stmt->close();

        return $orders;
    }

    public function CreateOrderProduct($productID, $orderID)
    {
        $query = "INSERT INTO product_order (`order_id`, `product_id`, `amount`) VALUES (?, ?, 1);";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $orderID, $productID);
        $stmt->execute();
        $stmt->close();
    }


    // En el DAO ni siquiera tenia una funcion tan basica como esta...
    public function CreateOrder($userID, $discountID, $total_price, $date)
    {
        $query = "INSERT INTO `order` (`discount_id`, `user_id`, `total_price`, `date`) VALUES (?, ?, ?, ?);";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iisd", $discountID, $userID, $total_price, $date);
        $stmt->execute();
        // Recoje la id auto-generada
        $orderID = $this->conn->insert_id;
        return $orderID;
    }

    #endregion

}
