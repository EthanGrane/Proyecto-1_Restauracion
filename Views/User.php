<!-- 
 Esta view es llamada por UserController/View 
 -->

<div class="container d-flex w-100 justify-content-end">
    <a href="/user/logout" class="btn btn-secondary m-3">Logout</a>
</div>

<!-- Perfil de usuario -->
<div class="w-100" style="height: 256px; position: relative;">
    <!-- Fondo -->
    <div
        style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: url('Views/Resources/logo.png'); background-size: cover; background-position: center; filter: blur(10px); z-index: -1;">
    </div>

    <!-- Contenido -->
    <div class="container d-flex flex-column align-items-center justify-content-center h-100">
        <img src="Views/Resources/logo.png" alt="Imagen de perfil" class="rounded-circle"
            style="width: 150px; height: 150px;">

        <h3 class="mt-3 mb-1 text-white"> <?= htmlspecialchars($userSession["UserName"]) ?> </h3>
        <p class="text-white"> <?= htmlspecialchars($userSession["UserMail"]) ?> </p>
    </div>
</div>

<main>
    <!-- Historial de compras -->
    <div class="container mt-4">
        <h2>Historial de compras</h2>
        <div class="row">

            <?php if (count($userOrders) == 0): ?>
                <div class="col-12 mb-3">
                    <div class="border rounded p-3 d-flex justify-content-center">
                        <p>No hay ningún registro de un pedido.</p>
                    </div>
                </div>
            <?php endif; ?>

            <?php for ($i = 0; $i < count($userOrders); $i++): ?>
                <div class="col-12 mb-3">
                    <div class="border rounded p-3">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0"><strong>Fecha:</strong>
                                <?= htmlspecialchars($userOrders[$i]["date"]) ?>
                            </p>
                            <p class="mb-1"><strong>Número de productos:</strong>
                                <?= count($userOrders[$i]["products"]); ?>
                            </p>
                            <p class="mb-1"><strong>Precio total:</strong>
                                <?= htmlspecialchars($userOrders[$i]["total_price"]); ?> €
                            </p>
                        </div>
                        <ul>
                            <?php foreach ($userOrders[$i]["products"] as $product): ?>
                                <li>
                                    <?= htmlspecialchars($product['name']) ?> - <?= htmlspecialchars($product['price']) ?> €
                                </li>
                            <?php endforeach; ?>

                            <?php if (!empty($userOrders[$i]["discount_value"]) && $userOrders[$i]["discount_value"] > 0): ?>
                                <li>
                                    <strong>Descuento:</strong> -<?= htmlspecialchars($userOrders[$i]["discount_value"]) ?> €
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            <?php endfor; ?>

        </div>
    </div>
</main>