<?php
include_once("Framework/DAO/DAO.php");
include_once("Framework/ViewSystem/ViewSystem.php");
include_once("Framework/CookieHandler/CookieHandler.php");
include_once("Framework/SessionManager/SessionManager.php");

try {
    // Esto evita que puedas añadir mas items al carro mientras estas en el checkout
    $cart = json_decode($_POST["cartItems"], true);
    $discountCode = $_POST["discountCode"];

    // DAO
    $dao = new DAO();

    // Product data
    $cartData = $dao->GetProductsDataByIDs($cart);

    // Discount data
    if ($discountCode != "")
        $discountData = $dao->GetDiscountDataByCode($discountCode);

    $dao->CloseConnection();
    // DAO END

    $userSession = SessionManager::GetUserSession();

    // Guarda los datos de los productos del carrito para mostrarlos posteriormente.
    $cartItems = [];
    foreach ($cart as $productId) {
        for ($i = 0; $i < count($cartData); $i++) {
            if ($productId == $cartData[$i]["id"]) {
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
        <h1>Checkout</h1>
    </div>

    <div class="container mt-4">
        <div class="row align-items-center pb-3 mt-4">

            <!-- Checkout Form -->
            <div class="col-8">
                <form action="/cart/finish" method="POST">
                    <input type="hidden" name="cartItems" value='<?php echo $_POST["cartItems"]; ?>'>
                    <input type="hidden" name="discountCode" value='<?php echo $_POST["discountCode"]; ?>'>

                    <div class="row">
                        <div class="col-5">
                            <h2>Direccion de Compra</h2>
                            <div class="row">
                                <label for="" class="CartLabel">Nombre Completo</label>
                                <input type="text" name="" class="CartInput" value="<?= $userSession["UserName"] ?>"
                                    lolxd>

                                <label for="" class="CartLabel">Email</label>
                                <input type="email" name="" class="CartInput" value="<?= $userSession["UserMail"] ?>"
                                    lolxd>

                                <label for="" class="CartLabel">Provincia</label>
                                <input type="text" name="" class="CartInput" lolxd>

                                <label for="" class="CartLabel">Codigo Postal</label>
                                <input type="number" name="" class="CartInput" lolxd>

                                <label for="" class="CartLabel">Direccion</label>
                                <input type="text" name="" class="CartInput" lolxd>
                            </div>
                        </div>

                        <div class="col-1"></div>

                        <div class="col-5">
                            <h2>Informacion de Pago</h2>
                            <div class="row">
                                <label for="" class="CartLabel">Nombre en la Tarjeta</label>
                                <input type="text" name="" class="CartInput" value="<?= $userSession["UserName"] ?>"
                                    lolxd>

                                <label for="" class="CartLabel">Numero de Tarjeta</label>
                                <input type="text" name="" class="CartInput" lolxd>

                                <label for="" class="CartLabel">Mes de Caducidad</label>
                                <input type="number" name="" class="CartInput" lolxd>

                                <label for="" class="CartLabel">Año de Caducidad</label>
                                <input type="number" name="" class="CartInput" lolxd>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        <input type="submit" class="btn btn-primary w-50 m-3" value="Comprar">
                    </div>

                </form>
            </div>

            <!-- Subtotal -->
            <div class="col-4">
                <div class="d-flex justify-content-between">
                    <p>Subtotal: </p>
                </div>

                <?php
                /*
                 * Calculo del precio total y individual 
                 */
                $totalPrice = 0.0;
                for ($i = 0; $i < count($cartItems); $i++) {
                    $totalPrice += $cartItems[$i]["price"];
                    echo "
                <div class='d-flex justify-content-end'>
                    <p>" . $cartItems[$i]['price'] . " €</p>
                </div>
                ";
                }

                /*
                 * Calculo del descuento y resta del precio final
                 */

                // DISCOUNT
                $discountValue = 0;
                if ($discountCode != "") {
                    if ($discountData["discount_type"] == 0) {
                        $discountValue = $totalPrice * ($discountData["value"] * 0.01);
                        // Respeta que el numero tenga 2 decimales.
                        $discountValue = number_format($discountValue, 2, '.', '');
                    } elseif ($discountData["discount_type"] == 1) {
                        $discountValue = $discountData["value"];
                        // Respeta que el numero tenga 2 decimales.
                        $discountValue = number_format($discountValue, 2, '.', '');
                    }
                    ?>

                    <div class="d-flex justify-content-between">
                        <p>Descuento: </p>
                    </div>
                    <div class='d-flex justify-content-end'>
                        <p>- <?= $discountValue ?> €</p>
                    </div>

                    <?php
                    // DISCOUNT END
                }
                ?>

                <hr>

                <div class="d-flex justify-content-between">
                    <p>IVA</p>
                </div>
                <div class='d-flex justify-content-end'>
                    <p>
                        <?= number_format($totalPrice * 0.1, 2, '.', ''); ?> €
                    </p>
                </div>

                <hr>

                <div class="d-flex justify-content-between">
                    <p>Total:</p>

                    <p <?php
                    // Aplica un estilo de 'tachado' al <p> si hay un descuento aplicado
                    if ($discountCode != "")
                        echo 'style="text-decoration: line-through;"';
                    ?>>
                    <?= number_format($totalPrice * 1.1, 2, '.', ''); ?>€
                    </p>
                </div>

                <?php
                // TOTAL DESCUENTO
                if ($discountCode != "") {
                    ?>

                    <div class="d-flex justify-content-end">
                        <p><?= $totalPrice - $discountValue ?>€</p>
                    </div>

                    <?php
                    // TOTAL DESCUENTO END
                }
                ?>

            </div>
        </div>
    </div>

</main>