<?php
include_once("Framework/DAO/DAO.php");
include_once("Framework/ViewSystem/ViewSystem.php");
include_once("Framework/CookieHandler/CookieHandler.php");

try {
    $dao = new DAO();
} catch (Exception $e) {
    $dao = null;
}
?>

<main>
    <h1 class="MainTitle">MENU</h1>
    <h3>Platos principales, Platos secundarios, Bebidas y postres.</h3>

    <div class="SmallSpace"> </div>

    <h2>PLATOS PRINCIPALES</h2>
    <h3>Join the hype train with the hottest products in our arsenal</h3>

    <div class="container-fluid row justify-content-center" style="width: auto;">

        <?php
        if ($dao != null) {
            $products = $dao->GetAllProductsByType("Primary");

            foreach ($products as $product) {
                ViewSystem::PrintProductCard($product["name"], $product["description"], $product["product_type"], $product["id"]);
            }
        }
        ?>

    </div>

    <div class="SmallSpace"> </div>

    <h2>BEBIDAS</h2>
    <h3>Join the hype train with the hottest products in our arsenal</h3>

    <div class="container-fluid row justify-content-center" style="width: auto;">

        <?php
        if ($dao != null) {
            $products = $dao->GetAllProductsByType("Drink");

            foreach ($products as $product) {
                ViewSystem::PrintProductCard($product["name"], $product["description"], $product["product_type"], $product["id"]);
            }
        }
        ?>

    </div>
</main>

<?php
$cart = CookieHandler::GetCart();

if(count($cart) > 0)
{

}
else
{
    return;
}
?>

<div class="fixed-bottom bg-dark p-2 shadow-sm p-3 border-top">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <p class="mb-0 text-white">Carrito</p>
            <p class="mb-0 text-white"><?=count($cart)?> Items seleccionados</p>
        </div>
        <a href="/Cart"
            style="background-color: #28a745; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none;">
            Finalizar compra.
        </a>
    </div>
</div>

<?php
if ($dao != null)
    $dao->CloseConnection();
?>