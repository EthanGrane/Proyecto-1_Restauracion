<div class="ProductCard">
    <div class="ProductImage">
        <img src="<?= $url ?>" alt="">
    </div>
    
    <p class="ProductName">
        <?= $name ?>
    </p>

    <p class="ProductDescription">
        <?= $description ?>
    </p>

    <form action="Cart/Add" method="POST" class="ProductForm">
        <input type="hidden" name="id" value="<?= $id ?>">
        <button class="bg-none" type="submit" class="ProductLink">+ Añadir al carrito</button>
    </form>
</div>
