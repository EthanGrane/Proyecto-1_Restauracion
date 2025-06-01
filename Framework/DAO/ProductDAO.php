<?php

require_once("Model/Product.php");

class ProductDAO
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

    #region Product
    public function GetAllProductsByType($type_param)
    {
        static $WHITELIST = ["Primary", "Drink"];

        $product_type = in_array($type_param, $WHITELIST) ? $type_param : "Primary";

        $query = "SELECT * FROM product WHERE enabled = 0 AND product_type = ? LIMIT 100";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("s", $product_type);

        $stmt->execute();

        $result = $stmt->get_result();

        $products = [];
        if ($result->num_rows > 0) {
            while ($product = $result->fetch_object('Product')) {
                $products[] = $product;
            }
        } else {
            return null;
        }

        return $products;
    }


    public function GetAllProducts()
    {
        $query = "SELECT * FROM product LIMIT 100";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        $products = [];
        while ($product = $result->fetch_object('Product')) {
            $products[] = $product;
        }

        return $products;
    }

    public function GetProductsDataByIDs(array $ids)
    {
        if (empty($ids)) return [];

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $sql = "SELECT * FROM product WHERE id IN ($placeholders)";
        $stmt = $this->conn->prepare($sql);

        $types = str_repeat('i', count($ids));
        $stmt->bind_param($types, ...$ids);

        $stmt->execute();
        $result = $stmt->get_result();

        $products = [];
        while ($product = $result->fetch_object('Product')) {
            $products[] = $product;
        }

        return $products;
    }


    public function UpdateProduct($productID, $productName, $productDescription, $productPrice, $productType, $productState)
    {
        $query = "UPDATE product 
        SET name = ?, description = ?, price = ?, product_type = ?, enabled = ? 
        WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        // Cambia el tipo para $productType a 's' (string) si se está pasando como una cadena
        $stmt->bind_param("ssdsis", $productName, $productDescription, $productPrice, $productType, $productState, $productID);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    public function AddNewProduct($productName, $productDescription, $productPrice, $productType, $productState)
    {
        $query = "INSERT INTO product (name, description, price, product_type, enabled) VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("ssdsi", $productName, $productDescription, $productPrice, $productType, $productState);

        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    public function DeleteProduct($productId)
    {
        $query = "DELETE FROM product WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("i", $productId);

        $result = $stmt->execute();

        $stmt->close();

        return $result;
    }


    #endregion

}
