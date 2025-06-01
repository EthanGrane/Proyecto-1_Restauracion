<?php

class UserDAO
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

}
