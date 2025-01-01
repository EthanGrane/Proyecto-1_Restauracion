<?php
require_once("Framework\SessionManager\SessionManager.php");

$name = SessionManager::GetUserSession()["UserName"];
$mail = SessionManager::GetUserSession()["UserMail"];
?>

<div class="container d-flex w-100 justify-content-end">
    <a href="\user\logout" class="btn btn-secondary m-3">Logout</a>
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

        <h3 class="mt-3 mb-1 text-white"> <?= $name ?> </h3>
        <p class="text-white"> <?= $mail ?> </p>

    </div>
</div>


<main>
    <!-- Historial de compras -->
    <div class="container mt-4">
        <h2>Historial de compras</h2>
        <div class="row">

            <?php
            
            for ($i = 0; $i < 5; $i++) {
                ?>

                <div class="col-12 mb-3">
                    <div class="border rounded p-3 d-flex justify-content-between">
                        <p class="mb-0"><strong>Fecha:</strong> 21/2/2020</p>
                        <p class="mb-1"><strong>Número de pedidos:</strong> 5</p>
                        <p class="mb-1"><strong>Precio total:</strong> 10.00€</p>
                    </div>
                </div>

                <?php
            }
            ?>
        </div>
    </div>
</main>