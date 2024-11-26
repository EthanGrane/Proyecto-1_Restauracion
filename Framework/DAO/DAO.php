<?php

class DAO
{
    private $conn;

    public function __construct($debugMode = false)
    {
        $this->OpenConnection();

        if ($debugMode) {
            if ($this->conn) {
                echo "[DAO.php] Connection with DDBB sucesfull";
            } else {
                echo "[DAO.php] Connection with DDBB failed";
            }
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

    public function GetAllProducts()
    {
        $stmt = $this->conn->prepare("SELECT * FROM Products LIMIT 100");
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $data = null;
        }

        return $data;
    }

}

?>