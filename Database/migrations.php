<?php

echo "\nCreando Migraciones...\n";
include_once __DIR__ . '/migrations/CreateDatabase.php';
include_once __DIR__ . '/migrations/Order_Migrations.php';
include_once __DIR__ . '/migrations/Product_Migrations.php';
include_once __DIR__ . '/migrations/User_Migrations.php';
include_once __DIR__ . '/migrations/Product_Order_Migrations.php';
echo "Migraciones creadas con Exito!\n";

?>
