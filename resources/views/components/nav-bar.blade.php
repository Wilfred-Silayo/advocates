<div class="container-fluid p-0">
    <nav class="navbar navbar-expand-lg" data-bs-theme="dark" style="background-color: #1979a1;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{asset('images/logo.png')}}" class="rounded-circle border border-white p-2" alt="Brand Log" width="80">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    @auth
                    <li class="nav-item">
                        <x-nav-link title="Dashboard" route="#" />
                    </li>
                    <li class="nav-item">
                        <x-nav-link title="Messages" route="#" />
                    </li>
                    <li class="nav-item dropdown me-2">
                        <a class="nav-link  dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Actions
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" data-bs-theme="light">
                            <li><a class="dropdown-item fw-bold" href="#">Profile</a></li>
                            <li><a class="dropdown-item fw-bold" href="#">Logout</a></li>
                        </ul>
                    </li>

                    @else
                    <li class="nav-item">
                        <x-nav-link title="Home" route="home" id="home" />
                    </li>
                    <li class="nav-item">
                        <x-nav-link title="About Us" route="home" id="about" />
                    </li>
                    <li class="nav-item dropdown me-2">
                        <a class="nav-link fs-4 dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Services
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" data-bs-theme="light">
                            <li><a class="dropdown-item fw-bold" href="#service-1">Privacy and Data Protection</a></li>
                            <li><a class="dropdown-item fw-bold" href="#service-2">Cybersecurity</a></li>
                            <li><a class="dropdown-item fw-bold" href="#service-3">Artificial Intelligence (AI) </a></li>
                            <li><a class="dropdown-item fw-bold" href="#service-4">Research and policies</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown me-2">
                        <a class="nav-link fs-4 dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Resources
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" data-bs-theme="light">
                            <li><a class="dropdown-item fw-bold" href="#">Reports</a></li>
                            <li><a class="dropdown-item fw-bold" href="#">Articles</a></li>
                            <li><a class="dropdown-item fw-bold" href="#">Guidelines</a></li>
                            <li><a class="dropdown-item fw-bold" href="#">News and Updates</a></li>
                        </ul>
                    </li>
                    <x-nav-link title="Contacts" route="home" id="contacts" />
                    <li class="nav-item">
                        <a class="nav-link fs-4 text-white" href="#" data-bs-toggle="offcanvas"
                            data-bs-target="#loginOffcanvas" aria-controls="loginOffcanvas">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-4 text-white" href="#" data-bs-toggle="offcanvas"
                            data-bs-target="#registerOffcanvas" aria-controls="registeerOffcanvas">Register</a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
</div>


<!-- Auth components -->
<x-login-form />
<x-registration-form />