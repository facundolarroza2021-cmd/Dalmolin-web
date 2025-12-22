@extends('public.layouts.app')

@section('titulo', $propiedad->titulo)

@section('contenido')

<div class="property-detail-page">
  
  <nav class="breadcrumb">
    <a href="{{ route('home') }}">Inicio</a>
    <i class="fa-solid fa-chevron-right"></i>
    <a href="{{ route('home') }}#propiedades">Propiedades</a>
    <i class="fa-solid fa-chevron-right"></i>
    <span style="text-transform: capitalize">{{ $propiedad->tipo_operacion }}</span>
    <i class="fa-solid fa-chevron-right"></i>
    <span class="current">{{ \Illuminate\Support\Str::limit($propiedad->titulo, 30) }}</span>
  </nav>

  <div class="property-detail-container">
    
    <div class="detail-grid">
      
      <div class="detail-main">
        
        <div class="property-gallery">
          <div class="gallery-main">
            @if($propiedad->imagen_principal)
                <img src="{{ asset('storage/' . $propiedad->imagen_principal) }}" alt="{{ $propiedad->titulo }}" id="mainImage">
            @else
                <img src="{{ asset('img/placeholder.jpg') }}" alt="Sin Imagen" id="mainImage">
            @endif

            <span class="gallery-badge">{{ ucfirst($propiedad->tipo_operacion) }}</span>
            
            <div class="gallery-controls">
              <button class="gallery-btn" onclick="window.open(document.getElementById('mainImage').src, '_blank')">
                <i class="fa-solid fa-expand"></i>
              </button>
            </div>
          </div>

          @if($propiedad->imagenes->count() > 0)
          <div class="gallery-thumbs">
            <div class="thumb active">
              <img src="{{ asset('storage/' . $propiedad->imagen_principal) }}" alt="Portada">
            </div>
            @foreach($propiedad->imagenes as $img)
            <div class="thumb">
              <img src="{{ asset('storage/' . $img->ruta) }}" alt="Foto extra">
            </div>
            @endforeach
          </div>
          @endif
        </div>

        <div class="property-header">
          <div class="property-title-section">
            <div class="property-title">
              <h1>{{ $propiedad->titulo }}</h1>
              <div class="property-location">
                <i class="fa-solid fa-location-dot"></i>
                <span>{{ $propiedad->direccion ? $propiedad->direccion . ', ' : '' }}{{ $propiedad->ciudad }}</span>
              </div>
            </div>
            <div class="property-actions">
              <button class="action-btn" title="Favorito">
                <i class="fa-regular fa-heart"></i>
              </button>
              <button class="action-btn" title="Compartir" onclick="navigator.share({title: '{{ $propiedad->titulo }}', url: window.location.href})">
                <i class="fa-solid fa-share-nodes"></i>
              </button>
            </div>
          </div>

          <div class="property-main-info">
            <div class="property-price">
              <span class="price-label">Precio</span>
              <span class="price-amount">{{ $propiedad->moneda }} {{ number_format($propiedad->precio, 0, ',', '.') }}</span>
            </div>
            <div class="property-features-main">
              <div class="feature-item">
                <div class="feature-icon"><i class="fa-solid fa-bed"></i></div>
                <div class="feature-label">Habitaciones</div>
                <div class="feature-value">{{ $propiedad->habitaciones ?? '-' }}</div>
              </div>
              <div class="feature-item">
                <div class="feature-icon"><i class="fa-solid fa-bath"></i></div>
                <div class="feature-label">Baños</div>
                <div class="feature-value">{{ $propiedad->banos ?? '-' }}</div>
              </div>
              <div class="feature-item">
                <div class="feature-icon"><i class="fa-solid fa-maximize"></i></div>
                <div class="feature-label">Superficie</div>
                <div class="feature-value">{{ $propiedad->superficie_total ?? '-' }} m²</div>
              </div>
              <div class="feature-item">
                <div class="feature-icon"><i class="fa-solid fa-car"></i></div>
                <div class="feature-label">Cocheras</div>
                <div class="feature-value">{{ $propiedad->cocheras ?? '-' }}</div>
              </div>
            </div>
          </div>
        </div>

        <div class="property-description">
          <h2>Descripción de la Propiedad</h2>
          <div style="white-space: pre-line; line-height: 1.6; color: #4b5563;">
            {{ $propiedad->descripcion }}
          </div>
        </div>

        <div class="property-details">
          <h2>Características y Servicios</h2>
          <div class="details-grid">
            <div class="detail-item">
              <div class="detail-icon"><i class="fa-solid fa-layer-group"></i></div>
              <div class="detail-content">
                <div class="detail-label">Tipo</div>
                <div class="detail-value">{{ ucfirst($propiedad->tipo_propiedad) }}</div>
              </div>
            </div>

            <div class="detail-item">
              <div class="detail-icon"><i class="fa-solid fa-house-flag"></i></div>
              <div class="detail-content">
                <div class="detail-label">Estado</div>
                <div class="detail-value">Disponible</div>
              </div>
            </div>
            
            <div class="detail-item">
                <div class="detail-icon"><i class="fa-solid fa-calendar"></i></div>
                <div class="detail-content">
                  <div class="detail-label">Publicado</div>
                  <div class="detail-value">{{ $propiedad->created_at->format('d/m/Y') }}</div>
                </div>
            </div>

            </div>
        </div>

        <div class="property-map">
          <h2>Ubicación Aproximada</h2>
          <div class="map-container" style="display: flex; align-items: center; justify-content: center; background: #f3f4f6; color: #9ca3af;">
            <div style="text-align: center;">
                <i class="fa-solid fa-map-location-dot" style="font-size: 3rem; margin-bottom: 10px;"></i>
                <p>Mapa próximamente</p>
            </div>
          </div>
        </div>

      </div>

      <div class="detail-sidebar">
        
        <div class="contact-card">
          <h3>Contactar al Agente</h3>
          
          <div class="agent-info">
            <div class="agent-avatar">
              <img src="{{ asset('img/dalmolin_logo2.png') }}" alt="Agente" style="object-fit: contain; padding: 5px; background: white;">
            </div>
            <div class="agent-details">
              <h4>Inmobiliaria Dalmolin</h4>
              <p>Agente Autorizado</p>
            </div>
          </div>

          <a href="https://wa.me/5493456256190?text=Hola,%20me%20interesa%20la%20propiedad:%20{{ $propiedad->titulo }}" 
             target="_blank" 
             class="submit-btn btn-conversion-whatsapp" 
             style="display: flex; align-items: center; justify-content: center; gap: 10px; text-decoration: none; margin-bottom: 20px; background-color: #22c55e;">
             <i class="fa-brands fa-whatsapp" style="font-size: 1.2rem;"></i>
             Consultar por WhatsApp
          </a>

          <div class="contact-methods">
            <a href="tel:+543456256190" class="contact-method-btn">
              <i class="fa-solid fa-phone"></i> Llamar
            </a>
            <a href="mailto:info@dalmolin.com" class="contact-method-btn">
              <i class="fa-solid fa-envelope"></i> Email
            </a>
          </div>
        </div>

      </div>

    </div>

  </div>

</div>

@if(isset($sugeridas) && $sugeridas->count() > 0)
    <div class="suggested-section" style="margin-top: 80px; padding-top: 60px; border-top: 1px solid #e5e7eb;">
        
        <div class="properties-container">
            <div class="properties-header" style="text-align: center; margin-bottom: 50px;">
                <h2 style="font-size: 1.8rem; color: #111827; font-weight: 600; margin-bottom: 10px;">Propiedades Similares</h2>
                <p style="color: #6b7280; font-size: 1.1rem; max-width: 600px; margin: 0 auto;">
                    </strong>, creemos que estas opciones te pueden interesar.
                </p>
            </div>

            <div class="properties-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; justify-content: center;">
                
                @foreach($sugeridas as $sugerencia)
                <article class="property-card">
                    
                    <div class="property-image">
                        @if($sugerencia->imagen_principal)
                            <img src="{{ asset('storage/' . $sugerencia->imagen_principal) }}" alt="{{ $sugerencia->titulo }}">
                        @else
                            <img src="{{ asset('img/placeholder-casa.jpg') }}" alt="Sin imagen">
                        @endif
                        
                        <span class="property-badge">{{ ucfirst($sugerencia->tipo_operacion) }}</span>
                        <button class="property-favorite" title="Guardar"><i class="fa-regular fa-heart"></i></button>
                    </div>
                    
                    <div class="property-content">
                        <div class="property-location">
                            <i class="fa-solid fa-location-dot"></i>
                            {{ $sugerencia->ciudad }}
                        </div>
                        
                        <h3>{{ $sugerencia->titulo }}</h3>
                        
                        <div class="property-features">
                            <div class="property-feature">
                                <i class="fa-solid fa-bed"></i>
                                <span>{{ $sugerencia->habitaciones }} hab</span>
                            </div>
                            <div class="property-feature">
                                <i class="fa-solid fa-bath"></i>
                                <span>{{ $sugerencia->banos }} baños</span>
                            </div>
                            <div class="property-feature">
                                <i class="fa-solid fa-maximize"></i>
                                <span>{{ $sugerencia->superficie_total }} m²</span>
                            </div>
                        </div>
                        
                        <div class="property-footer">
                            <div class="property-price">
                                <span class="property-price-label">Precio</span>
                                <span class="property-price-amount">{{ $sugerencia->moneda }} {{ number_format($sugerencia->precio, 0, ',', '.') }}</span>
                            </div>
                            <a href="{{ route('public.propiedad.show', $sugerencia->slug) }}" class="property-details-btn">
                                Ver detalles <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>

                </article>
                @endforeach

            </div>
        </div>

    </div>
    @endif

<script>
  // Galería de imágenes
  const mainImage = document.getElementById('mainImage');
  const thumbs = document.querySelectorAll('.thumb');

  thumbs.forEach(thumb => {
    thumb.addEventListener('click', () => {
      // Remover clase active de todos
      thumbs.forEach(t => t.classList.remove('active'));
      // Agregar al actual
      thumb.classList.add('active');
      // Cambiar imagen principal con efecto suave
      const imgSource = thumb.querySelector('img').src;
      mainImage.style.opacity = '0.5';
      setTimeout(() => {
          mainImage.src = imgSource;
          mainImage.style.opacity = '1';
      }, 150);
    });
  });

  // Favorito (Visual)
  const favoriteBtn = document.querySelector('.action-btn[title="Favorito"]');
  if(favoriteBtn) {
      favoriteBtn.addEventListener('click', () => {
        favoriteBtn.classList.toggle('active');
        const icon = favoriteBtn.querySelector('i');
        icon.classList.toggle('fa-regular');
        icon.classList.toggle('fa-solid');
        icon.style.color = icon.classList.contains('fa-solid') ? '#ef4444' : '';
      });
  }
</script>

@if(isset($schema))
<script type="application/ld+json">
    {!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endif

@endsection