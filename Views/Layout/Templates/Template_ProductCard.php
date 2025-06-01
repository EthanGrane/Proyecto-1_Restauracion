<div class="ProductCard">
    <div class="ProductImage">
        <img src="<?= $url ?>" alt="<?= htmlspecialchars($product->name) ?>">
    </div>
    
    <p class="ProductName">
        <?= htmlspecialchars($product->name) ?>
    </p>

    <p class="ProductDescription">
        <?= htmlspecialchars($product->description) ?>
    </p>

    <form action="Cart/Add" method="POST" class="ProductForm">
        <input type="hidden" name="id" value="<?= $product->id ?>">
        <button class="bg-none" type="submit" class="ProductLink">+ Añadir al carrito</button>
    </form>
</div>
