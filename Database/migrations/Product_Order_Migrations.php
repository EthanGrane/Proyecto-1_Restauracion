<?php
$env = parse_ini_file('.env');

$servername = $env['DB_HOST'];
$username = $env['DB_USER'];
$password = $env['DB_PASS'];
$database = $env['DB_NAME'];
$port = $env['DB_PORT'];

$conn = new mysqli($servername, $username, $password, $database, $port);

if ($conn->connect_error) 
{
    die("Conexión fallida: " . $conn->connect_error);
}

$query = "CREATE TABLE IF NOT EXISTS Product_Order (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    order_id INT NOT NULL,
    amount INT NOT NULL
)";

if ($conn->query($query) === TRUE) {
    echo "✅ Tabla 'Product_Order' creada correctamente\n";
} else {
    echo "Error al crear la tabla: " . $conn->error;
}

$conn->close();
?>
