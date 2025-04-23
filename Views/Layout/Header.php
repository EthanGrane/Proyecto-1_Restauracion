<header>
    <div class="w-75 m-auto d-flex align-items-center justify-content-between py-2">

        <!-- Menú de navegación Desktop -->
        <nav id="navbarMenuDesktop" class="w-75 m-auto collapse navbar-collapse d-none d-md-flex justify-content-between">
            <a href="/"> <img src="\Views\Resources\logo.png" alt="Logo" width="42"> </a>
            
            <a class="NavLink nav-link mx-3 text-secondary" href="/">Home</a>
            <a class="NavLink nav-link mx-3 text-secondary" href="/Location">Restaurantes</a>
            <a class="NavLink nav-link mx-3 text-secondary" href="/Menu">Menu</a>
            <a class="NavLink nav-link mx-3 text-secondary" href="/AboutUs">Sobre nosotros</a>

            <a href="/User" class="HeaderIcon mx-2"> <img src="\Views\Resources\User_Icon.png" alt="User Icon" class="img-fluid" width="24"> </a>
            <a href="/Cart" class="HeaderIcon mx-2"> <img src="\Views\Resources\Shop-Cart_Icon.png" alt="Shop Cart Icon" class="img-fluid" width="24"> </a>
        </nav>

        <!-- Menú de navegación Mobile -->
        <nav id="navbarMenuMobile" class="collapse navbar-collapse d-flex d-md-none justify-content-left">

            <div class="dropdown-center">
                <button class="btn btn-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">

                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-list" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
                    </svg>

                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="/">Home</a></li>
                    <li><a class="dropdown-item" href="/Location">Restaurantes</a></li>
                    <li><a class="dropdown-item" href="/Menu">Menu</a></li>
                    <li><a class="dropdown-item" href="/Contact">Contact us</a></li>
                </ul>
            </div>
        </nav>
    </div>
</header>