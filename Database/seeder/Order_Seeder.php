<?php
echo "Order Seeder started\n";

$env = parse_ini_file('.env');
$servername = $env['DB_HOST'];
$username = $env['DB_USER'];
$password = $env['DB_PASS'];
$database = $env['DB_NAME'];
$port = $env['DB_PORT'];
$conn = new mysqli($servername, $username, $password, $database, $port);

for ($i = 0; $i < 50; $i++) {
    $order_discount_id = ($i + 25) % 50;
    $order_user_id = $i;
    $order_total_price = ($i * 3) % 20;

    $query = "
    INSERT INTO `order` (discount_id, user_id, total_price) 
    VALUES ($order_discount_id, $order_user_id, $order_total_price);
    ";

    $conn->query($query);
}

echo "✅ Order Seeder Complete!\n";
?>
