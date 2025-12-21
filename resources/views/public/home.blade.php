@extends('public.layouts.app')

@section('contenido')

<section class="hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <span class="hero-badge"><i class="fa-solid fa-award"></i> Más de 15 años en el mercado inmobiliario</span>
        <h1>Encontrá la Propiedad de Tus Sueños</h1>
        <p class="hero-subtitle">Asesoramiento profesional y personalizado para comprar, vender o alquilar. Tu confianza es nuestra prioridad.</p>

        <div class="hero-stats">
          <div class="stat-item"><div class="stat-number"><i class="fa-solid fa-building"></i><span>+350</span></div><span class="stat-label">Propiedades Activas</span></div>
          <div class="stat-item"><div class="stat-number"><i class="fa-solid fa-handshake"></i><span>+2.500</span></div><span class="stat-label">Operaciones Cerradas</span></div>
          <div class="stat-item"><div class="stat-number"><i class="fa-solid fa-users"></i><span>98%</span></div><span class="stat-label">Clientes Satisfechos</span></div>
        </div>
    </div>
    <div class="hero-shape">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none"><path d="M0,64 C240,120 480,120 720,96 960,72 1200,40 1440,32 L1440,120 L0,120 Z" fill="#ffffff"/></svg>
    </div>
</section>

<section class="featured-properties" id="propiedades">
  <div class="properties-container">
    
    <div class="properties-header">
      <span class="properties-badge"><i class="fa-solid fa-star"></i> Propiedades Destacadas</span>
      <h2>Descubre Tu Próximo Hogar</h2>
      <p>Nuestra selección de propiedades premium cuidadosamente elegidas para ti.</p>
    </div>

    <div class="properties-filters">
      <button class="filter-btn active">Todas</button>
      <button class="filter-btn">Casas</button>
      <button class="filter-btn">Departamentos</button>
    </div>

    <div class="properties-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 30px;">
      
      @forelse($propiedades as $propiedad)
          <article class="property-card">
            <div class="property-image">
              @if($propiedad->imagen_principal)
                <img src="{{ asset('storage/' . $propiedad->imagen_principal) }}" alt="{{ $propiedad->titulo }}">
              @else
                <img src="{{ asset('img/placeholder-casa.jpg') }}" alt="Sin imagen">
              @endif
              
              <span class="property-badge">{{ ucfirst($propiedad->tipo_operacion) }}</span>
              <button class="property-favorite"><i class="fa-regular fa-heart"></i></button>
            </div>
            
            <div class="property-content">
              <div class="property-location">
                <i class="fa-solid fa-location-dot"></i>
                {{ $propiedad->ciudad }}
              </div>
              
              <h3>{{ $propiedad->titulo }}</h3>
              
              <div class="property-features">
                <div class="property-feature">
                  <i class="fa-solid fa-bed"></i>
                  <span>{{ $propiedad->habitaciones }} hab</span>
                </div>
                <div class="property-feature">
                  <i class="fa-solid fa-bath"></i>
                  <span>{{ $propiedad->banos }} baños</span>
                </div>
                <div class="property-feature">
                  <i class="fa-solid fa-maximize"></i>
                  <span>{{ $propiedad->superficie_total }} m²</span>
                </div>
              </div>
              
              <div class="property-footer">
                <div class="property-price">
                  <span class="property-price-label">Precio</span>
                  <span class="property-price-amount">{{ $propiedad->moneda }} {{ number_format($propiedad->precio, 0, ',', '.') }}</span>
                </div>
                <a href="{{ route('public.propiedad.show', $propiedad->slug) }}" class="property-details-btn">
                  Ver detalles <i class="fa-solid fa-arrow-right"></i>
                </a>
              </div>
            </div>
          </article>
      @empty
          <div style="grid-column: 1 / -1; text-align: center; padding: 40px;">
              <p>No hay propiedades cargadas aún en el sistema.</p>
          </div>
      @endforelse

    </div>

    <div class="properties-cta">
      <a href="#" class="properties-cta-button"><i class="fa-solid fa-grid-2-plus"></i> Ver Todas las Propiedades</a>
    </div>

  </div>
</section>

<section class="services" id="servicios">
  <div class="services-container">
    <div class="services-header">
      <span class="services-badge"><i class="fa-solid fa-sparkles"></i> Nuestros Servicios</span>
      <h2>Soluciones Integrales Para Ti</h2>
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
      <span class="testimonials-badge"><i class="fa-solid fa-star"></i> Testimonios</span>
      <h2>Lo Que Dicen Nuestros Clientes</h2>
    </div>

    <div class="testimonials-grid">
      <div class="testimonial-card">
        <div class="testimonial-quote"><i class="fa-solid fa-quote-right"></i></div>
        <div class="testimonial-content">
          <div class="testimonial-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
          <p class="testimonial-text">"Excelente servicio desde el primer contacto hasta la firma..."</p>
        </div>
        <div class="testimonial-author">
          <div class="testimonial-avatar-placeholder">MR</div>
          <div class="testimonial-info"><div class="testimonial-name">María Rodríguez</div><div class="testimonial-role">Cliente Verificado</div></div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection