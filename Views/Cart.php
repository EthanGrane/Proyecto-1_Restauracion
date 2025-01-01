<?php
include_once("Framework\DAO\DAO.php");
include_once("Framework\ViewSystem\ViewSystem.php");
include_once("Framework\CookieHandler\CookieHandler.php");

try {
    $cart = CookieHandler::GetCart();

    $dao = new DAO();
    $cartData = $dao->GetProductsDataByIDs($cart);
    $dao->CloseConnection();

    /*
     * Explicacion del codigo de abajo
     */
    $cartItems = [];
    foreach ($cart as $productId) {
        for ($i = 0; $i < count($cartData); $i++) {
            if ($productId == $cartData[$i]["id_products"]) {
                array_push($cartItems, $cartData[$i]);
                continue;
            }
        }

    }
} catch (Exception $e) {
    $dao = null;
}
?>

<main>

    <div class="d-flex justify-content-between align-items-center">

        <h1>My Cart</h1>

        <?php
        if (count($cartItems) > 0) {
            ?>

            <form action="Cart/Clear" method="POST">
                <button class="btn btn-secondary" href="/Cart/Clear" style="border: 1px solid var(--Primary) !important;">
                    Vaciar Carrito
                </button>
            </form>

            <?php
        }
        ?>

    </div>

    <?php
    /*
    Print Products Data list
    */
    if (count($cartItems) > 0) {
        for ($i = 0; $i < count($cartItems); $i++) {
            ViewSystem::PrintCartItem($cartItems[$i]);
        }
    } else {
        ?>

        <div class="container mt-4">
            <div class="row align-items-center border-bottom-neutral pb-3">

                <!-- Nombre y descripción -->
                <div class="w-100 d-flex justify-content-center">
                    <a href="/Menu" class="btn btn-secondary">
                        Ver Menu
                    </a>
                </div>

            </div>
        </div>

        <?php
    }
    ?>
    <div class="container mt-4">
        <div class="row align-items-center pb-3 mt-4">
            <div class="col-8">
            </div>

            <div class="col-4">
                <div class="d-flex justify-content-between">
                    <p>Subtotal: </p>
                </div>

                <?php
                $totalPrice = 0.0;
                for ($i = 0; $i < count($cartItems); $i++) {
                    $totalPrice += $cartItems[$i]["price"];
                    echo "
                <div class='d-flex justify-content-end'>
                    <p>" . $cartItems[$i]['price'] . " €</p>
                </div>
                ";
                }
                ?>

                <hr>

                <div class="d-flex justify-content-between">
                    <p>Total:</p>
                    <p><?= $totalPrice ?>€</p>
                </div>

                <form action="\Cart\Checkout" method="POST">
                <?php if(count($cartItems) != 0)
                echo'
                    <input type="submit"  class="btn btn-primary w-100" value="Comprar">
                    ';
                ?>
                </form>

            </div>
        </div>
    </div>

</main>