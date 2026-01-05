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

  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="@yield('meta_title', 'Inmobiliaria Dalmolin')">
  <meta name="twitter:description" content="@yield('meta_description', 'Tu socio de confianza en bienes raíces en Concordia.')">
  <meta name="twitter:image" content="@yield('meta_image', asset('img/dalmolin_logo2.png'))">

  @if(request()->has('search') || request()->has('orden') || request()->has('precio_min'))
      <meta name="robots" content="noindex, follow">
  @else
      <meta name="robots" content="index, follow">
  @endif

  <link href="https://unpkg.com/lucide-static/font/lucide.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
  <link rel="canonical" href="{{ url()->current() }}" />

  <meta name="theme-color" content="#1f2937">

  <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="shortcut icon" href="{{ asset('img/dalmolin_icon2.png') }}" type="image/x-icon">

    <style>
    /* TOPBAR ROJO */
    .topbar {
      background: #dc2626;
      color: white;
      padding: 10px 0;
      font-size: 15px;
    }
    .topbar-container {
      max-width: 1400px;
      margin: 0 auto;
      padding: 0 20px;
    }
    .topbar-content {
      display: flex;
      justify-content: flex-end;
      align-items: center;
      gap: 25px;
      flex-wrap: wrap;
    }
    .topbar-item {
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .topbar-link {
      color: white;
      text-decoration: none;
      transition: opacity 0.3s;
    }
    .topbar-separator {
      width: 1px;
      height: 14px;
      background: rgba(255, 255, 255, 0.4);
    }

    /* NAVBAR PRINCIPAL */
    .navbar {
      background: white;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
      position: sticky;
      top: 0;
      z-index: 1000;
      height: 85px;
    }
    .navbar-container {
      max-width: 1400px;
      margin: 0 auto;
      padding: 0 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 100%;
    }

    /* LOGO IZQUIERDA */
    .navbar-logo {
      display: flex;
      align-items: center;
      text-decoration: none;
    }
    .navbar-logo img {
      height: 55px;
      width: auto;
      transition: transform 0.3s;
    }

    /* ZONA DERECHA (MENÚ + ICONOS) */
    .navbar-right {
      display: flex;
      align-items: center;
      gap: 30px;
    }

    .navbar-menu {
      display: flex;
      list-style: none;
      gap: 25px;
      align-items: center;
      margin: 0;
      padding: 0;
    }
    .navbar-menu > li > a {
      color: #374151;
      text-decoration: none;
      font-weight: 600;
      font-size: 15px;
      transition: color 0.3s;
      display: flex;
      align-items: center;
      gap: 4px;
    }

    /* DROPDOWNS */
    .dropdown { position: relative; }
    .dropdown-toggle { cursor: pointer; }
    .dropdown-icon { font-size: 10px; transition: transform 0.3s; color: #9ca3af; }
    .dropdown:hover .dropdown-icon { transform: rotate(180deg); color: #dc2626; }
    
    .dropdown-menu {
      position: absolute;
      top: 100%;
      left: 50%;
      transform: translateX(-50%);
      background: white;
      border-radius: 12px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
      border: 1px solid #f3f4f6;
      opacity: 0;
      visibility: hidden;
      transition: all 0.2s ease-in-out;
      margin-top: 20px;
      min-width: 260px;
      padding: 8px;
    }
    .dropdown:hover .dropdown-menu {
      opacity: 1;
      visibility: visible;
      margin-top: 15px;
    }
    .dropdown-item {
      padding: 10px 14px;
      border-radius: 8px;
      text-decoration: none;
      display: block;
      transition: background 0.2s;
    }
    .dropdown-item:hover { background: #fef2f2; }
    .dropdown-title { font-weight: 700; font-size: 14px; color: #1f2937; display: block; }
    .dropdown-item:hover .dropdown-title { color: #dc2626; }
    .dropdown-desc { font-size: 12px; color: #6b7280; display: block; margin-top: 2px; }

    /* BOTÓN VER MAPA DESTACADO */
    .btn-mapa {
      background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
      color: white !important;
      padding: 10px 20px;
      border-radius: 50px;
      font-weight: 600;
      box-shadow: 0 4px 10px rgba(220, 38, 38, 0.25);
      transition: all 0.3s;
    }


    /* ICONOS SOCIALES */
    .navbar-icons {
      display: flex;
      gap: 12px;
      align-items: center;
      padding-left: 20px;
      border-left: 1px solid #e5e7eb;
    }
    .navbar-social, .navbar-user {
      width: 36px;
      height: 36px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      text-decoration: none;
      transition: all 0.3s;
      background: #f9fafb;
      color: #4b5563;
    }
    .navbar-social:hover { transform: translateY(-2px); }
    .navbar-social.facebook:hover { background: #1877f2; color: white; }
    .navbar-social.instagram:hover { background: #E1306C; color: white; }
    .navbar-user:hover { background: #1f2937; color: white; }

    /* BOTÓN HAMBURGUESA */
    .navbar-toggle {
      display: none;
      background: none;
      border: none;
      cursor: pointer;
      flex-direction: column;
      gap: 5px;
      padding: 8px;
      z-index: 1001;
    }
    .navbar-toggle span {
      width: 24px;
      height: 3px;
      background: #1f2937;
      transition: all 0.3s;
      border-radius: 3px;
    }

    /* MENÚ MÓVIL */
    .navbar-mobile {
      display: none;
      background: white;
      padding: 0;
      border-top: 1px solid #e5e7eb;
      position: absolute;
      width: 100%;
      left: 0;
      top: 100%;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.3s ease-out;
    }
    
    .navbar-mobile.active {
      display: block;
      max-height: 600px;
      padding: 20px;
    }

    .navbar-mobile a {
      display: block;
      padding: 14px 0;
      color: #374151;
      text-decoration: none;
      border-bottom: 1px solid #f3f4f6;
      transition: all 0.2s;
      font-weight: 500;
    }

    .navbar-mobile a:hover {
      color: #dc2626;
      padding-left: 10px;
    }

    .navbar-mobile a:last-child {
      border-bottom: none;
    }

    /* RESPONSIVE */
    @media (max-width: 1100px) {
      .navbar-menu { gap: 15px; }
      .dropdown-desc { display: none; }
    }
    
    @media (max-width: 900px) {
      .navbar {
        height: auto;
        min-height: 70px;
      }
      
      .navbar-container {
        height: 70px;
      }

      .navbar-logo img {
        height: 45px;
      }

      .navbar-menu,
      .navbar-icons {
        display: none;
      }

      .navbar-toggle {
        display: flex;
      }

      .topbar-content {
        justify-content: center;
        gap: 15px;
        font-size: 11px;
      }

      .topbar-item span {
        font-size: 11px;
      }

      .topbar-separator {
        display: none;
      }
    }

    @media (max-width: 600px) {
      .topbar {
        padding: 8px 0;
      }

      .topbar-content {
        gap: 10px;
        font-size: 10px;
      }

      .navbar-logo img {
        height: 40px;
      }
    }
  </style>
</head>
<body>

  {{-- 1. TOPBAR ROJO --}}
  <div class="topbar">
    <div class="topbar-container">
      <div class="topbar-content">
        
        <div class="topbar-item">
          <i class="fa-solid fa-location-dot"></i>
          <span>Concordia, Entre Ríos</span>
        </div>

        <div class="topbar-separator"></div>

        <a href="tel:+543456256190" class="topbar-item topbar-link">
          <i class="fa-solid fa-phone"></i>
          <span>+54 345 625 6190</span>
        </a>

        <div class="topbar-separator"></div>

        <a href="mailto:dalmolinnegociosinmobiliarios@gmail.com" class="topbar-item topbar-link">
          <i class="fa-regular fa-envelope"></i>
          <span>dalmolinnegociosinmobiliarios@gmail.com</span>
        </a>

      </div>
    </div>
  </div>

  {{-- 2. NAVBAR PRINCIPAL --}}
  <nav class="navbar">
    <div class="navbar-container">
      
      {{-- LOGO (IZQUIERDA) --}}
      <a href="{{ route('home') }}" class="navbar-logo">
        <img src="{{ asset('img/dalmolin_logo2.png') }}" alt="Rodrigo Dalmolin Inmobiliaria">
      </a>

      {{-- ZONA DERECHA (MENÚ + ICONOS) --}}
      <div class="navbar-right">
        
        <ul class="navbar-menu">
          
          {{-- COMPRAR --}}
          <li class="dropdown">
            <a href="{{ route('public.listado', ['operacion' => 'venta']) }}" class="dropdown-toggle">
              Comprar <i class="fa-solid fa-chevron-down dropdown-icon"></i>
            </a>
            <div class="dropdown-menu">
              <div class="dropdown-content">
                <a href="{{ route('public.listado', ['operacion' => 'venta', 'tipo' => 'casa']) }}" class="dropdown-item">
                  <span class="dropdown-title">Casas</span>
                  <span class="dropdown-desc">Viviendas familiares</span>
                </a>
                <a href="{{ route('public.listado', ['operacion' => 'venta', 'tipo' => 'departamento']) }}" class="dropdown-item">
                  <span class="dropdown-title">Departamentos</span>
                  <span class="dropdown-desc">Unidades céntricas</span>
                </a>
                <a href="{{ route('public.listado', ['operacion' => 'venta', 'tipo' => 'terreno']) }}" class="dropdown-item">
                  <span class="dropdown-title">Terrenos</span>
                  <span class="dropdown-desc">Lotes para construir</span>
                </a>
                <a href="{{ route('public.listado', ['operacion' => 'venta', 'tipo' => 'campo']) }}" class="dropdown-item">
                  <span class="dropdown-title">Campos</span>
                  <span class="dropdown-desc">Inversión rural</span>
                </a>
              </div>
            </div>
          </li>

          {{-- VENDER --}}
          <li class="dropdown">
            <a href="{{ route('public.listado', ['operacion' => 'venta']) }}" class="dropdown-toggle">
              Vender <i class="fa-solid fa-chevron-down dropdown-icon"></i>
            </a>
            <div class="dropdown-menu">
              <div class="dropdown-content">
                <a href="{{ route('public.listado', ['operacion' => 'venta']) }}" class="dropdown-item">
                  <span class="dropdown-title">Vender mi Propiedad</span>
                </a>
                <a href="{{ route('public.listado') }}#tasar" class="dropdown-item">
                  <span class="dropdown-title">Tasación Gratuita</span>
                  <span class="dropdown-desc">Conoce el valor real</span>
                </a>
              </div>
            </div>
          </li>

          {{-- ALQUILAR --}}
          <li class="dropdown">
            <a href="{{ route('public.listado', ['operacion' => 'alquiler']) }}" class="dropdown-toggle">
              Alquilar <i class="fa-solid fa-chevron-down dropdown-icon"></i>
            </a>
            <div class="dropdown-menu">
              <div class="dropdown-content">
                <a href="{{ route('public.listado', ['operacion' => 'alquiler', 'tipo' => 'casa']) }}" class="dropdown-item">
                  <span class="dropdown-title">Casas</span>
                </a>
                <a href="{{ route('public.listado', ['operacion' => 'alquiler', 'tipo' => 'departamento']) }}" class="dropdown-item">
                  <span class="dropdown-title">Departamentos</span>
                </a>
                <a href="{{ route('public.listado', ['operacion' => 'alquiler', 'tipo' => 'local']) }}" class="dropdown-item">
                  <span class="dropdown-title">Locales</span>
                </a>
              </div>
            </div>
          </li>

          <li><a href="{{ route('public.nosotros') }}">Nosotros</a></li>
          <li><a href="{{ route('public.contacto') }}">Contacto</a></li>

          {{-- BOTÓN DESTACADO VER MAPA --}}
          <li>
            <a href="{{ route('public.mapa') }}" class="btn-mapa">
              <i class="fa-solid fa-map-location-dot"></i> Ver Mapa
            </a>
          </li>

        </ul>

        {{-- ICONOS SOCIALES Y LOGIN --}}
        <div class="navbar-icons">
          <a href="https://www.facebook.com/rd.inmo" target="_blank" class="navbar-social facebook">
            <i class="fa-brands fa-facebook-f"></i>
          </a>
          <a href="https://www.instagram.com/dalmolin_inmobiliaria/?hl=es" target="_blank" class="navbar-social instagram">
            <i class="fa-brands fa-instagram"></i>
          </a>
          
          @auth
            <a href="{{ route('dashboard') }}" class="navbar-user" title="Ir al Panel">
              <i class="fa-solid fa-gear"></i>
            </a>
          @else
            <a href="{{ route('login') }}" class="navbar-user" title="Iniciar Sesión">
              <i class="fa-solid fa-user"></i>
            </a>
          @endauth
        </div>

        {{-- HAMBURGUESA MÓVIL --}}
        <button class="navbar-toggle" id="navbarToggle" aria-label="Toggle menu">
          <span></span>
          <span></span>
          <span></span>
        </button>

      </div>
    </div>

    {{-- MENÚ MÓVIL --}}
    <div class="navbar-mobile" id="navbarMobile">
      <a href="{{ route('home') }}">
        <i class="fa-solid fa-house"></i> Inicio
      </a>
      <a href="{{ route('public.listado', ['operacion' => 'venta']) }}">
        <i class="fa-solid fa-key"></i> Comprar
      </a>
      <a href="{{ route('public.listado', ['operacion' => 'alquiler']) }}">
        <i class="fa-solid fa-file-contract"></i> Alquilar
      </a>
      <a href="{{ route('public.nosotros') }}">
        <i class="fa-solid fa-users"></i> Nosotros
      </a>
      <a href="{{ route('public.contacto') }}">
        <i class="fa-solid fa-envelope"></i> Contacto
      </a>
      <a href="{{ route('public.mapa') }}" style="color: #dc2626; font-weight: 700;">
        <i class="fa-solid fa-map-location-dot"></i> Ver Mapa
      </a>
      @auth
        <a href="{{ route('dashboard') }}" style="background: #f3f4f6; margin-top: 10px; padding: 14px 16px !important; border-radius: 8px; text-align: center;">
          <i class="fa-solid fa-gear"></i> Dashboard
        </a>
      @else
        <a href="{{ route('login') }}" style="background: #f3f4f6; margin-top: 10px; padding: 14px 16px !important; border-radius: 8px; text-align: center;">
          <i class="fa-solid fa-user"></i> Iniciar Sesión
        </a>
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
<div id="quickViewModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    {{-- Fondo oscuro --}}
    <div class="fixed inset-0 bg-gray-900/75 transition-opacity backdrop-blur-sm" onclick="closeQuickView()"></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-4xl h-[85vh] md:h-[600px]">
            
            {{-- Botón Cerrar --}}
            <button onclick="closeQuickView()" class="absolute top-4 right-4 z-50 p-2 bg-white/80 hover:bg-white rounded-full text-gray-500 hover:text-red-500 transition shadow-sm">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>

            {{-- Aquí se cargará el contenido vía AJAX --}}
            <div id="quickViewContent" class="h-full w-full bg-white flex items-center justify-center">
                {{-- Spinner de carga --}}
                <div class="text-blue-600 flex flex-col items-center animate-pulse">
                    <i class="fa-solid fa-circle-notch fa-spin text-4xl mb-3"></i>
                    <span class="font-medium text-sm">Cargando propiedad...</span>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function openQuickView(id) {
        const modal = document.getElementById('quickViewModal');
        const content = document.getElementById('quickViewContent');
        
        // 1. Mostrar modal
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Bloquear scroll del body

        // 2. Limpiar contenido anterior (mostrar spinner)
        content.innerHTML = `
            <div class="h-full w-full flex flex-col items-center justify-center text-gray-400">
                <i class="fa-solid fa-circle-notch fa-spin text-4xl mb-3 text-blue-600"></i>
                <span class="font-medium text-sm">Cargando...</span>
            </div>
        `;

        // 3. Pedir datos al servidor
        fetch(`/propiedad/quick-view/${id}`)
            .then(response => response.text())
            .then(html => {
                content.innerHTML = html;
                
                // 4. Inicializar Swiper (Carrusel) dentro del modal
                new Swiper('.quickview-swiper', {
                    loop: true,
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                });
            })
            .catch(error => {
                console.error('Error:', error);
                content.innerHTML = '<p class="text-center text-red-500 p-10">Error al cargar la propiedad.</p>';
            });
    }

    function closeQuickView() {
        const modal = document.getElementById('quickViewModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto'; // Restaurar scroll
    }

    // Cerrar con tecla ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            closeQuickView();
        }
    });
</script>
<script src="{{ asset('js/web.js') }}"></script> 
<script src="https://cdn.lordicon.com/lordicon.js"></script>
</body>
</html>