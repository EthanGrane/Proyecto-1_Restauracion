<?php

class DAO
{
    // No lo borro por si acaso, nada de esto se utiliza
    // Tener el codigo dividido por regiones me ha salvado para migrarlo todo a DAOs individuales

    /*
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

        $this->DebugPrint("connection closed");
    }

    public function GetConnection()
    {
        return $this->conn;
    }

    #region User
    public function GetUserDataByMailAndPassword($mailParam, $hashPasswordParam)
    {
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE mail = ?");
        $stmt->bind_param("s", $mailParam);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();

            // Verificar la contraseña utilizando password_verify
            if (password_verify($hashPasswordParam, $data['password'])) {
                return $data;
            } else {
                return null; // Contraseña incorrecta
            }
        } else {
            return null; // No se encontró el usuario
        }
    }

    public function ValidateUser($mailParam, $hashPasswordParam)
    {
        error_log($mailParam);

        $stmt = $this->conn->prepare("SELECT id, password FROM user WHERE mail = ?");
        $stmt->bind_param("s", $mailParam);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();

            // Verificar la contraseña utilizando password_verify
            if (password_verify($hashPasswordParam, $data['password'])) {
                return true;
            } else {
                throw new Exception("Email or Password incorrect.");
            }
        } else {
            throw new Exception("User don't exist.");
        }
    }

    public function GetAllUsersFromBBDD($limit = 100)
    {
        $stmt = $this->conn->prepare("SELECT * FROM user LIMIT ?");
        $stmt->bind_param("i", $limit);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        } else {
            return [];
        }
    }

    public function UpdateUser($username, $mail, $password, $role)
    {
        $stmt = $this->conn->prepare("UPDATE user SET name = ?, mail = ?,password = ?, role = ? WHERE mail = ?");

        $hashPass = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param("sssis", $username, $mail, $hashPass, $role, $mail);

        if ($stmt->execute()) {
            return [
                "message" => "Usuario actualizado con éxito",
                "username" => $username,
                "password" => $hashPass,
                "mail" => $mail,
                "role" => $role
            ];
        } else {
            return [
                "message" => "Error al actualizar el usuario: " . $stmt->error
            ];
        }
    }

    public function UpdateUserWithoutPassword($username, $mail, $role)
    {
        $stmt = $this->conn->prepare("UPDATE user SET name = ?, mail = ?, role = ? WHERE mail = ?");

        $stmt->bind_param("ssis", $username, $mail, $role, $mail);

        if ($stmt->execute()) {
            return [
                "message" => "Usuario actualizado con éxito",
                "username" => $username,
                "mail" => $mail,
                "role" => $role
            ];
        } else {
            return [
                "message" => "Error al actualizar el usuario: " . $stmt->error
            ];
        }
    }

    public function AddUserToBBDD($user)
    {
        // Encriptar la contraseña con password_hash
        $hashPass = password_hash($user->GetPassword(), PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare("INSERT INTO user (name, mail, password, role) VALUES (?, ?, ?, '0')");
        $stmt->bind_param("sss", $user->GetName(), $user->GetMail(), $hashPass);
        $stmt->execute();
    }


    #endregion

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

        // Fecth data
        $data = $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : null;
        $this->DebugPrint("[GetAllProductsByType]: " . print_r($data, true));

        return $data;
    }

    public function GetAllProducts()
    {
        $query = "SELECT * FROM product LIMIT 100";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        $result = $stmt->get_result();

        // Fecth data
        $data = $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : null;
        $this->DebugPrint("[GetAllProducts]: " . print_r($data, true));

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

        $query = "SELECT * FROM product WHERE enabled = 0 AND id IN ($placeholders) LIMIT 100";
        $stmt = $this->conn->prepare($query);

        $types = str_repeat('i', count($ids));
        $stmt->bind_param($types, ...$ids);

        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];

        $this->DebugPrint(" · [data]: " . print_r($data, true));

        return $data;
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

    #region order
    // public function GetOrdersByUserId($userID)
    // {
    //     $query = "SELECT * FROM `Order` WHERE user_id = ?";
    //     $stmt = $this->conn->prepare($query);
    //     $stmt->bind_param("i", $userID);
    //     $stmt->execute();
    //     $result = $stmt->get_result();


    //     $data = [];
    //     while ($row = $result->fetch_assoc()) {
    //         $data[] = $row;
    //     }

    //     $stmt->close();

    //     return $data;
    // }

    // public function GetProductsByOrderId($orderID)
    // {
    //     $query = "SELECT * FROM product_order WHERE order_id = ?";
    //     $stmt = $this->conn->prepare($query);
    //     $stmt->bind_param("i", $orderID);
    //     $stmt->execute();
    //     $result = $stmt->get_result();

    //     $data = [];
    //     while ($row = $result->fetch_assoc()) {
    //         $data[] = $row;
    //     }

    //     $stmt->close();

    //     return $data;
    // }

    // public function CreateNewOrder($userID, $discountCode, $productIdsArray)
    // {
    //     $date = date("Y-m-d");

    //     $this->DebugPrint("CreateNewOrder with value: $userID, $discountCode, $date");

    //     // Recoje toda la informacion sobre los productos. (mismo codigo que en Cart.php seccion try{})
    //     $cartItems = [];
    //     $cartData = $this->GetProductsDataByIDs($productIdsArray);
    //     foreach ($productIdsArray as $productId) {
    //         for ($i = 0; $i < count($cartData); $i++) {
    //             if ($productId == $cartData[$i]["id"]) {
    //                 array_push($cartItems, $cartData[$i]);
    //                 continue;
    //             }
    //         }
    //     }

    //     // Calcula el precio total antes del IVA
    //     $totalPrice = 0.0;
    //     for ($i = 0; $i < count($cartItems); $i++) {
    //         $sum = $cartItems[$i]["price"];
    //         $totalPrice += $sum;
    //         $this->DebugPrint("Total Price += $sum");
    //     }
    //     $this->DebugPrint("Total Price before VAT: $totalPrice");

    //     // IVA: Agregar el 10% de IVA al total
    //     $totalPriceWithVAT = $totalPrice * 1.1; // IVA del 10%
    //     $this->DebugPrint("Total Price with VAT: $totalPriceWithVAT");

    //     // Resta el descuento al precio total (con IVA ya aplicado)
    //     $total_price = $totalPriceWithVAT;

    //     if ($discountCode != null) {
    //         $discountData = $this->GetDiscountDataByCode($discountCode);
    //         $discountValue = 0.0;

    //         $this->DebugPrint("Discount product_type:" . $discountData["discount_type"]);
    //         $this->DebugPrint("Discount Value:" . $discountData["value"]);

    //         if ($discountData["discount_type"] == 0) {
    //             // Descuento en porcentaje
    //             $discountValue = $total_price * ($discountData["value"] * 0.01);
    //             $discountValue = number_format($discountValue, 2, '.', '');
    //         } elseif ($discountData["discount_type"] == 1) {
    //             // Descuento fijo
    //             $discountValue = $discountData["value"];
    //             $discountValue = number_format($discountValue, 2, '.', '');
    //         }

    //         // Aplica el descuento al precio con IVA
    //         $total_price -= $discountValue;
    //         $this->DebugPrint("Final Price with discount: $total_price");
    //     } else {
    //         $discountData["id"] = null;
    //     }

    //     $total_price = number_format($total_price, 2, '.', '');

    //     // Ejecuta SQL para insertar el nuevo pedido
    //     $query = "INSERT INTO `order` (`discount_id`, `user_id`, `total_price`, `date`) VALUES (?, ?, ?, ?);";
    //     $stmt = $this->conn->prepare($query);
    //     $stmt->bind_param("iisd", $userID, $discountData["id"], $total_price, $date);
    //     $stmt->execute();

    //     // Recoje la id auto-generada
    //     $orderID = $this->conn->insert_id;

    //     $stmt->close();

    //     // Inserta los productos en la orden
    //     for ($i = 0; $i < count($productIdsArray); $i++) {
    //         $this->CreateOrderProduct($productIdsArray[$i], $orderID);
    //     }
    // }


    // private function CreateOrderProduct($productID, $orderID)
    // {
    //     $query = "INSERT INTO product_order (`order_id`, `id_product`, `amount`) VALUES (?, ?, 1);";

    //     $stmt = $this->conn->prepare($query);
    //     $stmt->bind_param("ii", $orderID, $productID);
    //     $stmt->execute();
    //     $stmt->close();
    // }

    #endregion

    #region Discounts

    //  * Solo se puede aplicar un descuento por pedido y solo se aplica al pedido entero no a productos individuales.
    //  * En la descripcion de SQL del valor discount_type hay una explicacion de cada valor que significa
    //  *      0 - Descuento de tipo porcentaje (-20% del precio original)
    //  *      1 - Descuento de tipo fijo (-2€ del precio original)
    public function IsDiscountCodeValid($discountCode)
    {
        $query = "SELECT * FROM Discount WHERE discount_code = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $discountCode);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            if ($data["valid"] == 1)
                return true;

            return false;
        } else
            return false;
    }

    public function GetDiscountDataByCode($discountCode)
    {
        if ($this->IsDiscountCodeValid($discountCode)) {
            $query = "SELECT * FROM Discount WHERE discount_code = ? AND valid = 1 LIMIT 1";
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
        $query = "SELECT * FROM discount WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $discountID);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = $result->fetch_assoc();
        return $data;
    }

    public function GetAllDiscounts()
    {
        $query = "SELECT * FROM Discount LIMIT 100";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        $result = $stmt->get_result();

        $data = $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : null;
        $this->DebugPrint("[GetAllDiscounts]: " . print_r($data, true));

        return $data;
    }

    public function CreateDiscount($discountCode, $discountAmount, $discountType, $discountValid)
    {
        $query = "INSERT INTO Discount (discount_code, discount_type, value, valid) 
              VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sidi", $discountCode, $discountType, $discountAmount, $discountValid);
        $result = $stmt->execute();
        if ($result) {
            SendResponse("Discount created successfully", 200); // OK
        } else {
            SendResponse("Failed to create discount", 500); // Internal server error
        }
        $stmt->close();
    }

    public function DeleteDiscount($discountId)
    {
        $query = "DELETE FROM Discount WHERE id_discount = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("i", $discountId);

        $result = $stmt->execute();

        $stmt->close();

        return $result;
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
*/
}
