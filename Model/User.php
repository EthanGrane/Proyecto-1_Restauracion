<?php

class User
{
    public int $id;
    public string $name;
    public string $mail;
    public ?string $direction;
    public string $password;
    public ?int $role;

    // public function __construct($name, $mail, $password)
    // {
    //     $this->name = $name;
    //     $this->mail = $mail;
    //     $this->password = $password;
    // }

    public function ValidateUserData($conn)
    {
        // Validar si el correo ya está registrado
        $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM user WHERE mail = ?");
        if (!$stmt) {
            throw new Exception("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("s", $this->mail);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $count = $row['count'];

        $stmt->close();

        if ($count > 0) {
            throw new Exception("Email is already registered.");
        }

        // Validar que el nombre de usuario no sea demasiado largo
        if (strlen($this->name) > 25) {
            throw new Exception("Username is too long.");
        }

        // Validar que la contraseña tenga al menos 6 caracteres
        if (strlen($this->password) < 6) {
            throw new Exception("Password must be at least 6 characters long.");
        }
    }

    public function GetName()
    {
        return $this->name;
    }

    public function GetMail()
    {
        return $this->mail;
    }

    public function GetPassword()
    {
        return $this->password;
    }

    public static function CheckUserIsLogged()
    {
        return SessionManager::GetUserSession()["UserID"] != null;
    }

    public static function Authenticate($mail, $password, $dao)
    {
        error_log("Authenticate: iniciando con mail $mail");

        if (!$dao->ValidateUser($mail, $password)) {
            error_log("Authenticate: validación falló para $mail");
            throw new Exception("Correo o contraseña inválidos.");
        }

        $data = $dao->GetUserDataByMailAndPassword($mail, $password);
        error_log("Authenticate: datos obtenidos: " . print_r($data, true));

        if (!$data) {
            error_log("Authenticate: no se encontró usuario con mail $mail y contraseña dada");
            throw new Exception("No se encontró el usuario.");
        }

        return true;
    }
}
