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
    <div class="d-flex">

        <div class="card border-0 shadow shadow w-75 me-3">
            <!-- Page Header -->
            <div class="card-header">
                <h5>User List</h5>
            </div>

            <!-- List -->
            <div class="card-body">
                <ul class="list-group list-group-flush" id="UserList">

                    <!-- Items Here -->
                    <li class="list-group-item" id="listItem">

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
        <div class="card border-0 shadow w-25" id="EditCard">
            <!-- Page Header -->
            <div class="card-header">
                <h5 id="EditTitle">Edit - None</h5>
            </div>

            <!-- Sidebar content -->
            <div class="card-body">
                <input type="text" name="Method" value="EditUser" hidden>

                <label for="Username">Username</label>
                <input type="text" name="Username" id="Edit-Username">

                <label for="Email">Email</label>
                <input type="email" name="Email" id="Edit-Email">

                <label for="Password">Password</label>
                <input type="text" name="Password" id="Edit-Password">

                <label for="Role">Admin</label>
                <input type="checkbox" name="Role" id="Edit-Role">
                <br>
                <button class="btn btn-primary btn-sm" id="Edit-Submit" onclick="EditUser()">Edit</button>
            </div>
        </div>

    </div>
</main>

<script src="\Views\AdminPanel\Users.js"></script>