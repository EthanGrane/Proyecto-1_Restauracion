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
            $this->DebugPrint( "[DAO.php] Connection with DDBB failed");
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
        if (empty($ids)) 
        {
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

    public function DebugPrint($message)
    {
        if($this->debugMode == false)
            return;

        echo "<table style='border: solid blue 1px'>
                <th style='font-family: consolas; color: cyan; font-size: 12px'>$message</th>
            </table>";
    }


}

?>