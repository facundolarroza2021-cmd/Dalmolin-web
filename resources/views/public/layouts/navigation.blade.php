<nav class="navbar" x-data="{ open: false }">
    <div class="navbar-container">
        
        <ul class="navbar-menu">
            <li><a href="{{ route('home') }}">Comprar</a></li>
            <li><a href="#">Vender</a></li>
        </ul>
    
        <a href="{{ route('home') }}" class="navbar-logo">
            <img src="{{ asset('img/dalmolin_logo2.png') }}" alt="Rodrigo Dalmolin">
        </a>
    
        <ul class="navbar-menu">
            <li><a href="#">Tasar</a></li>
            <li><a href="#">Alquilar</a></li>
        </ul>
    
        <div class="navbar-icons">
            <a href="#" class="navbar-social"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#" class="navbar-social"><i class="fa-brands fa-instagram"></i></a>
            
            @auth
                <a href="{{ route('admin.dashboard') }}" class="navbar-user" title="Ir al Panel"><i class="fa-solid fa-user-gear"></i></a>
            @else
                <a href="{{ route('login') }}" class="navbar-user"><i class="fa-solid fa-user"></i></a>
            @endauth
        </div>
    
        <button class="navbar-toggle" @click="open = !open">
            <i class="lucide lucide-menu" x-show="!open"></i>
            <i class="lucide lucide-x" x-show="open" style="display:none"></i>
        </button>
    </div>
    
    <div class="navbar-mobile" x-show="open" style="display: none;">
        <a href="{{ route('home') }}">Inicio</a>
        <a href="#">Nosotros</a>
        <a href="#">Contacto</a>
    </div>
</nav>

<div class="mini-navbar">
    <div class="mini-navbar-container">
        <a href="{{ route('home', ['tipo' => 'casa']) }}"><i class="fa-solid fa-house"></i> Casas</a>
        <a href="{{ route('home', ['tipo' => 'departamento']) }}"><i class="fa-solid fa-building"></i> Deptos</a>
        <a href="{{ route('home', ['tipo' => 'terreno']) }}"><i class="fa-solid fa-map"></i> Terrenos</a>
        <a href="{{ route('home', ['nuevo' => 1]) }}"><i class="fa-solid fa-star"></i> Nuevas</a>
    </div>
</div>