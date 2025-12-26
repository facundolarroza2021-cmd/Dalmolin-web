<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>@yield('meta_title', 'Inmobiliaria Dalmolin | Propiedades en Concordia')</title>

  <meta property="og:type" content="website" />
  <meta property="og:title" content="@yield('meta_title', 'Rodrigo Dalmolin Inmobiliaria')" />
  <meta property="og:description" content="@yield('meta_description', 'Tu socio de confianza en bienes raíces en Concordia.')" />
  <meta property="og:image" content="@yield('meta_image', asset('img/dalmolin_logo2.png'))" />
  <meta property="og:url" content="{{ url()->current() }}" />
  <meta property="og:site_name" content="Rodrigo Dalmolin Inmobiliaria" />

  <link href="https://unpkg.com/lucide-static/font/lucide.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
  <link rel="canonical" href="{{ url()->current() }}" />

  <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="shortcut icon" href="{{ asset('img/dalmolin_icon2.png') }}" type="image/x-icon">
</head>
<body>

<nav class="navbar">
  <div class="navbar-container">
    
    <ul class="navbar-menu">
      <!-- DROPDOWN COMPRAR -->
      <li class="dropdown">
        <a href="{{ route('public.listado', ['operacion' => 'venta']) }}" class="dropdown-toggle">
          Comprar
          <i class="fa-solid fa-chevron-down dropdown-icon"></i>
        </a>
        <div class="dropdown-menu">
          <div class="dropdown-content">
            <a href="{{ route('public.listado', ['operacion' => 'venta', 'tipo' => 'casa']) }}" class="dropdown-item">
              <div>
                <span class="dropdown-title">Casas</span>
                <span class="dropdown-desc">Viviendas familiares</span>
              </div>
            </a>
            <a href="{{ route('public.listado', ['operacion' => 'venta', 'tipo' => 'departamento']) }}" class="dropdown-item">
              <div>
                <span class="dropdown-title">Departamentos</span>
                <span class="dropdown-desc">Unidades en edificios</span>
              </div>
            </a>
            <a href="{{ route('public.listado', ['operacion' => 'venta', 'tipo' => 'terreno']) }}" class="dropdown-item">
              <div>
                <span class="dropdown-title">Terrenos</span>
                <span class="dropdown-desc">Lotes para construir</span>
              </div>
            </a>
            <a href="{{ route('public.listado', ['operacion' => 'venta', 'tipo' => 'campo']) }}" class="dropdown-item">
              <div>
                <span class="dropdown-title">Campos</span>
                <span class="dropdown-desc">Propiedades rurales</span>
              </div>
            </a>
            <a href="{{ route('public.listado', ['operacion' => 'venta', 'tipo' => 'local']) }}" class="dropdown-item">
              <div>
                <span class="dropdown-title">Locales Comerciales</span>
                <span class="dropdown-desc">Espacios comerciales</span>
              </div>
            </a>
            <a href="{{ route('public.listado', ['operacion' => 'venta', 'tipo' => 'galpon']) }}" class="dropdown-item">
              <div>
                <span class="dropdown-title">Galpones</span>
                <span class="dropdown-desc">Almacenes industriales</span>
              </div>
            </a>
          </div>
        </div>
      </li>

      <!-- DROPDOWN VENDER -->
      <li class="dropdown">
        <a href="{{ route('public.listado', ['operacion' => 'alquiler']) }}" class="dropdown-toggle">
          Vender
          <i class="fa-solid fa-chevron-down dropdown-icon"></i>
        </a>
        <div class="dropdown-menu">
          <div class="dropdown-content">
            <a href="{{ route('public.listado', ['operacion' => 'venta']) }}" class="dropdown-item">
              <div>
                <span class="dropdown-title">Vender mi Propiedad</span>
                <span class="dropdown-desc">Asesoramiento completo</span>
              </div>
            </a>
            <a href="{{ route('public.listado', ['operacion' => 'venta']) }}#tasar" class="dropdown-item">
              <div>
                <span class="dropdown-title">Tasación Gratuita</span>
                <span class="dropdown-desc">Valuá tu propiedad</span>
              </div>
            </a>
            <a href="#publicar" class="dropdown-item">
              <div>
                <span class="dropdown-title">Plan de Marketing</span>
                <span class="dropdown-desc">Máxima difusión</span>
              </div>
            </a>
          </div>
        </div>
      </li>

      <!-- DROPDOWN ALQUILAR -->
      <li class="dropdown">
        <a href="{{ route('public.listado', ['operacion' => 'alquiler']) }}" class="dropdown-toggle">
          Alquilar
          <i class="fa-solid fa-chevron-down dropdown-icon"></i>
        </a>
        <div class="dropdown-menu">
          <div class="dropdown-content">
            <a href="{{ route('public.listado', ['operacion' => 'alquiler', 'tipo' => 'casa']) }}" class="dropdown-item">
              <div>
                <span class="dropdown-title">Buscar Alquileres</span>
                <span class="dropdown-desc">Propiedades disponibles</span>
              </div>
            </a>
            <a href="{{ route('public.listado', ['operacion' => 'alquiler', 'tipo' => 'departamento']) }}" class="dropdown-item">
              <div>
                <span class="dropdown-title">Departamentos</span>
              </div>
            </a>
            <a href="{{ route('public.listado', ['operacion' => 'alquiler', 'tipo' => 'local']) }}" class="dropdown-item">
              <div>
                <span class="dropdown-title">Locales</span>
                <span class="dropdown-desc">Para tu negocio</span>
              </div>
            </a>
          </div>
        </div>
      </li>
    </ul>

    <a href="{{ route('home') }}" class="navbar-logo">
      <img src="{{ asset('img/dalmolin_logo2.png') }}" alt="Rodrigo Dalmolin">
    </a>

    <ul class="navbar-menu">
      <!-- DROPDOWN SERVICIOS -->
      <li class="dropdown">
        <a href="#" class="dropdown-toggle">
          Servicios
          <i class="fa-solid fa-chevron-down dropdown-icon"></i>
        </a>
        <div class="dropdown-menu">
          <div class="dropdown-content">
            <a href="#tasaciones" class="dropdown-item">
              <div>
                <span class="dropdown-title">Tasaciones</span>
                <span class="dropdown-desc">Valuación profesional</span>
              </div>
            </a>
            <a href="#asesoria" class="dropdown-item">
              <div>
                <span class="dropdown-title">Asesoría Inmobiliaria</span>
                <span class="dropdown-desc">Consultoría especializada</span>
              </div>
            </a>
            <a href="#administracion" class="dropdown-item">
              <div>
                <span class="dropdown-title">Administración</span>
                <span class="dropdown-desc">Gestión de propiedades</span>
              </div>
            </a>
            <a href="#inversiones" class="dropdown-item">
              <div>
                <span class="dropdown-title">Inversiones</span>
                <span class="dropdown-desc">Oportunidades de inversión</span>
              </div>
            </a>
          </div>
        </div>
      </li>

      <li><a href="#nosotros">Nosotros</a></li>
      <li><a href="{{ route('public.contacto') }}">Contacto</a></li>
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
      <span></span>
      <span></span>
      <span></span>
    </button>
  </div>

  <div class="navbar-mobile" id="navbarMobile">
    <a href="{{ route('home') }}">Inicio</a>
    
    <!-- Dropdown móvil Comprar -->
    <div class="mobile-dropdown">
      <button class="mobile-dropdown-toggle">
        Comprar <i class="fa-solid fa-chevron-down"></i>
      </button>
      <div class="mobile-dropdown-content">
        <a href="#casas">🏠 Casas</a>
        <a href="#departamentos">🏢 Departamentos</a>
        <a href="#terrenos">🗺️ Terrenos</a>
        <a href="#campos">🚜 Campos</a>
        <a href="#locales">🏪 Locales</a>
        <a href="#galpones">🏭 Galpones</a>
      </div>
    </div>

    <!-- Dropdown móvil Vender -->
    <div class="mobile-dropdown">
      <button class="mobile-dropdown-toggle">
        Vender <i class="fa-solid fa-chevron-down"></i>
      </button>
      <div class="mobile-dropdown-content">
        <a href="#vender-casa">💰 Vender mi Propiedad</a>
        <a href="#tasar">🔢 Tasación Gratuita</a>
        <a href="#publicar">📢 Plan de Marketing</a>
      </div>
    </div>

    <!-- Dropdown móvil Alquilar -->
    <div class="mobile-dropdown">
      <button class="mobile-dropdown-toggle">
        Alquilar <i class="fa-solid fa-chevron-down"></i>
      </button>
      <div class="mobile-dropdown-content">
        <a href="#alquiler-casas">🔑 Buscar Alquileres</a>
        <a href="#alquilar-propiedad">📋 Alquilar mi Propiedad</a>
        <a href="#garantias">🛡️ Garantías</a>
      </div>
    </div>

    <!-- Dropdown móvil Servicios -->
    <div class="mobile-dropdown">
      <button class="mobile-dropdown-toggle">
        Servicios <i class="fa-solid fa-chevron-down"></i>
      </button>
      <div class="mobile-dropdown-content">
        <a href="#tasaciones">📊 Tasaciones</a>
        <a href="#asesoria">🤝 Asesoría</a>
        <a href="#administracion">🏢 Administración</a>
        <a href="#inversiones">💰 Inversiones</a>
      </div>
    </div>

    <a href="#nosotros">Nosotros</a>
    <a href="#contacto">Contacto</a>
    @auth
    <a href="{{ route('dashboard') }}">Dashboard</a>
    @else
    <a href="{{ route('login') }}">Iniciar Sesión</a>
    @endauth
  </div>
</nav>
<main>
    @yield('contenido')
</main>

<footer class="footer">
  <!-- Contenido principal del footer -->
  <div class="footer-main">
    
    <!-- Columna 1: Marca y redes sociales -->
    <div class="footer-brand">
      <div class="footer-logo">
        <img src="{{ asset('img/dalmolin_logo2.png') }}" alt="Rodrigo Dalmolin">
      </div>
      <p>
        Tu socio de confianza en bienes raíces. Con más de 15 años de experiencia 
        en el mercado inmobiliario, te ayudamos a encontrar la propiedad perfecta 
        para ti y tu familia.
      </p>
      
      <!-- Redes sociales destacadas -->
      <div class="footer-social">
        <a href="https://facebook.com/tu-pagina" target="_blank" class="facebook">
          <i class="fa-brands fa-facebook-f"></i>
        </a>
        <a href="https://instagram.com/tu-perfil" target="_blank" class="instagram">
          <i class="fa-brands fa-instagram"></i>
        </a>
        <a href="https://linkedin.com/company/tu-empresa" target="_blank" class="linkedin">
          <i class="fa-brands fa-linkedin-in"></i>
        </a>
      </div>
    </div>

    <!-- Columna 2: Enlaces rápidos -->
    <div class="footer-column">
      <h4>
        <i class="fa-solid fa-link"></i>
        Enlaces Rápidos
      </h4>
      <ul>
        <li>
          <a href="#inicio">
            <i class="fa-solid fa-chevron-right"></i>
            Inicio
          </a>
        </li>
        <li>
          <a href="#propiedades">
            <i class="fa-solid fa-chevron-right"></i>
            Propiedades
          </a>
        </li>
        <li>
          <a href="#nosotros">
            <i class="fa-solid fa-chevron-right"></i>
            Nosotros
          </a>
        </li>
        <li>
          <a href="#servicios">
            <i class="fa-solid fa-chevron-right"></i>
            Servicios
          </a>
        </li>
        <li>
          <a href="#blog">
            <i class="fa-solid fa-chevron-right"></i>
            Blog
          </a>
        </li>
        <li>
          <a href="#contacto">
            <i class="fa-solid fa-chevron-right"></i>
            Contacto
          </a>
        </li>
      </ul>
    </div>

    <!-- Columna 3: Servicios -->
    <div class="footer-column">
      <h4>
        <i class="fa-solid fa-briefcase"></i>
        Nuestros Servicios
      </h4>
      <ul>
        <li>
          <a href="#compra">
            <i class="fa-solid fa-chevron-right"></i>
            Compra de Propiedades
          </a>
        </li>
        <li>
          <a href="#venta">
            <i class="fa-solid fa-chevron-right"></i>
            Venta de Propiedades
          </a>
        </li>
        <li>
          <a href="#alquiler">
            <i class="fa-solid fa-chevron-right"></i>
            Alquiler
          </a>
        </li>
        <li>
          <a href="#tasacion">
            <i class="fa-solid fa-chevron-right"></i>
            Tasación
          </a>
        </li>
        <li>
          <a href="#asesoria">
            <i class="fa-solid fa-chevron-right"></i>
            Asesoría Inmobiliaria
          </a>
        </li>
        <li>
          <a href="#inversion">
            <i class="fa-solid fa-chevron-right"></i>
            Inversión
          </a>
        </li>
      </ul>
    </div>

    <!-- Columna 4: Contacto y Newsletter -->
    <div class="footer-column">
      <h4>
        <i class="fa-solid fa-address-book"></i>
        Contacto
      </h4>
      
      <div class="footer-contact-item">
        <i class="fa-solid fa-location-dot"></i>
        <span>La Rioja Nº 654<br>Concordia, Entre Ríos</span>
      </div>

      <div class="footer-contact-item">
        <i class="fa-solid fa-phone"></i>
        <a href="tel:+543456256190">+54 345 625 6190</a>
      </div>

      <div class="footer-contact-item">
        <i class="fa-solid fa-envelope"></i>
        <a href="mailto:info@dalmolin.com">dalmolinnegociosinmobiliarios@gmail.com</a>
      </div>

      <div class="footer-contact-item">
        <i class="fa-solid fa-clock"></i>
        <span>Lun - Vie: 9:00 - 18:00<br>Sáb: 10:00 - 14:00</span>
      </div>


    </div>

  </div>

  <!-- Footer Bottom -->
  <div class="footer-bottom">
    <p>© 2025 Rodrigo Dalmolin Inmobiliaria. Todos los derechos reservados.</p>
    <div class="footer-bottom-links">
      <a href="#privacidad">Política de Privacidad</a>
      <a href="#terminos">Términos y Condiciones</a>
      <a href="#cookies">Cookies</a>
    </div>
  </div>
</footer>

  
<script src="{{ asset('js/web.js') }}"></script> 
<script src="https://cdn.lordicon.com/lordicon.js"></script>
</body>
</html>