<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once("Views/Layout/Head.php"); ?>

    <title>Index</title>
</head>


<body class="bg-dark">
    <div class="container my-5">
        <div class="row">
            <div class="card p-3" style="background-color:#E8EBED;">

                <!-- NAV -->
                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="container-fluid">

                        <a class="navbar-brand" href="\AdminPanel">
                            <img src="\Views\Resources\logo.png" alt="Logo" width="30" height="30"
                                class="d-inline-block align-top">
                            Crispy-19
                        </a>

                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav d-flex justify-content-between w-50">
                                <li class="nav-item">
                                    <a class="nav-link text-dark" href="\AdminPanel\Users">Users</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-dark" href="\AdminPanel\Products">Products</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-dark" href="\AdminPanel\Discounts">Discounts</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <?php include_once($viewPath); ?>

            </div>
        </div>
    </div>
</body>


<?php include_once("Views/Layout/Footer.php"); ?>

</html>