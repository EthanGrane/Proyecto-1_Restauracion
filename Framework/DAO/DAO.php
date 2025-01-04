<?php

class DAO
{
    private $conn;
    public $debugMode = false;

    public function __construct($debugMode = false)
    {
        $this->debugMode = $debugMode;

        $this->OpenConnection();

        if ($this->conn) {
            $this->DebugPrint("[DAO.php] Connection with DDBB sucesfull");
        } else {
            $this->DebugPrint("[DAO.php] Connection with DDBB failed");
        }
    }

    private function OpenConnection()
    {
        $servername = "localhost";
        $port = "33060";
        $username = "root";
        $password = "root";
        $database = "Web";
        $this->conn = new mysqli($servername, $username, $password, $database, $port);
    }

    public function CloseConnection()
    {
        $this->conn->close();

        $this->DebugPrint("connection closed");
    }

    #region User
    public function GetUserDataByMailAndPassword($mailParam, $passwordParam)
    {
        $stmt = $this->conn->prepare("SELECT * FROM Users WHERE mail = ? AND password = ?");
        $stmt->bind_param("ss", $mailParam, $passwordParam);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
        } else {
            $data = null;
        }

        return $data;
    }

    public function ValidateUser($mailParam, $passwordParam)
    {
        $stmt = $this->conn->prepare("SELECT id_user FROM Users WHERE mail = ? AND password = ?");
        $stmt->bind_param("ss", $mailParam, $passwordParam);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return true;
        } else {
            throw new Exception("Email or Password incorrects.");
        }
    }

    public function AddUserToBBDD($userName, $userMail, $userPassword)
    {
        $this->ValidateNewUserData($userName, $userMail, $userPassword);

        $stmt = $this->conn->prepare("INSERT INTO Web.Users (name, mail, password, role) VALUES (?, ?, ?, '0')");
        $stmt->bind_param("sss", $userName, $userMail, $userPassword);
        $stmt->execute();
    }

    private function ValidateNewUserData($userName, $userMail, $userPassword)
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM Web.Users WHERE mail = ?");
        if (!$stmt) {
            throw new Exception("Error preparing statement: " . $this->conn->error);
        }

        $stmt->bind_param("s", $userMail);
        $stmt->execute();
        $stmt->bind_result($count);

        if (!$stmt->fetch()) {
            throw new Exception("Error fetching result.");
        }

        $stmt->close();

        if ($count > 0) {
            throw new Exception("Email is already registered.");
        }

        if (strlen($userName) > 25) {
            throw new Exception("Username is too long.");
        }

        if (strlen($userPassword) < 6) {
            throw new Exception("Password must be at least 6 characters long.");
        }
    }


    #endregion

    #region Product
    public function GetAllProductsByType($type_param)
    {
        static $WHITELIST = ["MainDish", "Drink"];

        $type = in_array($type_param, $WHITELIST) ? $type_param : "MainDish";

        $stmt = $this->conn->prepare("SELECT * FROM Products WHERE state = 0 AND type = ? LIMIT 100");
        $stmt->bind_param("s", $type);
        $stmt->execute();

        $result = $stmt->get_result();

        // Fecth data
        $data = $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : null;
        $this->DebugPrint("[GetAllProductsByType]: " . print_r($data, true));

        return $data;
    }

    public function GetProductsDataByIDs($ids)
    {
        if (empty($ids)) {
            return [];
        }

        $this->DebugPrint("[GetProductsByIDs]");
        $this->DebugPrint(" · [ids]: " . print_r($ids, true));


        $placeholders = implode(',', array_fill(0, count($ids), '?'));

        $this->DebugPrint(" · [placeholders]: " . print_r($placeholders, true));

        $query = "SELECT * FROM Products WHERE state = 0 AND id_products IN ($placeholders) LIMIT 100";
        $stmt = $this->conn->prepare($query);

        $types = str_repeat('i', count($ids));
        $stmt->bind_param($types, ...$ids);

        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];

        $this->DebugPrint(" · [data]: " . print_r($data, true));

        return $data;
    }
    #endregion

    #region Orders
    public function GetOrdersByUserId($userID)
    {
        $query = "SELECT * FROM Web.Orders WHERE id_user = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $data = [];
        while ($row = $result->fetch_assoc()) 
        {
            $data[] = $row;
        }
    
        $stmt->close();
    
        return $data;
    }

    public function GetProductsByOrderId($orderID)
    {
        $query = "SELECT * FROM Web.Orders_Products WHERE id_order = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $orderID);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $data = [];
        while ($row = $result->fetch_assoc()) 
        {
            $data[] = $row;
        }
    
        $stmt->close();
    
        return $data;
    }

    public function CreateNewOrder($userID, $discountCode, $productIdsArray)
    {
        $query = "INSERT INTO Web.Orders (`id_user`, `id_discount`, `date`, `final_price`) VALUES (?, ?, ?,?);";
        $date = date("Y-m-d");

        $this->DebugPrint("CreateNewOrder with value: $userID, $discountCode, $date");

        // Recoje toda la informacion sobre los productos. (mismo codigo que en Cart.php seccion try{})
        $cartItems = [];
        $cartData = $this->GetProductsDataByIDs($productIdsArray);
        foreach ($productIdsArray as $productId) 
        {
            for ($i = 0; $i < count($cartData); $i++) {
                if ($productId == $cartData[$i]["id_products"]) {
                    array_push($cartItems, $cartData[$i]);
                    continue;
                }
            }
        }

        // Calcula el precio final
        $finalPrice = 0.0;
        for ($i=0; $i < count($cartItems); $i++) 
        { 
            $sum = $cartItems[$i]["price"];
            $finalPrice += $sum;
            $this->DebugPrint("Final Price += $sum");
        }
        $this->DebugPrint("Final Price without discount: $finalPrice");

        // Resta el descuento al precio total
        if($discountCode != null)
        {
            $discountData = $this->GetDiscountDataByCode($discountCode);
            $discountValue = 0.0;

            $this->DebugPrint("Discount type:" . $discountData["discount_type"]);
            $this->DebugPrint("Discount Value:" . $discountData["value"]);

            if ($discountData["discount_type"] == 0) 
            {
                $discountValue = $finalPrice * ($discountData["value"] * 0.01);
                // Respeta que el numero tenga 2 decimales.
                $discountValue = number_format($discountValue, 2, '.', '');
            } 
            elseif ($discountData["discount_type"] == 1) 
            {
                $discountValue = $discountData["value"];
                // Respeta que el numero tenga 2 decimales.
                $discountValue = number_format($discountValue, 2, '.', '');
            }

            $finalPrice -= $discountValue;
            $this->DebugPrint("Final Price with discount: $finalPrice");

        }

        // Ejecuta SQL
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iisd", $userID, $discountData["id_discount"], $date, $finalPrice);
        $stmt->execute();

        //Recoje la id auto-generada
        $orderID = $this->conn->insert_id;

        $stmt->close();

        for ($i = 0; $i < count($productIdsArray); $i++) 
        {
            $this->CreateOrderProduct($productIdsArray[$i], $orderID);
        }
    }

    private function CreateOrderProduct($productID, $orderID)
    {
        $query = "INSERT INTO Web.Orders_Products (`id_order`, `id_product`, `amount`) VALUES (?, ?, 1);";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $orderID, $productID);
        $stmt->execute();
        $stmt->close();
    }

    #endregion

    #region Discounts

    /*
     * Solo se puede aplicar un descuento por pedido y solo se aplica al pedido entero no a productos individuales.
     * En la descripcion de SQL del valor discount_type hay una explicacion de cada valor que significa
     *      0 - Descuento de tipo porcentaje (-20% del precio original)
     *      1 - Descuento de tipo fijo (-2€ del precio original)
     */
        public function IsDiscountCodeValid($discountCode)
        {
            $query = "SELECT * FROM Web.Discount WHERE discount_code = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s", $discountCode);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows > 0)
            {
                $data = $result->fetch_assoc();
                if($data["valid"] == 1)
                    return true;

                return false;
            }
            else 
                return false;
        }

        public function GetDiscountDataByCode($discountCode)
        {
            if($this->IsDiscountCodeValid($discountCode))
            {
                $query = "SELECT * FROM Web.Discount WHERE discount_code = ? AND valid = 1 LIMIT 1";
                $stmt = $this->conn->prepare($query);
                $stmt->bind_param("s", $discountCode);
                $stmt->execute();
                $result = $stmt->get_result();

                $data = $result->fetch_assoc();
                return $data;
            }

            return null;
        }

        public function GetDiscountDataById($discountID)
        {
            $query = "SELECT * FROM Web.Discount WHERE id_discount = ? LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s", $discountID);
            $stmt->execute();
            $result = $stmt->get_result();

            $data = $result->fetch_assoc();
            return $data;
        }
    #endregion

    public function DebugPrint($message)
    {
        if ($this->debugMode == false)
            return;

        echo "<table style='border: solid blue 1px'>
                <th style='font-family: consolas; color: cyan; font-size: 12px'>$message</th>
            </table>";
    }

}

?>