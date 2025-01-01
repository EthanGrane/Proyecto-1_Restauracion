<?php
include_once("Framework\DAO\DAO.php");
include_once("Framework\ViewSystem\ViewSystem.php");
include_once("Framework\CookieHandler\CookieHandler.php");
include_once("Framework\SessionManager\SessionManager.php");

try {
    $cart = CookieHandler::GetCart();

    $dao = new DAO();
    $cartData = $dao->GetProductsDataByIDs($cart);
    $dao->CloseConnection();

    $userSession = SessionManager::GetUserSession();

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
        <h1>Checkout</h1>
    </div>

    <div class="container mt-4">
        <div class="row align-items-center pb-3 mt-4">

            <!-- Checkout Form -->
            <div class="col-8">
                <form action="\cart\finish" method="POST">

                    <div class="row">
                        <div class="col-5">
                            <h2>Direccion de Compra</h2>
                            <div class="row">
                                <label for="" class="CartLabel">Nombre Completo</label>
                                <input type="text" name="" class="CartInput" value="<?=$userSession["UserName"]?>" lolxd>

                                <label for="" class="CartLabel">Email</label>
                                <input type="email" name="" class="CartInput" value="<?=$userSession["UserMail"]?>" lolxd>

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
                                <input type="text" name="" class="CartInput" value="<?=$userSession["UserName"]?>" lolxd>

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

            </div>
        </div>
    </div>

</main>