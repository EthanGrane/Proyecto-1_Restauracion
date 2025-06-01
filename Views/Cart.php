<?php
include_once("Framework/DAO/DAO.php");
include_once("Framework/ViewSystem/ViewSystem.php");
include_once("Framework/CookieHandler/CookieHandler.php");
include_once("Framework/SessionManager/SessionManager.php");

$exception = SessionManager::GetException();
$cart = CookieHandler::GetCart();

try {
    if ($cart != null) {
        $dao = new DAO();
        $cartData = $dao->GetProductsDataByIDs($cart);
        $dao->CloseConnection();

        /*
         * Recoje la informacion de los productos para poder calcular el precio final.
         * Esto se hace ya que el carrito solo guarda las ID's
         */
        $cartItems = [];
        foreach ($cart as $productId) {
            for ($i = 0; $i < count($cartData); $i++) {
                if ($productId == $cartData[$i]["id"]) {
                    array_push($cartItems, $cartData[$i]);
                    continue;
                }
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
        $cartItems = isset($cartItems) ? $cartItems : [];

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
                    <p>IVA</p>
                </div>
                <div class='d-flex justify-content-end'>
                    <p>
                        <?= number_format($totalPrice * 0.1, 2, '.', ''); ?>
                    </p>
                </div>

                <hr>

                <div class="d-flex justify-content-between">
                    <p>Total:</p>
                    <p><?= number_format($totalPrice * 1.1, 2, '.', '') ?>€</p>
                </div>

                <form action="/Cart/Checkout" method="POST">
                    <input type="hidden" name="cartItems" value='<?php echo json_encode(CookieHandler::GetCart()); ?>'>

                    <?php
                    if (count($cartItems) != 0) {
                        ?>

                        <hr>
                        <label for="discountCode">Codigo de Descuento:</label>
                        <input type="text" class="w-100 p-1 rounded" name="discountCode" id="discountCode">

                        <?php
                        if ($exception != null) {
                            ?>

                            <div class="alert alert-danger" role="alert">
                                <?= $exception ?>
                            </div>
                            <?php
                        }
                        ?>

                        <hr>

                        <input type="submit" class="btn btn-primary w-100 p-3" value="Comprar">
                        <?php
                    }
                    ?>

                </form>

            </div>
        </div>
    </div>

</main>