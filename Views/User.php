<?php
require_once("Framework\SessionManager\SessionManager.php");

$userSession = SessionManager::GetUserSession();
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

        <h3 class="mt-3 mb-1 text-white"> <?= $userSession["UserName"] ?> </h3>
        <p class="text-white"> <?= $userSession["UserMail"] ?> </p>

    </div>
</div>


<main>
    <!-- Historial de compras -->
    <div class="container mt-4">
        <h2>Historial de compras</h2>
        <div class="row">

            <?php
            $dao = new DAO();
            $orders = $dao->GetOrdersByUserId($userSession["UserID"]);

            if (count($orders) == 0) {
                ?>
                <div class="col-12 mb-3">
                    <div class="border rounded p-3 d-flex justify-content-center">
                        <p>No hay ningun registro de un pedido.</p>
                    </div>
                </div>
                <?php
            }

            for ($i = 0; $i < count($orders); $i++) 
            {
                $ordersProducts = $dao->GetProductsByOrderId($orders[$i]["id_order"]);
                ?>

                <div class="col-12 mb-3">
                    <div class="border rounded p-3">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0"><strong>Fecha:</strong>
                                <?= $orders[$i]["date"] ?>
                            </p>
                            <p class="mb-1"><strong>Número de productos:</strong>
                                <?= count($ordersProducts); ?>
                            </p>
                            <p class="mb-1"><strong>Precio total:</strong>
                                <?= $orders[$i]["final_price"]; ?> €
                            </p>
                        </div>
                        <ul>
                            <?php
                            /*
                             * Muestra los productos del pedido y los precios
                             */
                            // Almacena los IDS para pasarlos por la funcion de GetProductDataByIds que devuelve la informacion de los productos desde la BBDD
                            $productsID = array_column($ordersProducts, 'id_product');
                            $productData = $dao->GetProductsDataByIDs($productsID);

                            for ($j = 0; $j < count($productData); $j++) 
                            {
                                echo "
                                <div class='d-flex justify-content-center'>
                                    <div class='w-50 p-1'>
                                        <div class='d-flex justify-content-between'>
                                            <p>" . $productData[$j]['name'] . "</p>
                                            <p>" . $productData[$j]['price'] . " €</p>
                                        </div>
                                    </div>
                                </div>
                                ";
                            }

                            if($orders[$i]["id_discount"] != null)
                            {
                                $currentOrderDiscountData = $dao->GetDiscountDataById($orders[$i]["id_discount"]);
                                
                                if($currentOrderDiscountData["discount_type"] == 0)
                                {
                                    $currentOrderDiscountValue = $orders[$i]["final_price"] * ($currentOrderDiscountData["value"] * 0.01);
                                }
                                else if($currentOrderDiscountData["discount_type"] == 1)
                                {
                                    $currentOrderDiscountValue = $currentOrderDiscountData["value"];
                                }
                                
                                $currentOrderDiscountValue = number_format($currentOrderDiscountValue, 2, '.', '');

                                
                                echo"
                                <div class='d-flex justify-content-center'>
                                    <div class='w-50 p-1'>
                                        <div class='d-flex justify-content-between'>
                                            <p>Descuento</p>
                                            <p>- $currentOrderDiscountValue €</p>
                                        </div>
                                    </div>
                                </div>
                                ";
                            }

                            ?>
                        </ul>
                    </div>
                </div>

                <?php
            }
            ?>
        </div>
    </div>
</main>

<?php
$dao->CloseConnection();
?>