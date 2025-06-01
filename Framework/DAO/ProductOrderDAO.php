<?php

class ProductOrderDAO
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

    #region PRODUCT_ORDER

    public function CreateOrderProduct($productID, $orderID)
    {
        $query = "INSERT INTO product_order (`order_id`, `id_product`, `amount`) VALUES (?, ?, 1);";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $orderID, $productID);
        $stmt->execute();
        $stmt->close();
    }

    public function GetProductsOrderByOrderId($orderID)
    {
        $query = "SELECT * FROM product_order WHERE order_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $orderID);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $stmt->close();

        return $data;
    }

    #endregion
}
