<?php
include_once("Framework\SessionManager\SessionManager.php");
$userData = SessionManager::GetUserSession();
?>

<script>
    localStorage.setItem("username", "<?php echo $userData['UserName']; ?>");
    localStorage.setItem("email", "<?php echo $userData['UserMail']; ?>");
    localStorage.setItem("password", "<?php echo $userData['UserPassword']; ?>");
</script>

<main style="margin-left: 10%; margin-right: 10%;">

    <div class="card border-0 shadow shadow w-100 me-3">
        <div class="card-header">
            <h5>Create Product</h5>
        </div>

        <!-- Create Products -->
        <div class="card-body d-block">
            <input type="text" name="Method" value="CreateProduct" hidden>

            <div class="mb-3">
                <label for="Create-ProductName" class="form-label">Name</label>
                <input type="text" name="Productname" id="Create-ProductName" class="form-control">
            </div>

            <div class="mb-3">
                <label for="Create-ProductDescription" class="form-label">Description</label>
                <textarea name="ProductDesc" id="Create-ProductDescription" class="form-control" rows="7"></textarea>
            </div>

            <div class="mb-3">
                <label for="Create-ProductPrice" class="form-label">Price</label>
                <input type="text" name="ProductPrice" id="Create-ProductPrice" class="form-control" placeholder="0.00"
                    oninput="formatPrice(this)">
            </div>

            <div class="mb-3">
                <label for="Create-ProductType" class="form-label">Type</label>
                <select name="ProductType" id="Create-ProductType" class="form-select" required>
                    <option value="" disabled selected>Choose a Product Type</option>
                    <option value="MainDish">MainDish</option>
                    <option value="Drink">Drink</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="Create-ProductState" class="form-label">Enabled State</label>
                <input type="checkbox" name="ProductState" id="Create-ProductState" class="form-check-input">
            </div>

            <div class="mb-3">
                <button class="btn btn-primary btn-sm" id="Create-Submit" onclick="AddNewProduct()">Create</button>
            </div>
        </div>



    </div>

    <hr>

    <div class="d-flex">

        <div class="card border-0 shadow shadow w-75 me-3">
            <!-- Page Header -->
            <div class="card-header">
                <h5>Product List</h5>
            </div>

            <!-- List -->
            <div class="card-body">
                <ul class="list-group list-group-flush" id="DOM_productList">

                    <!-- Items Here -->
                    <li class="list-group-item" id="DOM_listItem">

                        <div class="float-end">
                            <button class="btn btn-warning btn-sm me-2" onclick="">Editar</button>
                            <button class="btn btn-danger btn-sm" onclick="">Eliminar</button>
                        </div>
                    </li>

                </ul>
            </div>
            <!-- List END -->
        </div>

        <!-- Div con w-25 -->
        <div class="card border-0 shadow w-25" id="EditCard" hidden>
            <!-- Page Header -->
            <div class="card-header">
                <h5 id="EditTitle">Edit - None</h5>
            </div>

            <!-- Sidebar content -->
            <div class="card-body">
                <input type="text" name="Method" value="EditProduct" hidden>

                <label for="ProductName">Name</label>
                <input type="text" name="Productname" id="Edit-ProductName">

                <label for="ProductDesc">Description</label>
                <textarea name="ProductDesc" id="Edit-ProductDescription" rows="7" cols="auto"></textarea>


                <label for="ProductPrice">Price</label>
                <input type="text" name="ProductPrice" id="Edit-ProductPrice" class="form-control" placeholder="0.00"
                    oninput="formatPrice(this)">


                <label for="Edit-ProductType">Type</label>
                <select name="ProductType" id="Edit-ProductType" class="form-select" required>
                    <option value="" disabled selected>Choose a Product Type</option>
                    <option value="MainDish">MainDish</option>
                    <option value="Drink">Drink</option>
                </select>


                <label for="ProductState" id="Label-ProductState">Enabled State</label>
                <input type="checkbox" name="ProductState" id="Edit-ProductState">

                <br>
                <button class="btn btn-primary btn-sm" id="Edit-Submit" onclick="EditProduct()">Edit</button>
            </div>
        </div>

        <!-- Div con w-25 -->
        <div class="card border-0 shadow w-25" id="DeleteCard" hidden>
            <!-- Page Header -->
            <div class="card-header">
                <h5 id="DeleteTitle">Delete - Name</h5>
            </div>

            <!-- Sidebar content -->
            <div class="card-body">
                <input type="text" name="Method" value="DeleteProduct" hidden>

                <label for="ProductName">Confirm Name</label>
                <input type="text" name="Productname" id="Delete-ProductName">

                <br>
                <button class="btn btn-primary btn-sm" id="Delete-Submit" onclick="DeleteProduct()">Delete</button>
                <p class="alert alert-danger" id="Delete-Error">Name do not match</p>
            </div>

        </div>

    </div>
</main>

<script src="\Views\AdminPanel\Products.js"></script>
<script>
    function formatPrice(input) {
        let value = input.value.replace(/[^0-9.]/g, '');
        let parts = value.split('.');

        if (parts.length > 2) {
            value = parts[0] + '.' + parts.slice(1).join('');
        }

        if (parts[1]?.length > 2) {
            value = `${parts[0]}.${parts[1].slice(0, 2)}`;
        }

        input.value = value;
    }

</script>