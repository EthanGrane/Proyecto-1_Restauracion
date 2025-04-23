<?php
echo "User Seeder started\n";

$env = parse_ini_file('.env');
$servername = $env['DB_HOST'];
$username = $env['DB_USER'];
$password = $env['DB_PASS'];
$database = $env['DB_NAME'];
$port = $env['DB_PORT'];
$conn = new mysqli($servername, $username, $password, $database, $port);

$user_password = password_hash("password", PASSWORD_DEFAULT);

$admin_query = "
INSERT INTO user (name, direction, mail, password) 
VALUES ('admin', 'Barcelona', 'admin@admin.com', '$user_password');
";
$conn->query($admin_query);

for ($i = 0; $i < 50; $i++) {
    $user_name = "User-$i";
    $user_mail = "User$i@test.com";
    $user_direction = "Barcelona, n. $i";
    $user_password = password_hash("password", PASSWORD_DEFAULT);

    $query = "
INSERT INTO user (name, direction, mail, password) 
VALUES ('$user_name', '$user_direction', '$user_mail', '$user_password');
";

    $conn->query($query);
}

echo "✅ User Seeder Complete!\n";

?>