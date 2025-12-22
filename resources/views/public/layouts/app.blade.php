<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Rodrigo Dalmolin Inmobiliaria</title>

  <link href="https://unpkg.com/lucide-static/font/lucide.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

  <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
  <link rel="shortcut icon" href="{{ asset('img/dalmolin_icon2.png') }}" type="image/x-icon">
</head>
<body>

<nav class="navbar">
  <div class="navbar-container">
    
    <ul class="navbar-menu">
      <li><a href="{{ route('home') }}">Comprar</a></li>
      <li><a href="#">Vender</a></li>
    </ul>

    <a href="{{ route('home') }}" class="navbar-logo">
      <img src="{{ asset('img/dalmolin_logo2.png') }}" alt="Rodrigo Dalmolin">
    </a>

    <ul class="navbar-menu">
      <li><a href="#nosotros">Tasar</a></li>
      <li><a href="#contacto">Contacto</a></li>
    </ul>

    <div class="navbar-icons">
      <a href="https://www.facebook.com/rd.inmo" target="_blank" class="navbar-social facebook"><i class="fa-brands fa-facebook-f"></i></a>
      <a href="https://www.instagram.com/dalmolin_inmobiliaria/?hl=es" target="_blank" class="navbar-social instagram"><i class="fa-brands fa-instagram"></i></a>
      
      @auth
      <a href="{{ route('dashboard') }}" class="navbar-user"><i class="fa-solid fa-gear"></i></a>
      @else
      <a href="{{ route('login') }}" class="navbar-user"><i class="fa-solid fa-user"></i></a>
      @endauth
    </div>

    <button class="navbar-toggle" id="navbarToggle">
      <i class="lucide lucide-menu"></i>
    </button>
  </div>

  <div class="navbar-mobile" id="navbarMobile">
    <a href="{{ route('home') }}">Inicio</a>
    <a href="#nosotros">Nosotros</a>
    <a href="#contacto">Contacto</a>
  </div>
</nav>

<div class="mini-navbar">
  <div class="mini-navbar-container">
    <a href="#casas"><i class="fa-solid fa-house"></i> Casas</a>
    <a href="#departamentos"><i class="fa-solid fa-building"></i> Departamentos</a>
    <a href="#terrenos"><i class="fa-solid fa-map"></i> Terrenos</a>
    <a href="#locales"><i class="fa-solid fa-store"></i> Locales Comerciales</a>
    <a href="#oficinas"><i class="fa-solid fa-briefcase"></i> Oficinas</a>
    <a href="#nuevo"><i class="fa-solid fa-star"></i> Nosotros</a>
  </div>
</div>

<main>
    @yield('contenido')
</main>

<footer class="footer">
  <div class="footer-main">
    <div class="footer-brand">
      <div class="footer-logo">
        <img src="{{ asset('img/dalmolin_logo2.png') }}" alt="Rodrigo Dalmolin">
      </div>
      <p>Tu socio de confianza en bienes raíces. Con más de 15 años de experiencia.</p>
      <div class="footer-social">
        <a href="#" class="facebook"><i class="fa-brands fa-facebook-f"></i></a>
        <a href="#" class="instagram"><i class="fa-brands fa-instagram"></i></a>
        </div>
    </div>
    
    <div class="footer-column">
        <h4>Contacto</h4>
        <div class="footer-contact-item"><i class="fa-solid fa-location-dot"></i> <span>La Rioja Nº 654<br>Concordia, Entre Ríos</span></div>
        <div class="footer-contact-item"><i class="fa-solid fa-phone"></i> <a href="tel:+543456256190">+54 345 625 6190</a></div>
    </div>
  </div>

  <div class="footer-bottom">
    <p>© 2025 Rodrigo Dalmolin Inmobiliaria. Todos los derechos reservados.</p>
  </div>
</footer>

  
<script src="{{ asset('js/web.js') }}"></script> 
<script src="https://cdn.lordicon.com/lordicon.js"></script>
</body>
</html>