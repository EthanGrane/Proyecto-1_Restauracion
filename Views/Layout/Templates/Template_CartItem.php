<div class="container mt-4">
    <div class="row align-items-center border-bottom-neutral pb-3">

        <!-- Imagen del producto -->
        <div class="col-2">
            <img src="Views\Resources\<?=$type?>_<?=$name?>.png" alt="<?=$name?>" class="img-fluid" style="height:100px;">
        </div>

        <!-- Nombre y descripción -->
        <div class="col-8">
            <h3 class="mb-0 text-primary CartItem_Title"><?=$name?></h3>
            <a href="#" class="text-success text-decoration-none  text-highlight CartItem_Description">> Mostrar Descripción</a>
        </div>

        <!-- Precio -->
        <div class="col-1">
            <form action="Cart/Remove" method="POST">
                <input type="hidden" name="id" value="<?= $id ?>">
                <button class="btn btn-secondary">
                    Remove
                </button>
            </form>
        </div>

        <!-- Precio -->
        <div class="col-1 text-end">
            <p class="mb-0 fw-bold CartItem_Price"><?=$price?> €</p>
        </div>
    </div>
</div>