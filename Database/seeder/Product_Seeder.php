<?php
echo "Product Seeder started\n";

$env = parse_ini_file('.env');
$servername = $env['DB_HOST'];
$username = $env['DB_USER'];
$password = $env['DB_PASS'];
$database = $env['DB_NAME'];
$port = $env['DB_PORT'];
$conn = new mysqli($servername, $username, $password, $database, $port);

$bowl_dishes = [
    "Ramen",
    "Poke bowl",
    "Sopa de miso",
    "Gazpacho",
    "Bibimbap",
    "Pho",
    "Açai bowl",
    "Smoothie bowl",
    "Buddha bowl",
    "Chili con carne",
    "Ceviche",
    "Sopa de lentejas",
    "Curry tailandés con arroz",
    "Curry indio con arroz",
    "Gumbo",
    "Jambalaya",
    "Tonkotsu ramen",
    "Udon",
    "Sopa de fideos chinos",
    "Khao soi",
    "Sopa minestrone",
    "Sopa de tortilla (mexicana)",
    "Sancocho",
    "Locro",
    "Moqueca",
    "Borscht",
    "Okroshka",
    "Chowder de almejas",
    "Arroz con leche",
    "Yogur con granola y frutas",
    "Porridge (gachas de avena)",
    "Shakshuka en bowl",
    "Ensalada de quinoa",
    "Bowl de falafel con hummus",
    "Bowl de pollo teriyaki",
    "Bowl de tofu con verduras",
    "Bowl de salmón al horno",
    "Arroz frito en bowl",
    "Bowl de camarones al ajillo",
    "Bowl de yakisoba",
    "Agua Natural",
    "Agua Fria",
    "Nestea",
    "Cocacola",
    "Fanta Limon",
    "Fanta Naranja",
    "Guarana",
    "Cerveza",
    "Monster",
    "Monster Mango loco"
];


for ($i = 0; $i < 50; $i++) {
    $product_name = $bowl_dishes[$i];
    $product_price = (($i + 10) % 15) + ($i % 2 == 0 ? 0.5 : 0.99);
    $product_type = $i <= 40 ? "Primary" : "Drink";

    $query = "
    INSERT INTO product (price, name, product_type, enabled)
    VALUES ($product_price, '$product_name', '$product_type', 0);
";

    $conn->query($query);
}

echo "✅ Product Seeder Complete!\n";

?>