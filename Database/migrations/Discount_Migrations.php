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

$query = "CREATE TABLE IF NOT EXISTS Discount (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    discount_code VARCHAR(45) NOT NULL,
    discount_type INT NOT NULL,
    value FLOAT NOT NULL,
    valid INT NOT NULL
);
";

if ($conn->query($query) === TRUE) {
    echo "✅ Tabla 'Discount' creada correctamente\n";
} else {
    echo "Error al crear la tabla: " . $conn->error . "\n";
}

$conn->close();
