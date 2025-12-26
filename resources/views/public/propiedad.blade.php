@extends('public.layouts.app')

@section('meta_title', $propiedad->titulo . ' en ' . $propiedad->ciudad . ' | Dalmolin Inmobiliaria')

@section('meta_description', 'Propiedad en ' . $propiedad->ciudad . '. ' . $propiedad->habitaciones . ' habitaciones, ' . $propiedad->banos . ' baños. Precio: ' . $propiedad->moneda . ' ' . number_format($propiedad->precio, 0, ',', '.'))

@section('meta_image', asset('storage/' . $propiedad->imagen_principal))

@section('contenido')

<div class="property-detail-page">
  
  <!-- Breadcrumb -->
  <nav class="breadcrumb-nav">
    <div class="container-breadcrumb">
      <a href="{{ route('home') }}">Inicio</a>
      <i class="fa-solid fa-chevron-right"></i>
      <a href="{{ route('home') }}#propiedades">Propiedades</a>
      <i class="fa-solid fa-chevron-right"></i>
      <span style="text-transform: capitalize">{{ $propiedad->tipo_operacion }}</span>
      <i class="fa-solid fa-chevron-right"></i>
      <span class="current">{{ \Illuminate\Support\Str::limit($propiedad->titulo, 30) }}</span>
    </div>
  </nav>

  <div class="property-container">
    
    <!-- GALERÍA DE IMÁGENES -->
    <div class="property-gallery-section">
      <div class="gallery-main-image">
        @if($propiedad->imagen_principal)
            <img src="{{ asset('storage/' . $propiedad->imagen_principal) }}" alt="Foto de {{ $propiedad->titulo }} en {{ $propiedad->ciudad }} - Vista {{ $loop->iteration ?? 'principal' }}" id="mainImage">
        @else
            <img src="{{ asset('img/placeholder.jpg') }}" alt="Sin Imagen" id="mainImage">
        @endif

        
        <button class="btn-fullscreen" onclick="openLightbox()">
          <i class="fa-solid fa-expand"></i>
        </button>
      </div>

      <!-- Solo 2 miniaturas a la derecha -->
      @if($propiedad->imagenes->count() > 0)
      <div class="gallery-thumbnails">
        @foreach($propiedad->imagenes->take(2) as $index => $img)
        <div class="thumb-image">
          <img src="{{ asset('storage/' . $img->ruta) }}" alt="Foto de {{ $propiedad->titulo }} en {{ $propiedad->ciudad }} - Vista {{ $index + 1 }}">
          @if($index == 1 && $propiedad->imagenes->count() > 2)
          <div class="counter-overlay" onclick="openLightbox()">+{{ $propiedad->imagenes->count() - 2 }}</div>
          @endif
        </div>
        @endforeach
      </div>
      @endif
    </div>

    <!-- Lightbox Modal -->
    <div id="lightboxModal" class="lightbox-modal">
      <div class="lightbox-content">
        <button class="lightbox-close" onclick="closeLightbox()">
          <i class="fa-solid fa-times"></i>
        </button>
        <button class="lightbox-prev" onclick="changeLightboxImage(-1)">
          <i class="fa-solid fa-chevron-left"></i>
        </button>
        <button class="lightbox-next" onclick="changeLightboxImage(1)">
          <i class="fa-solid fa-chevron-right"></i>
        </button>
        <img id="lightboxImage" src="" alt="Vista completa">
        <div class="lightbox-counter">
          <span id="lightboxCounter">1 / 1</span>
        </div>
      </div>
    </div>

    <!-- INFORMACIÓN BÁSICA -->
    <div class="property-header-section">
      <div class="header-top">
        <div class="header-left">
          <div class="property-location">
            <i class="fa-solid fa-location-dot"></i>
            <span>{{ $propiedad->ciudad }}</span>
          </div>
          
          <h1 class="property-title">{{ $propiedad->titulo }}</h1>
          
          @if($propiedad->direccion)
          <p class="property-address">
            <i class="fa-solid fa-map-marker-alt"></i>
            {{ $propiedad->direccion }}
          </p>
          @endif
        </div>

        <div class="header-right">
          <div class="price-box">
            <span class="price-label">Precio</span>
            <span class="price-amount">{{ $propiedad->moneda }} {{ number_format($propiedad->precio, 0, ',', '.') }}</span>
          </div>
        </div>
      </div>

      <!-- Características principales -->
      <div class="features-section">
        <div class="feature-item">
          <i class="fa-solid fa-ruler-combined"></i>
          <div class="feature-text">
            <span class="feature-label">Superficie</span>
            <span class="feature-value">{{ $propiedad->superficie_total ?? '-' }} m²</span>
          </div>
        </div>

        <div class="feature-item">
          <i class="fa-solid fa-bed"></i>
          <div class="feature-text">
            <span class="feature-label">Habitaciones</span>
            <span class="feature-value">{{ $propiedad->habitaciones ?? '-' }}</span>
          </div>
        </div>

        <div class="feature-item">
          <i class="fa-solid fa-bath"></i>
          <div class="feature-text">
            <span class="feature-label">Baños</span>
            <span class="feature-value">{{ $propiedad->banos ?? '-' }}</span>
          </div>
        </div>

        <div class="feature-item">
          <i class="fa-solid fa-car"></i>
          <div class="feature-text">
            <span class="feature-label">Cocheras</span>
            <span class="feature-value">{{ $propiedad->cocheras ?? '-' }}</span>
          </div>
        </div>
      </div>

      <!-- Botones de acción -->
      <div class="action-buttons-group">
        <button class="btn-action" onclick="navigator.share({title: '{{ $propiedad->titulo }}', url: window.location.href})">
          <i class="fa-solid fa-share-nodes"></i>
          <span>Compartir</span>
        </button>
        <button class="btn-action btn-favorite">
          <i class="fa-regular fa-heart"></i>
          <span>Guardar</span>
        </button>
        <button class="btn-action" onclick="window.print()">
          <i class="fa-solid fa-print"></i>
          <span>Imprimir</span>
        </button>
        <a href="https://wa.me/5493456256190?text=Hola,%20me%20interesa%20la%20propiedad:%20{{ urlencode($propiedad->titulo) }}" 
           target="_blank" 
           class="btn-action btn-whatsapp">
          <i class="fa-brands fa-whatsapp"></i>
          <span>Consultar</span>
        </a>
      </div>
    </div>

    <!-- DESCRIPCIÓN -->
    <div class="content-section">
      <h2 class="section-heading">Descripción</h2>
      <div class="section-body">
        <p class="description-text">{{ $propiedad->descripcion }}</p>
      </div>
    </div>

    <!-- CARACTERÍSTICAS DETALLADAS -->
    <div class="content-section">
      <h2 class="section-heading">Características</h2>
      <div class="characteristics-grid">
        <div class="char-item">
          <span class="char-name">Tipo de propiedad</span>
          <span class="char-value">{{ ucfirst($propiedad->tipo_propiedad) }}</span>
        </div>
        <div class="char-item">
          <span class="char-name">Estado</span>
          <span class="char-value">Disponible</span>
        </div>
        <div class="char-item">
          <span class="char-name">Publicado</span>
          <span class="char-value">{{ $propiedad->created_at->format('d/m/Y') }}</span>
        </div>
        @if($propiedad->superficie_terreno)
        <div class="char-item">
          <span class="char-name">Superficie de terreno</span>
          <span class="char-value">{{ $propiedad->superficie_terreno }} m²</span>
        </div>
        @endif
        @if($propiedad->superficie_total)
        <div class="char-item">
          <span class="char-name">Superficie total</span>
          <span class="char-value">{{ $propiedad->superficie_total }} m²</span>
        </div>
        @endif
        @if($propiedad->habitaciones)
        <div class="char-item">
          <span class="char-name">Habitaciones</span>
          <span class="char-value">{{ $propiedad->habitaciones }}</span>
        </div>
        @endif
        @if($propiedad->banos)
        <div class="char-item">
          <span class="char-name">Baños</span>
          <span class="char-value">{{ $propiedad->banos }}</span>
        </div>
        @endif
        @if($propiedad->cocheras)
        <div class="char-item">
          <span class="char-name">Cocheras</span>
          <span class="char-value">{{ $propiedad->cocheras }}</span>
        </div>
        @endif
      </div>
    </div>

    <!-- UBICACIÓN -->
    <div class="content-section">
      <h2 class="section-heading">Ubicación</h2>
      <div class="map-container">
        <div class="map-placeholder">
          <i class="fa-solid fa-map-location-dot"></i>
          <p>{{ $propiedad->ciudad }}</p>
          <span>Mapa próximamente</span>
        </div>
      </div>
    </div>

  </div>

</div>

<!-- PROPIEDADES SIMILARES -->
@if(isset($sugeridas) && $sugeridas->count() > 0)
<div class="similar-properties">
  <div class="similar-container">
    <div class="similar-header">
      <h2>Propiedades Similares</h2>
      <p>Otras opciones que podrían interesarte</p>
    </div>

    <div class="properties-grid">
      @foreach($sugeridas as $sugerencia)
      <article class="property-card">
        <div class="card-image">
          <a href="{{ route('public.propiedad.show', $sugerencia->slug) }}">
            @if($sugerencia->imagen_principal)
                <img src="{{ asset('storage/' . $sugerencia->imagen_principal) }}" alt="{{ $sugerencia->titulo }}">
            @else
                <img src="{{ asset('img/placeholder-casa.jpg') }}" alt="Sin imagen">
            @endif
          </a>
          <div class="card-badge">{{ ucfirst($sugerencia->tipo_operacion) }}</div>
          <button class="card-favorite"><i class="fa-regular fa-heart"></i></button>
        </div>
        
        <div class="card-content">
          <div class="card-location">
            <i class="fa-solid fa-location-dot"></i>
            <span>{{ $sugerencia->ciudad }}</span>
          </div>
          <h3 class="card-title">{{ Str::limit($sugerencia->titulo, 45) }}</h3>
          
          <div class="card-features">
            <div class="card-feature">
              <i class="fa-solid fa-ruler-combined"></i>
              <span>{{ $sugerencia->superficie_total }} m²</span>
            </div>
            <div class="card-feature">
              <i class="fa-solid fa-bed"></i>
              <span>{{ $sugerencia->habitaciones }}</span>
            </div>
            <div class="card-feature">
              <i class="fa-solid fa-bath"></i>
              <span>{{ $sugerencia->banos }}</span>
            </div>
          </div>
          
          <div class="card-divider"></div>
          
          <div class="card-footer">
            <div class="card-price">
              <span class="price-tag">Precio</span>
              <span class="price-text">{{ $sugerencia->moneda }} {{ number_format($sugerencia->precio, 0, ',', '.') }}</span>
            </div>
            <a href="{{ route('public.propiedad.show', $sugerencia->slug) }}" class="btn-card">
              Ver más <i class="fa-solid fa-arrow-right"></i>
            </a>
          </div>
        </div>
      </article>
      @endforeach
    </div>
  </div>
</div>
@endif

<!-- JAVASCRIPT -->

<script>
const lightboxImages = [
  @if($propiedad->imagen_principal)
  "{{ asset('storage/' . $propiedad->imagen_principal) }}",
  @endif
  @foreach($propiedad->imagenes as $img)
  "{{ asset('storage/' . $img->ruta) }}",
  @endforeach
];

let currentLightboxIndex = 0;

// Generar miniaturas del lightbox
function generateLightboxThumbnails() {
  const container = document.querySelector('.lightbox-content');
  if (!container) return;
  
  // Verificar si ya existe el contenedor de miniaturas
  let thumbsContainer = document.getElementById('lightboxThumbnails');
  if (!thumbsContainer) {
    thumbsContainer = document.createElement('div');
    thumbsContainer.id = 'lightboxThumbnails';
    thumbsContainer.className = 'lightbox-thumbnails';
    container.appendChild(thumbsContainer);
  }
  
  thumbsContainer.innerHTML = '';
  
  lightboxImages.forEach((imgSrc, index) => {
    const thumbDiv = document.createElement('div');
    thumbDiv.className = 'lightbox-thumb';
    if (index === currentLightboxIndex) {
      thumbDiv.classList.add('active');
    }
    
    const thumbImg = document.createElement('img');
    thumbImg.src = imgSrc;
    thumbImg.alt = `Imagen ${index + 1}`;
    
    thumbDiv.appendChild(thumbImg);
    thumbDiv.addEventListener('click', () => {
      currentLightboxIndex = index;
      updateLightboxImage();
    });
    
    thumbsContainer.appendChild(thumbDiv);
  });
}

// Abrir lightbox
function openLightbox(index = 0) {
  currentLightboxIndex = index;
  const modal = document.getElementById('lightboxModal');
  
  if (modal) {
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    updateLightboxImage();
    generateLightboxThumbnails();
  }
}

// Cerrar lightbox
function closeLightbox() {
  const modal = document.getElementById('lightboxModal');
  if (modal) {
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
  }
}

// Cambiar imagen en lightbox
function changeLightboxImage(direction) {
  currentLightboxIndex += direction;
  
  if (currentLightboxIndex < 0) {
    currentLightboxIndex = lightboxImages.length - 1;
  } else if (currentLightboxIndex >= lightboxImages.length) {
    currentLightboxIndex = 0;
  }
  
  updateLightboxImage();
}

// Actualizar imagen del lightbox
function updateLightboxImage() {
  const lightboxImg = document.getElementById('lightboxImage');
  const counter = document.getElementById('lightboxCounter');
  
  if (lightboxImg && lightboxImages[currentLightboxIndex]) {
    lightboxImg.style.opacity = '0';
    setTimeout(() => {
      lightboxImg.src = lightboxImages[currentLightboxIndex];
      lightboxImg.style.opacity = '1';
    }, 150);
  }
  
  if (counter) {
    counter.textContent = `${currentLightboxIndex + 1} / ${lightboxImages.length}`;
  }
  
  // Actualizar miniaturas activas
  const thumbs = document.querySelectorAll('.lightbox-thumb');
  thumbs.forEach((thumb, index) => {
    if (index === currentLightboxIndex) {
      thumb.classList.add('active');
      thumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
    } else {
      thumb.classList.remove('active');
    }
  });
}

// Ejecutar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
  // Cerrar con tecla ESC y navegación con flechas
  document.addEventListener('keydown', (e) => {
    const modal = document.getElementById('lightboxModal');
    if (modal && modal.style.display === 'flex') {
      if (e.key === 'Escape') {
        closeLightbox();
      } else if (e.key === 'ArrowLeft') {
        changeLightboxImage(-1);
      } else if (e.key === 'ArrowRight') {
        changeLightboxImage(1);
      }
    }
  });

  // Cerrar al hacer click fuera de la imagen
  const lightboxModal = document.getElementById('lightboxModal');
  if (lightboxModal) {
    lightboxModal.addEventListener('click', (e) => {
      if (e.target.id === 'lightboxModal' || e.target.classList.contains('lightbox-content')) {
        closeLightbox();
      }
    });
  }

  // Prevenir que click en imagen o miniaturas cierre el lightbox
  const lightboxImg = document.getElementById('lightboxImage');
  if (lightboxImg) {
    lightboxImg.style.transition = 'opacity 0.3s ease';
    lightboxImg.addEventListener('click', (e) => {
      e.stopPropagation();
    });
  }

  // Click en imagen principal abre lightbox
  const mainImage = document.getElementById('mainImage');
  if (mainImage) {
    mainImage.addEventListener('click', () => {
      openLightbox(0);
    });
    mainImage.style.cursor = 'pointer';
  }

  // Galería principal - miniaturas
  const thumbImages = document.querySelectorAll('.thumb-image');
  thumbImages.forEach((thumb, index) => {
    const thumbImg = thumb.querySelector('img');
    if (thumbImg) {
      thumb.addEventListener('click', (e) => {
        // Si tiene contador, abrir lightbox
        if (thumb.querySelector('.counter-overlay') && e.target.closest('.counter-overlay')) {
          openLightbox(index + 1);
        } else {
          // Abrir lightbox en la imagen correspondiente
          openLightbox(index + 1);
        }
      });
    }
  });

  // Botón favorito
  const favoriteBtn = document.querySelector('.btn-favorite');
  if(favoriteBtn) {
    favoriteBtn.addEventListener('click', () => {
      favoriteBtn.classList.toggle('active');
      const icon = favoriteBtn.querySelector('i');
      if (icon) {
        icon.classList.toggle('fa-regular');
        icon.classList.toggle('fa-solid');
      }
    });
  }

  // Favoritos en cards
  const cardFavorites = document.querySelectorAll('.card-favorite');
  cardFavorites.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const icon = btn.querySelector('i');
      if (icon) {
        icon.classList.toggle('fa-regular');
        icon.classList.toggle('fa-solid');
      }
    });
  });
});
</script>

@if(isset($schema))
<script type="application/ld+json">
    {!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endif

@endsection