<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" height="40">
            ITMedium
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown">
                        Services
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#software">Software Development</a></li>
                        <li><a class="dropdown-item" href="#web">Web Solutions</a></li>
                        <li><a class="dropdown-item" href="#mobile">Mobile Apps</a></li>
                        <li><a class="dropdown-item" href="#domain">Domain & Hosting</a></li>
                        <li><a class="dropdown-item" href="#marketing">Digital Marketing</a></li>
                        <li><a class="dropdown-item" href="#education">Educational Services</a></li>
                        <li><a class="dropdown-item" href="#consultancy">Hybrid Consultancy</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="#portfolio">Portfolio</a></li>
                <li class="nav-item"><a class="nav-link" href="#testimonials">Testimonials</a></li>
                <li class="nav-item"><a class="nav-link" href="#blog">Blog</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                <li class="nav-item">
                    <a class="nav-link btn btn-primary text-white ms-2" href="{{ route('login') }}">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
