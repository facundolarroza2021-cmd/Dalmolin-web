@extends('public.layouts.app')

@section('contenido')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

{{-- ESTILOS DEL HERO Y LAS NUEVAS TARJETAS --}}
<style>
    :root {
      --dalmolin-red: #c41e3a;
      --dalmolin-red-dark: #9a1829;
    }

    /* --- 1. HERO SPLIT (Mantuvimos tu Hero anterior) --- */
    .hero-split-section {
        background-color: #ffffff;
        position: relative;
        width: 100%;
        height: 90vh;
        min-height: 650px;
        display: flex;
        align-items: center;
        overflow: hidden;
    }
    .hero-swiper { width: 100%; height: 100%; }
    .swiper-slide { background: white; display: flex; align-items: center; justify-content: center; }
    .hero-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        width: 100%;
        max-width: 1280px;
        padding: 0 2rem;
        align-items: center;
        height: 100%;
    }
    .hero-text-col { z-index: 10; text-align: left; }
    .hero-badge-pill {
        display: inline-block; background:rgb(255, 239, 239); color:rgb(235, 37, 37);
        font-weight: 700; font-size: 0.85rem; padding: 8px 16px; border-radius: 50px;
        margin-bottom: 25px; text-transform: uppercase; letter-spacing: 0.5px;
    }
    .hero-title {
        font-size: 3.5rem; font-weight: 800; color: #111827; line-height: 1.1;
        margin-bottom: 25px; opacity: 0; transform: translateY(30px); transition: all 0.8s ease;
    }
    .hero-subtitle {
        font-size: 1.25rem; color: #6b7280; margin-bottom: 40px; line-height: 1.6;
        max-width: 90%; opacity: 0; transform: translateY(30px); transition: all 0.8s ease 0.2s;
    }
    .hero-btn {
        display: inline-flex; align-items: center; gap: 10px; padding: 16px 40px;
        background-color:rgb(235, 37, 37); color: white; font-weight: bold; border-radius: 12px;
        text-decoration: none; transition: all 0.3s;
        box-shadow: 0 10px 20px -5px rgba(235, 37, 37, 0.3); opacity: 0;
        transform: translateY(30px); transition: opacity 0.8s ease 0.4s, transform 0.8s ease 0.4s, background 0.3s, box-shadow 0.3s;
    }
    .hero-btn:hover {
        background-color:rgb(187, 0, 0); box-shadow: 0 15px 25px -5px rgba(235, 37, 37, 0.4); transform: translateY(-2px);
    }
    .hero-img-col { position: relative; height: 80%; display: flex; align-items: center; justify-content: center; }
    .hero-img-wrapper {
        position: relative; width: 100%; height: 550px; border-radius: 30px;
        overflow: hidden; box-shadow: 20px 20px 60px rgba(0,0,0,0.1);
        transform: scale(0.95); opacity: 0; transition: all 1s ease 0.2s;
    }
    .hero-img { width: 100%; height: 100%; object-fit: cover; }
    .swiper-slide-active .hero-title, .swiper-slide-active .hero-subtitle, .swiper-slide-active .hero-btn {
        opacity: 1; transform: translateY(0);
    }
    .swiper-slide-active .hero-img-wrapper { opacity: 1; transform: scale(1); }
    .swiper-pagination-bullet { background: #cbd5e1 !important; width: 12px; height: 12px; opacity: 1; transition: all 0.3s; }
    .swiper-pagination-bullet-active { background:rgb(235, 37, 37) !important; width: 30px; border-radius: 6px; }

    @media (max-width: 1024px) {
        .hero-grid { grid-template-columns: 1fr; text-align: center; gap: 30px; }
        .hero-text-col { order: 2; display: flex; flex-direction: column; align-items: center; }
        .hero-img-col { order: 1; height: auto; }
        .hero-img-wrapper { height: 350px; width: 90%; margin: 0 auto; }
        .hero-title { font-size: 2.5rem; }
    }

    .properties-section {
      background: #f5f5f5;
      padding: 4rem 0;
      display: flex;
      justify-content: center;
      min-height: auto;
    }

    .properties-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
      gap: 2rem;
      /* AQUÍ ESTÁ EL CAMBIO DE ANCHO: */
      max-width: 1100px; 
      width: 100%;
      padding: 0 1rem;
    }

    .property-card {
      background: white;
      border-radius: 4px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
      position: relative;
      display: flex;       /* Agregado para que el footer se alinee */
      flex-direction: column;
    }

    .property-card:hover {
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.02);
      transform: translateY(-4px);
    }

    .property-image {
      position: relative;
      width: 100%;
      height: 240px;
      overflow: hidden;
    }

    .property-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.4s ease;
    }

    .property-card:hover .property-image img {
      transform: scale(1.05);
    }

    /* Badge Operación (Ej: Alquiler / Venta) */
    .property-badge {
      position: absolute;
      top: 12px;
      right: 12px;
      width: 4.5rem;
      background: rgb(215, 1, 1);
      color: white;
      padding: 0.4rem 1rem;
      font-size: 0.85rem;
      font-weight: 600;
      border-radius: 4px;
      text-transform: capitalize;
    }
    .property-badge.vendida { background: rgba(196, 30, 58, 0.9); }

    .property-content {
      padding: 1.5rem;
      text-align: center;
      flex-grow: 1;           /* Para llenar espacio */
      display: flex;          /* Para alinear botón al fondo */
      flex-direction: column;
    }

    .property-location {
      font-size: 1rem;
      color: #666;
      margin-bottom: 0.5rem;
      font-weight: 500;
    }

    .property-type {
      font-size: 0.95rem;
      color: #333;
      margin-bottom: 0.75rem;
      font-weight: 400;
    }

    .property-price {
      font-size: 1.5rem;
      font-weight: 500;
      color: #333;
      margin-bottom: 1.25rem;
    }

    .property-features {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 1.5rem;
      padding: 1rem 0;
      border-top: 1px solid #e0e0e0;
      border-bottom: 1px solid #e0e0e0;
      margin-bottom: 1.25rem;
      margin-top: auto; /* Empuja las caracteristicas hacia abajo */
    }

    .property-feature {
      display: flex;
      align-items: center;
      gap: 0.4rem;
      font-size: 0.9rem;
      color: #666;
    }

    .property-feature i { font-size: 1rem; color: #999; }

    .property-button {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      padding: 0.65rem 2rem;
      background:rgb(232, 0, 0);
      color: white;
      border: none;
      font-size: 0.9rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      border-radius: 4px;
      width: 100%; /* Botón ancho completo */
    }

    .property-button:hover { background: var(--dalmolin-red); }

    .property-id {
      position: absolute;
      bottom: 12px;
      right: 12px;
      background: white;
      color: #666;
      padding: 0.35rem 0.75rem;
      font-size: 0.75rem;
      font-weight: 600;
      border-radius: 4px;
      display: flex;
      align-items: center;
      gap: 0.3rem;
    }
    .property-id i { font-size: 0.7rem; }

    @media (max-width: 768px) {
      .properties-grid { grid-template-columns: 1fr; gap: 1.5rem; }
      .property-image { height: 200px; }
      .property-features { gap: 1rem; }
    }
</style>

{{-- SECCIÓN HERO --}}
<section class="hero-split-section">
    <div class="swiper hero-swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="hero-grid">
                    <div class="hero-text-col">
                        <span class="hero-badge-pill">
                            <i class="fa-solid fa-medal"></i> Líderes en Concordia
                        </span>
                        <h1 class="hero-title">Encontrá el lugar <br><span style="color:rgb(235, 37, 37);">donde querés vivir</span></h1>
                        <p class="hero-subtitle">En Rodrigo Dalmolin Inmobiliaria te acompañamos en cada paso para encontrar tu hogar ideal.</p>
                        <a href="#propiedades" class="hero-btn">Ver Propiedades <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                    <div class="hero-img-col">
                        <div class="hero-img-wrapper">
                            <img src="{{ asset('img/dalmolin-entrada_LE_upscale_balanced.jpg') }}" alt="Inmobiliaria Dalmolin" class="hero-img">
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="hero-grid">
                    <div class="hero-text-col">
                        <span class="hero-badge-pill" style="background:rgb(253, 236, 236); color:rgb(206, 8, 8);">
                            <i class="fa-solid fa-chart-line"></i> Tasaciones Reales
                        </span>
                        <h1 class="hero-title">¿Pensando en <br><span style="color:rgb(206, 8, 8);">Vender tu Propiedad?</span></h1>
                        <p class="hero-subtitle">Utilizamos estrategias de marketing digital avanzado para vender tu propiedad.</p>
                        <a href="#contacto" class="hero-btn" style="background-color:rgb(206, 8, 8);">Solicitar Tasación <i class="fa-solid fa-clipboard-check"></i></a>
                    </div>
                    <div class="hero-img-col">
                        <div class="hero-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?q=80&w=1920&auto=format&fit=crop" alt="Ventas" class="hero-img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</section>


<section class="categories-section">
  <div class="categories-container">
    
    <!-- Header de la sección -->
    <div class="categories-header">
      <h2>Explorá por Tipo de Propiedad</h2>
      <p>Encontrá exactamente lo que estás buscando navegando por nuestras categorías especializadas</p>
    </div>

    <!-- Grid de categorías -->
    <div class="categories-grid">
      
      <!-- Casa -->
      <a href="#casas" class="category-card">
        <img src="https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=800&q=80" alt="Casas">
        <div class="category-overlay"></div>
        <div class="category-content">
          <h3>Casas</h3>
          <span class="category-count">45 propiedades</span>
        </div>
      </a>

      <!-- Departamento -->
      <a href="#departamentos" class="category-card">
        <img src="https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=800&q=80" alt="Departamentos">
        <div class="category-overlay"></div>
        <div class="category-content">
          <h3>Departamentos</h3>
          <span class="category-count">32 propiedades</span>
        </div>
      </a>

      <!-- Quinta -->
      <a href="#quintas" class="category-card">
        <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800&q=80" alt="Quintas">
        <div class="category-overlay"></div>
        <div class="category-content">
          <h3>Quintas</h3>
          <span class="category-count">18 propiedades</span>
        </div>
      </a>

      <!-- Terreno -->
      <a href="#terrenos" class="category-card">
        <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=800&q=80" alt="Terrenos">
        <div class="category-overlay"></div>
        <div class="category-content">
          <h3>Terrenos</h3>
          <span class="category-count">27 propiedades</span>
        </div>
      </a>

      <!-- Campo -->
      <a href="#campos" class="category-card">
        <img src="https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=800&q=80" alt="Campos">
        <div class="category-overlay"></div>
        <div class="category-content">
          <h3>Campos</h3>
          <span class="category-count">12 propiedades</span>
        </div>
      </a>

      <!-- Cochera -->
      <a href="#cocheras" class="category-card">
        <img src="https://images.unsplash.com/photo-1590674899484-d5640e854abe?w=800&q=80" alt="Cocheras">
        <div class="category-overlay"></div>
        <div class="category-content">
          <h3>Cocheras</h3>
          <span class="category-count">23 propiedades</span>
        </div>
      </a>

      <!-- Fondo de Comercio -->
      <a href="#fondos-comercio" class="category-card">
        <img src="https://images.unsplash.com/photo-1556761175-b413da4baf72?w=800&q=80" alt="Fondos de Comercio">
        <div class="category-overlay"></div>
        <div class="category-content">
          <h3>Fondos de Comercio</h3>
          <span class="category-count">9 propiedades</span>
        </div>
      </a>

      <!-- Galpón -->
      <a href="#galpones" class="category-card">
        <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=800&q=80" alt="Galpones">
        <div class="category-overlay"></div>
        <div class="category-content">
          <h3>Galpones</h3>
          <span class="category-count">14 propiedades</span>
        </div>
      </a>

      <!-- Local -->
      <a href="#locales" class="category-card">
        <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=800&q=80" alt="Locales">
        <div class="category-overlay"></div>
        <div class="category-content">
          <h3>Locales</h3>
          <span class="category-count">19 propiedades</span>
        </div>
      </a>

      <!-- Edificio -->
      <a href="#edificios" class="category-card">
        <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=800&q=80" alt="Edificios">
        <div class="category-overlay"></div>
        <div class="category-content">
          <h3>Edificios</h3>
          <span class="category-count">7 propiedades</span>
        </div>
      </a>

      <!-- Hotel -->
      <a href="#hoteles" class="category-card">
        <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&q=80" alt="Hoteles">
        <div class="category-overlay"></div>
        <div class="category-content">
          <h3>Hoteles</h3>
          <span class="category-count">3 propiedades</span>
        </div>
      </a>

    </div>

  </div>
</section>

{{-- SECCIÓN PROPIEDADES (NUEVO DISEÑO) --}}
<section class="properties-section" id="propiedades">
    <div class="properties-grid">
      
      @forelse($propiedades as $propiedad)
        <article class="property-card">
          <div class="property-image">
            <a href="{{ route('public.propiedad.show', $propiedad->slug) }}">
                @if($propiedad->imagen_principal)
                    <img src="{{ asset('storage/' . $propiedad->imagen_principal) }}" alt="{{ $propiedad->titulo }}">
                @else
                    <img src="{{ asset('img/placeholder-casa.jpg') }}" alt="Sin imagen">
                @endif
            </a>
            
            <div class="property-badge {{ strtolower($propiedad->tipo_operacion) }}">
                {{ $propiedad->tipo_operacion }}
            </div>
            
          </div>
          
          <div class="property-content">
            <div class="property-location">
                {{ Str::limit($propiedad->titulo, 40) }}
            </div>
            

            
            <div class="property-price">
                {{ $propiedad->moneda }} {{ number_format($propiedad->precio, 0, ',', '.') }}
            </div>
            
            <div class="property-features">
              <div class="property-feature">
                <i class="fa-solid fa-expand-arrows-alt"></i>
                <span>{{ $propiedad->superficie_total }} m²</span>
              </div>
              <div class="property-feature">
                <i class="fa-solid fa-bed"></i>
                <span>{{ $propiedad->habitaciones }} hab.</span>
              </div>
            </div>
            
            <a href="{{ route('public.propiedad.show', $propiedad->slug) }}" class="property-button">
              Ver propiedad
              <i class="fa-solid fa-arrow-right"></i>
            </a>
          </div>
        </article>
      @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 40px; background:white; border-radius:8px;">
            <p>No hay propiedades cargadas aún en el sistema.</p>
        </div>
      @endforelse

    </div>
</section>

{{-- SECCIÓN SERVICIOS Y TESTIMONIOS (Mantenido igual) --}}
<section class="services" id="servicios">
  <div class="services-container">
    <div class="services-header">
      <h2>Nuestros Servicios</h2>
      <p>Ofrecemos un servicio completo y personalizado para todas tus necesidades inmobiliarias.</p>
    </div>

    <div class="services-grid">
      <div class="service-card">
        <span class="service-number">01</span>
        <span class="service-badge">Popular</span>
        <div class="service-icon-wrapper"><div class="service-icon-bg"></div><div class="service-icon"><i class="fa-solid fa-house-circle-check"></i></div></div>
        <h3>Compra y Venta</h3>
        <p>Te acompañamos en todo el proceso de compra o venta de tu propiedad.</p>
        <a href="#" class="service-link">Ver más <i class="fa-solid fa-arrow-right"></i></a>
      </div>
      
      <div class="service-card">
          <span class="service-number">02</span>
          <div class="service-icon-wrapper"><div class="service-icon-bg"></div><div class="service-icon"><i class="fa-solid fa-chart-line"></i></div></div>
          <h3>Tasaciones</h3>
          <p>Valuaciones precisas y actualizadas de tu propiedad.</p>
          <a href="#" class="service-link">Ver más <i class="fa-solid fa-arrow-right"></i></a>
      </div>
    </div>
  </div>
  
</section>

<section class="testimonials" id="nosotros">
  <div class="testimonials-container">
    
    <div class="testimonials-header">
      <h2>Lo Que Dicen Nuestros Clientes</h2>
    </div>

    <div class="testimonials-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; max-width: 1200px; margin: 0 auto;">
      
      <div class="testimonial-card">
        <div class="testimonial-quote"><i class="fa-solid fa-quote-right"></i></div>
        <div class="testimonial-content">
          <div class="testimonial-stars" style="color: #fbbf24; margin-bottom: 10px;">
            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
          </div>
          <p class="testimonial-text">"Excelente servicio desde el primer contacto hasta la firma. Me ayudaron a encontrar la casa ideal para mi familia en tiempo récord."</p>
        </div>
        <div class="testimonial-author">
          <div class="testimonial-avatar-placeholder" style="background: #e0e7ff; color: #3730a3;">MR</div>
          <div class="testimonial-info">
            <div class="testimonial-name">María Rodríguez</div>
            <div class="testimonial-role">Compró su Casa</div>
          </div>
        </div>
      </div>

      <div class="testimonial-card">
        <div class="testimonial-quote"><i class="fa-solid fa-quote-right"></i></div>
        <div class="testimonial-content">
          <div class="testimonial-stars" style="color: #fbbf24; margin-bottom: 10px;">
            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
          </div>
          <p class="testimonial-text">"Vendieron mi departamento mucho más rápido de lo que esperaba. La gestión de los papeles fue impecable y muy transparente."</p>
        </div>
        <div class="testimonial-author">
          <div class="testimonial-avatar-placeholder" style="background: #dcfce7; color: #166534;">JG</div>
          <div class="testimonial-info">
            <div class="testimonial-name">Juan Gómez</div>
            <div class="testimonial-role">Vendió su Depto</div>
          </div>
        </div>
      </div>

      <div class="testimonial-card">
        <div class="testimonial-quote"><i class="fa-solid fa-quote-right"></i></div>
        <div class="testimonial-content">
          <div class="testimonial-stars" style="color: #fbbf24; margin-bottom: 10px;">
            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
          </div>
          <p class="testimonial-text">"Gracias al asesoramiento del equipo pude invertir en un terreno con gran potencial. Su conocimiento del mercado es clave."</p>
        </div>
        <div class="testimonial-author">
          <div class="testimonial-avatar-placeholder" style="background: #fee2e2; color: #991b1b;">CR</div>
          <div class="testimonial-info">
            <div class="testimonial-name">Carlos Ruiz</div>
            <div class="testimonial-role">Inversionista</div>
          </div>
        </div>
      </div>
      
    </div>

  </div>
</section>

<div class="whatsapp-float">
  <a href="https://wa.me/5493454123456?text=Hola,%20estoy%20interesado%20en%20una%20propiedad" 
     target="_blank" 
     class="whatsapp-button"
     aria-label="Contactar por WhatsApp">
    <i class="fa-brands fa-whatsapp"></i>
    <span class="whatsapp-tooltip">¡Chateá con nosotros!</span>
  </a>
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper(".hero-swiper", {
        spaceBetween: 30,
        effect: "fade",
        fadeEffect: { crossFade: true },
        speed: 1000,
        loop: true,
        autoplay: { delay: 5000, disableOnInteraction: false },
        pagination: { el: ".swiper-pagination", clickable: true },
    });
</script>

@endsection