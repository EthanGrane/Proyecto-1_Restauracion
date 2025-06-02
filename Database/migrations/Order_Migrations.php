<?php

$env = parse_ini_file('.env');

$servername = $env['DB_HOST'];
$username = $env['DB_USER'];
$password = $env['DB_PASS'];
$database = $env['DB_NAME'];
$port = $env['DB_PORT'];

$conn = new mysqli($servername, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$query = "CREATE TABLE IF NOT EXISTS `order` (
        id INT AUTO_INCREMENT PRIMARY KEY,
        discount_id INT NULL,
        user_id INT NOT NULL,
        total_price DECIMAL(10,2) NOT NULL
        date DATE NOT NULL,
    )";

if ($conn->query($query) === TRUE) {
    echo "✅ Tabla 'order' creada correctamente\n";
} else {
    echo "Error al crear la tabla: " . $conn->error;
}

$conn->close();


?>