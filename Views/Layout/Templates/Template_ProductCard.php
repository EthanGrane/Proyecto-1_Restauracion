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

    <a href="Cart/Add?id=<?=$id?>" class="ProductLink">
        + Añadir al carrito
    </a>
</div>