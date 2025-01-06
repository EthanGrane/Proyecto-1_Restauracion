<div class="d-flex justify-content-center align-items-center"
    style="height: 620px; background-image: url('/Views/Resources/LoginBackground.jpg'); background-size: cover; background-position: center;">
    <div class="container bg-dark border border-secondary p-4 pt-5"
        style="width: 90%; max-width: 400px; height: auto; border-radius: 8px;">

        <form action="/User/Login" method="POST" class="row g-4 d-flex flex-column align-items-center">

            <!-- Email -->
            <div class="col-12 w-100">
                <label for="email" class="form-label text-light">Correo Electrónico</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <!-- Password -->
            <div class="col-12 w-100">
                <label for="password" class="form-label text-light">Contraseña</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <!-- Recuperar contraseña -->
            <div class="col-12 text-end w-100">
                <a class="text-secondary text-decoration-none" href="#">Recuperar contraseña</a>
            </div>

            <!-- Submit Button -->
            <div class="col-12 d-grid w-100">
                <button type="submit" class="btn btn-secondary">Iniciar Sesión</button>
            </div>

            <p class=" text-secondary" style="color:red !important; max-height:64px; overflow:hidden;">
                <?php
                $exception = SessionManager::GetException();
                echo $exception;
                ?>
            </p>

            <hr class="w-100 text-secondary">

            <!-- Crear cuenta -->
            <div class="col-12 text-center">
                <a class="text-secondary text-decoration-none" href="/Signin">Crear una cuenta nueva</a>
            </div>
        </form>

    </div>
</div>