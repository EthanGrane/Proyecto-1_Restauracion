<main>
    <h1 class="MainTitle">MENU</h1>
    <h3>Platos principales, Platos secundarios, Bebidas y postres.</h3>

    <div class="SmallSpace"></div>

    <h2>PLATOS PRINCIPALES</h2>
    <h3>Join the hype train with the hottest products in our arsenal</h3>

    <div class="container-fluid row justify-content-center" style="width: auto;">
        <?php foreach ($primaryProducts as $product): ?>
            <?php ViewSystem::PrintProductCard($product); ?>
        <?php endforeach; ?>

    </div>

    <div class="SmallSpace"></div>

    <h2>BEBIDAS</h2>
    <h3>Join the hype train with the hottest products in our arsenal</h3>

    <div class="container-fluid row justify-content-center" style="width: auto;">
        <?php foreach ($drinkProducts as $product): ?>
            <?php ViewSystem::PrintProductCard($product); ?>
        <?php endforeach; ?>
    </div>
</main>

<?php if (count($cart) != 0): ?>
    <div class="fixed-bottom bg-dark p-2 shadow-sm p-3 border-top">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <p class="mb-0 text-white">Carrito</p>
                <p class="mb-0 text-white"><?= count($cart) ?> Items seleccionados</p>
            </div>
            <a href="/Cart"
                style="background-color: #28a745; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none;">
                Finalizar compra.
            </a>
        </div>
    </div>
<?php endif; ?>