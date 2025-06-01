<main>
    <div class="d-flex justify-content-between align-items-center">
        <h1>My Cart</h1>
        <?php if (count($cartItems) > 0): ?>
            <form action="Cart/Clear" method="POST">
                <button class="btn btn-secondary" style="border: 1px solid var(--Primary) !important;">
                    Vaciar Carrito
                </button>
            </form>
        <?php endif; ?>
    </div>

    <?php if (count($cartItems) > 0): ?>
        <?php foreach ($cartItems as $item): ?>
            <?php ViewSystem::PrintCartItem($item); ?>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="container mt-4">
            <div class="row align-items-center border-bottom-neutral pb-3">
                <div class="w-100 d-flex justify-content-center">
                    <a href="/Menu" class="btn btn-secondary">Ver Menu</a>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="container mt-4">
        <div class="row align-items-center pb-3 mt-4">
            <div class="col-8"></div>
            <div class="col-4">
                <div class="d-flex justify-content-between">
                    <p>Subtotal: </p>
                </div>
                <?php foreach ($cartItems as $item): ?>
                    <div class='d-flex justify-content-end'>
                        <p><?= $item->price ?> €</p>
                    </div>
                <?php endforeach; ?>

                <hr>

                <div class="d-flex justify-content-between">
                    <p>IVA</p>
                </div>
                <div class='d-flex justify-content-end'>
                    <p><?= $iva ?></p>
                </div>

                <hr>

                <div class="d-flex justify-content-between">
                    <p>Total:</p>
                    <p><?= $totalConIVA ?>€</p>
                </div>

                <form action="/Cart/Checkout" method="POST">
                    <input type="hidden" name="cartItems" value='<?= json_encode(CookieHandler::GetCart()); ?>'>
                    <?php if (count($cartItems) > 0): ?>
                        <hr>
                        <label for="discountCode">Codigo de Descuento:</label>
                        <input type="text" class="w-100 p-1 rounded" name="discountCode" id="discountCode">

                        <?php if ($exception != null): ?>
                            <div class="alert alert-danger" role="alert">
                                <?= $exception ?>
                            </div>
                        <?php endif; ?>

                        <hr>
                        <input type="submit" class="btn btn-primary w-100 p-3" value="Comprar">
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</main>
