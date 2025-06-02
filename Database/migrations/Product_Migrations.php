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

$query = "CREATE TABLE IF NOT EXISTS Product (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description VARCHAR(255) NULL,
    price DOUBLE NOT NULL,
    product_type VARCHAR(100) NOT NULL,
    enabled Boolean NOT NULL
)";

if ($conn->query($query) === TRUE) {
    echo "✅ Tabla 'Product' creada correctamente\n";
} else {
    echo "Error al crear la tabla: " . $conn->error;
}

$conn->close();
?>
