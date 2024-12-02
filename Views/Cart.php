<?php
include_once("Framework\DAO\DAO.php");
include_once("Framework\ViewSystem\ViewSystem.php");
try {
    $dao = new DAO();
} catch (Exception $e) {
    $dao = null;
}
?>
<main>

    <?php
    for ($i = 0; $i < 3; $i++) {
        ViewSystem::PrintCartItem(null);
    }
    ?>

    <div class="container mt-4">
        <div class="row align-items-center pb-3 mt-4">
            <div class="col-8">
            </div>

            <div class="col-4">
                <div class="d-flex justify-content-between">
                    <p>Subtotal</p>
                    <p>10,25 €</p>
                </div>

                <?php
                for ($i=0; $i < 3; $i++) { 
                    # code...
                // Subtotal de precios en el carrito
                $price = 10.25;
                echo"
                <div class='d-flex justify-content-end'>
                    <p>$price €</p>
                </div>
                ";
                }
                ?>


                <hr>
                <div class="d-flex justify-content-between">
                    <p>Total:</p>
                    <p>10,00€</p>
                </div>
            </div>
        </div>
    </div>
</main>