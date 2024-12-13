<!-- Display on Medium or Large (Desktop) -->
<div class="container mt-4 d-none d-lg-block">
    <div class="row align-items-center border-bottom-neutral pb-3 g-3">

        <!-- Imagen del producto -->
        <div class="col-3 col-md-2">
            <img src="Views\Resources\<?= $type ?>_<?= $name ?>.png" alt="<?= $name ?>" class="img-fluid"
                style="max-height: 100px; width: auto;">
        </div>

        <!-- Nombre y descripción -->
        <div class="col-7">
            <h3 class="mb-0 text-primary CartItem_Title"><?= $name ?></h3>
            <a href="#" class="text-success text-decoration-none  text-highlight CartItem_Description">> Mostrar
                Descripción</a>
        </div>

        <!-- Borrar Carro -->
        <div class="col-1">
            <form action="Cart/Remove" method="POST">
                <input type="hidden" name="id" value="<?= $id ?>">
                <button class="btn btn-secondary">
                    Remove
                </button>
            </form>
        </div>

        <!-- Precio -->
        <div class="col-2 text-end">
            <p class="mb-0 fw-bold CartItem_Price"><?= $price ?> €</p>
        </div>

    </div>
</div>


<!-- Display on Medium or Large (Tablet) -->
<div class="container mt-4 d-none d-lg-none d-md-block">
    <div class="row align-items-center border-bottom-neutral pb-3 g-3">

        <!-- Imagen del producto -->
        <div class="col-3 col-md-2">
            <img src="Views\Resources\<?= $type ?>_<?= $name ?>.png" alt="<?= $name ?>" class="img-fluid"
                style="max-height: 100px; width: auto;">
        </div>

        <!-- Nombre y descripción -->
        <div class="col-6">
            <h3 class="mb-0 text-primary CartItem_Title"><?= $name ?></h3>
            <a href="#" class="text-success text-decoration-none  text-highlight CartItem_Description">> Mostrar
                Descripción</a>
        </div>

        <!-- Borrar Carro -->
        <div class="col-2">
            <form action="Cart/Remove" method="POST">
                <input type="hidden" name="id" value="<?= $id ?>">
                <button class="btn btn-secondary">
                    Remove
                </button>
            </form>
        </div>

        <!-- Precio -->
        <div class="col-2 text-end">
            <p class="mb-0 fw-bold CartItem_Price"><?= $price ?> €</p>
        </div>

    </div>
</div><!-- Display only on Small (Movile) -->
<div class="container mt-4 d-sm-block d-md-none">
    <div class="row align-items-center border-bottom-neutral pb-3">

        <!-- Imagen del producto -->
        <div class="col-4 col-md-2">
            <img src="Views\Resources\<?= $type ?>_<?= $name ?>.png" alt="<?= $name ?>" class="img-fluid"
                style="max-height: 100px; width: auto;">
        </div>

        <!-- Nombre y descripción -->
        <div class="col-5">
            <h3 class="mb-0 text-primary CartItem_Title" style="font-size: 16px;"><?= $name ?></h3>
        </div>

        <!-- Precio -->
        <div class="col-3 text-end">
            <p class="mb-0 fw-bold CartItem_Price" style="font-size: 16px;"><?= $price ?> €</p>
        </div>

    </div>
</div>