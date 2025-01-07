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
            <h5>Create Discount</h5>
        </div>

        <!-- Create Discount -->
        <div class="card-body d-block">
            <input type="text" name="Method" value="CreateDiscount" hidden>

            <div class="mb-3">
                <label for="Create-DiscountCode" class="form-label">Discount Code</label>
                <input type="text" name="Create-DiscountCode" id="Create-DiscountCode" class="form-control">
            </div>

            <div class="mb-3">
                <label for="Create-DiscountAmount" class="form-label">Discount Amount</label>
                <input type="text" name="Create-DiscountAmount" id="Create-DiscountAmount" class="form-control" placeholder="0.00"
                    oninput="formatPrice(this)">
            </div>

            <div class="mb-3">
                <label for="Create-ProductType" class="form-label">Discount Type</label>
                <select name="ProductType" id="Create-ProductType" class="form-select" required>
                    <option value="" disabled selected>Choose a Discount Type</option>
                    <option value="MainDish">Fixed</option>
                    <option value="Drink" selected>Percent</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="Create-ProductState" class="form-label">Enabled State</label>
                <input type="checkbox" name="ProductState" id="Create-ProductState" class="form-check-input">
            </div>

            <div class="mb-3">
                <button class="btn btn-primary btn-sm" id="Create-Submit" onclick="CreateDiscount()">Create</button>
            </div>
        </div>



    </div>

    <hr>

    <div class="d-flex">

        <div class="card border-0 shadow shadow w-100 me-3">
            <!-- Page Header -->
            <div class="card-header">
                <h5>Discount List</h5>
            </div>

            <!-- List -->
            <div class="card-body">
                <ul class="list-group list-group-flush" id="DOM_DiscountList">

                    <!-- Items Here -->
                    <li class="list-group-item" id="DOM_listItem">
                        <div class="float-end">
                            <button class="btn btn-danger btn-sm" onclick="">Eliminar</button>
                        </div>
                    </li>

                </ul>
            </div>
            <!-- List END -->
        </div>
    </div>
</main>

<script src="\Views\AdminPanel\Discounts.js"></script>
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

    let numericValue = parseFloat(value);
    if (numericValue < 0) {
        value = '0';
    } else if (numericValue > 100) {
        value = '100';
    }

    input.value = value;
}
</script>