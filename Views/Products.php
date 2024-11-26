<?php
include_once("Framework\DAO\DAO.php");
include_once("Framework\ViewSystem\ViewSystem.php");
try
{
    $dao = new DAO();
}
catch(Exception $e)
{
    echo $e;
    $dao = null;
}
?>

<main>
    <h1 class="MainTitle">MENU</h1>
    <h3>Platos principales, Platos secundarios, Bebidas y postres.</h3>

    <div class="SmallSpace"> </div>

    <h2>PLATOS PRINCIPALES</h2>
    <h3>Join the hype train with the hottest products in our arsenal</h3>

    <div class="container-fluid row justify-content-center" style="width: auto;">

    <?php
    $products = $dao->GetAllProductsByType("MainDish");
    
    for ($i=0; $i < 5; $i++) { 
        foreach($products as $product)
        {
            ViewSystem::PrintProductCard($product["name"],$product["description"],$product["image"]);
        }    }

    ?>

    </div>

    <div class="SmallSpace"> </div>

    <h2>BEBIDAS</h2>
    <h3>Join the hype train with the hottest products in our arsenal</h3>

    <?php
    $products = $dao->GetAllProductsByType("Drink");
    
    foreach($products as $product)
    {
        ViewSystem::PrintProductCard($product["name"],$product["description"],$product["image"]);
    }
    ?>
</main>

<?php
$dao->CloseConnection();
?>