<?php

?>

<main>

    <div class="d-flex justify-content-between align-items-center">
        <h1>Checkout</h1>
    </div>

    <div class="container mt-4">
        <div class="row align-items-center pb-3 mt-4">

            <div class="col-8">
                <form action="/cart/finish" method="POST">
                    <input type="hidden" name="cartItems" value='<?=$_POST["cartItems"]?>'>
                    <input type="hidden" name="discountCode" value='<?=$_POST["discountCode"]?>'>

                    <div class="row">
                        <div class="col-5">
                            <h2>Direccion de Compra</h2>
                            <div class="row">
                                <label class="CartLabel">Nombre Completo</label>
                                <input type="text" class="CartInput" value="<?= $userSession["UserName"] ?>">

                                <label class="CartLabel">Email</label>
                                <input type="email" class="CartInput" value="<?= $userSession["UserMail"] ?>">

                                <label class="CartLabel">Provincia</label>
                                <input type="text" class="CartInput">

                                <label class="CartLabel">Codigo Postal</label>
                                <input type="number" class="CartInput">

                                <label class="CartLabel">Direccion</label>
                                <input type="text" class="CartInput">
                            </div>
                        </div>

                        <div class="col-1"></div>

                        <div class="col-5">
                            <h2>Informacion de Pago</h2>
                            <div class="row">
                                <label class="CartLabel">Nombre en la Tarjeta</label>
                                <input type="text" class="CartInput" value="<?= $userSession["UserName"] ?>">

                                <label class="CartLabel">Numero de Tarjeta</label>
                                <input type="text" class="CartInput">

                                <label class="CartLabel">Mes de Caducidad</label>
                                <input type="number" class="CartInput">

                                <label class="CartLabel">Año de Caducidad</label>
                                <input type="number" class="CartInput">
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

                <?php foreach ($cartItems as $product): ?>
                    <div class='d-flex justify-content-end'>
                        <p><?= number_format($product->price, 2, '.', '') ?> €</p>
                    </div>
                <?php endforeach; ?>

                <?php if ($discountValue > 0): ?>
                    <div class="d-flex justify-content-between">
                        <p>Descuento: </p>
                    </div>
                    <div class='d-flex justify-content-end'>
                        <p>- <?= $discountValue ?> €</p>
                    </div>
                <?php endif; ?>

                <hr>

                <div class="d-flex justify-content-between">
                    <p>IVA</p>
                </div>
                <div class='d-flex justify-content-end'>
                    <p><?= $iva ?> €</p>
                </div>

                <hr>

                <div class="d-flex justify-content-between">
                    <p>Total:</p>
                    <p <?= $discountValue > 0 ? 'style="text-decoration: line-through;"' : '' ?>>
                        <?= $totalConIVA ?> €
                    </p>
                </div>

                <?php if ($discountValue > 0): ?>
                    <div class="d-flex justify-content-end">
                        <p><?= $precioFinal ?> €</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
