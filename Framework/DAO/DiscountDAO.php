<?php

class DiscountDAO
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


    #region Discounts

    /*
     * Solo se puede aplicar un descuento por pedido y solo se aplica al pedido entero no a productos individuales.
     * En la descripcion de SQL del valor discount_type hay una explicacion de cada valor que significa
     *      0 - Descuento de tipo porcentaje (-20% del precio original)
     *      1 - Descuento de tipo fijo (-2€ del precio original)
     */
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

}
