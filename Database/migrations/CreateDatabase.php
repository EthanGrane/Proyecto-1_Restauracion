<?php

function CreateDatabase()
{
    $env = parse_ini_file('.env');
    $servername = $env['DB_HOST'];
    $username = $env['DB_USER'];
    $password = $env['DB_PASS'];
    $database = $env['DB_NAME'];
    $port = $env['DB_PORT'];

    $conn = new mysqli($servername, $username, $password, '', $port); // Conectar sin base de datos para crearla

    $result = $conn->query("SHOW DATABASES LIKE '$database'");

    if ($result->num_rows == 0) {
        $createDbQuery = "CREATE DATABASE $database";
        if ($conn->query($createDbQuery) === TRUE) {
            echo "✅ Base de datos '$database' creada correctamente.\n";
        } else {
            die("Error al crear la base de datos: " . $conn->error . "\n");
        }
    }
}

CreateDatabase();

?>