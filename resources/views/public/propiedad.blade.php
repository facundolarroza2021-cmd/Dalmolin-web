@extends('public.layouts.app')

@section('meta_title', $propiedad->titulo . ' en ' . $propiedad->ciudad . ' | Dalmolin Inmobiliaria')
@section('meta_description', 'Propiedad en ' . $propiedad->ciudad . '. ' . $propiedad->habitaciones . ' habitaciones, ' . $propiedad->banos . ' baños. Precio: ' . $propiedad->moneda . ' ' . number_format($propiedad->precio, 0, ',', '.'))
@section('meta_image', asset('storage/' . $propiedad->imagen_principal))

@section('contenido')

{{-- Estilos de Leaflet --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<div class="property-detail-page bg-white">
  
  {{-- Breadcrumb minimalista --}}
  <nav class="border-b border-gray-100">
    <div class="container mx-auto px-6 mt-4 py-4 max-w-7xl">
      <div class="flex items-center gap-2 text-sm">
        <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900 transition">Inicio</a>
        <i class="fa-solid fa-chevron-right text-xs text-gray-400"></i>
        <a href="{{ route('public.listado') }}" class="text-gray-600 hover:text-gray-900 transition">Propiedades</a>
        <i class="fa-solid fa-chevron-right text-xs text-gray-400"></i>
        <span class="text-gray-900 font-medium">{{ Str::limit($propiedad->titulo, 40) }}</span>
      </div>
    </div>
  </nav>

  <div class="container mx-auto px-6 max-w-7xl">
    
    {{-- GALERÍA (sin modificar) --}}
    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-2 mb-8 rounded-2xl overflow-hidden shadow-lg" style="height: 500px;">
        
        {{-- FOTO GRANDE (Izquierda - 66% ancho) --}}
        <div class="md:col-span-2 h-full relative group cursor-pointer overflow-hidden" onclick="openLightbox(0)">
            @if($propiedad->imagen_principal)
                <img src="{{ asset('storage/' . $propiedad->imagen_principal) }}" 
                     alt="{{ $propiedad->titulo }}" 
                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
            @else
                <img src="{{ asset('img/placeholder.jpg') }}" class="w-full h-full object-cover">
            @endif
            <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors"></div>
            
            <div class="absolute top-4 left-4 z-10">
                 <span class="px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wider text-white shadow-sm
                    {{ $propiedad->tipo_operacion == 'venta' ? 'bg-indigo-600' : 'bg-orange-500' }}">
                    {{ $propiedad->tipo_operacion }}
                </span>
            </div>
        </div>

        {{-- COLUMNA DERECHA (Las 2 fotos apiladas) --}}
        <div class="hidden md:block h-full">
            <div class="grid grid-rows-2 gap-2 h-full">
                
                {{-- Foto 2 (Arriba) --}}
                <div class="relative cursor-pointer overflow-hidden group" style="height: 249px;" onclick="openLightbox(1)">
                    @if(isset($propiedad->imagenes[0]))
                        <img src="{{ asset('storage/' . $propiedad->imagenes[0]->ruta) }}" 
                             alt="Imagen 2"
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    @else
                        <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">
                            <i class="fa-regular fa-image text-3xl"></i>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors"></div>
                </div>

                {{-- Foto 3 (Abajo) --}}
                <div class="relative cursor-pointer overflow-hidden group" style="height: 249px;" onclick="openLightbox(2)">
                    @if(isset($propiedad->imagenes[1]))
                        <img src="{{ asset('storage/' . $propiedad->imagenes[1]->ruta) }}" 
                             alt="Imagen 3"
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        
                        @if($propiedad->imagenes->count() > 2)
                            <div class="absolute inset-0 bg-black/60 hover:bg-black/50 transition-colors flex items-center justify-center">
                                <span class="text-white font-bold text-xl flex items-center gap-2">
                                    <i class="fa-solid fa-images"></i>
                                    +{{ $propiedad->imagenes->count() - 2 }} fotos
                                </span>
                            </div>
                        @endif
                    @else
                        <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">
                            <i class="fa-regular fa-image text-3xl"></i>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors"></div>
                </div>
            </div>
        </div>

        {{-- Botón móvil --}}
        <button class="md:hidden absolute bottom-4 right-4 bg-white/90 backdrop-blur text-gray-800 px-4 py-2 rounded-lg text-sm font-bold shadow-lg" onclick="openLightbox(0)">
            <i class="fa-solid fa-grip-vertical mr-1"></i> Ver fotos
        </button>
    </div>

    {{-- CONTENIDO PRINCIPAL - Estilo Airbnb --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-16 py-12">
        
        {{-- COLUMNA IZQUIERDA: Info --}}
        <div class="lg:col-span-2 space-y-12">
            
            {{-- Header --}}
            <div class="border-b border-gray-200 pb-8">
                <div class="flex items-start justify-between mb-6">
                    <div class="flex-1">
                        <h1 class="text-3xl font-semibold text-gray-900 mb-3 tracking-tight">{{ $propiedad->titulo }}</h1>
                        <div class="flex items-center gap-4 text-sm">
                            <span class="flex items-center gap-1.5 text-gray-600">
                                <i class="fa-solid fa-location-dot text-gray-400"></i>
                                {{ $propiedad->ciudad }}, Entre Ríos
                            </span>
                            @if($propiedad->direccion)
                            <span class="text-gray-400">•</span>
                            <span class="text-gray-600">{{ $propiedad->direccion }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Características principales --}}
                <div class="flex items-center gap-6 text-base text-gray-700">
                    @if($propiedad->superficie_total)
                    <span class="flex items-center gap-2">
                        <i class="fa-solid fa-ruler-combined text-gray-400"></i>
                        <strong>{{ $propiedad->superficie_total }} m²</strong>
                    </span>
                    @endif
                    @if($propiedad->habitaciones)
                    <span class="flex items-center gap-2">
                        <i class="fa-solid fa-bed text-gray-400"></i>
                        <strong>{{ $propiedad->habitaciones }}</strong> {{ $propiedad->habitaciones == 1 ? 'dormitorio' : 'dormitorios' }}
                    </span>
                    @endif
                    @if($propiedad->banos)
                    <span class="flex items-center gap-2">
                        <i class="fa-solid fa-bath text-gray-400"></i>
                        <strong>{{ $propiedad->banos }}</strong> {{ $propiedad->banos == 1 ? 'baño' : 'baños' }}
                    </span>
                    @endif
                </div>
            </div>

            {{-- Descripción --}}
            <div class="space-y-4">
                <h2 class="text-xl font-semibold text-gray-900">Acerca de esta propiedad</h2>
                <p class="text-gray-600 leading-relaxed whitespace-pre-line text-base">{{ $propiedad->descripcion }}</p>
            </div>
            @if($propiedad->video_url)
            <div class="mt-8">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                    @if(Str::contains($propiedad->video_url, ['matterport', 'kuula']))
                        <i class="fa-solid fa-vr-cardboard text-indigo-600"></i> Recorrido Virtual 360°
                    @else
                        <i class="fa-brands fa-youtube text-red-600"></i> Video Presentación
                    @endif
                </h3>
                
                <div class="relative w-full overflow-hidden rounded-2xl shadow-lg aspect-video bg-gray-100">
                    <iframe 
                        src="{{ $propiedad->embed_url }}" 
                        title="Video de la propiedad" 
                        class="absolute top-0 left-0 w-full h-full" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
            @endif

            {{-- Características detalladas --}}
            <div class="space-y-6 border-t border-gray-200 pt-12">
                <h2 class="text-xl font-semibold text-gray-900">Detalles</h2>
                <div class="grid grid-cols-2 gap-x-12 gap-y-6">
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-gray-600">Tipo de propiedad</span>
                        <span class="font-medium text-gray-900 capitalize">{{ $propiedad->tipo_propiedad }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-gray-600">Operación</span>
                        <span class="font-medium text-gray-900 capitalize">{{ $propiedad->tipo_operacion }}</span>
                    </div>
                    @if($propiedad->cocheras)
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-gray-600">Cocheras</span>
                        <span class="font-medium text-gray-900">{{ $propiedad->cocheras }}</span>
                    </div>
                    @endif
                    @if($propiedad->superficie_terreno)
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-gray-600">Superficie terreno</span>
                        <span class="font-medium text-gray-900">{{ $propiedad->superficie_terreno }} m²</span>
                    </div>
                    @endif
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-gray-600">Referencia</span>
                        <span class="font-medium text-gray-900">#{{ $propiedad->id }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-gray-600">Publicado</span>
                        <span class="font-medium text-gray-900">{{ $propiedad->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- Ubicación --}}
            <div class="space-y-6 border-t border-gray-200 pt-12">
                <h2 class="text-xl font-semibold text-gray-900">Ubicación</h2>
                @if($propiedad->latitud && $propiedad->longitud)
                    <div class="w-full h-[450px] rounded-xl overflow-hidden relative z-0">
                        <div id="map-detail" class="w-full h-full z-0"></div>
                    </div>
                    <p class="text-sm text-gray-500">
                        <i class="fa-solid fa-circle-info mr-1"></i> La ubicación mostrada es aproximada por motivos de privacidad.
                    </p>
                @else
                    <div class="w-full h-64 bg-gray-50 rounded-xl flex flex-col items-center justify-center text-gray-400 border border-gray-200">
                        <i class="fa-solid fa-map-location-dot text-5xl mb-3"></i>
                        <p class="text-gray-600 font-medium">{{ $propiedad->ciudad }}</p>
                        @if($propiedad->direccion)
                        <p class="text-sm text-gray-500">{{ $propiedad->direccion }}</p>
                        @endif
                    </div>
                @endif
            </div>

        </div>

        {{-- COLUMNA DERECHA: Card de contacto sticky --}}
        <div class="lg:col-span-1">
            <div class="sticky top-28 space-y-4">
                
                {{-- Card Principal --}}
                <div class="bg-white border border-gray-200 rounded-2xl shadow-xl overflow-hidden">
                    
                    {{-- Precio --}}
                    <div class="px-8 py-8 border-b border-gray-100">
                        @if($propiedad->porcentaje_descuento > 0)
                            <div class="flex items-baseline gap-3 mb-2">
                                <span class="text-4xl font-semibold text-gray-900">{{ $propiedad->moneda }} {{ number_format($propiedad->getPrecioFinalAttribute(), 0, ',', '.') }}</span>
                                <span class="text-lg text-gray-400 line-through">{{ number_format($propiedad->precio, 0, ',', '.') }}</span>
                            </div>
                            <div class="inline-flex items-center gap-2 bg-gray-900 text-white text-xs px-3 py-1 rounded-full font-medium">
                                <span>Ahorrás {{ $propiedad->porcentaje_descuento }}%</span>
                            </div>
                        @else
                            <div class="text-4xl font-semibold text-gray-900 mb-1">{{ $propiedad->moneda }} {{ number_format($propiedad->precio, 0, ',', '.') }}</div>
                            <p class="text-sm text-gray-500">Precio total</p>
                        @endif
                    </div>

                    <div class="p-8">
                        {{-- Características --}}
                        <div class="grid grid-cols-3 gap-6 mb-8 pb-8 border-b border-gray-100">
                            <div class="text-center">
                                <div class="text-2xl font-semibold text-gray-900 mb-1">{{ $propiedad->superficie_total ?? '-' }}</div>
                                <div class="text-xs text-gray-500 uppercase tracking-wide">m² totales</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-semibold text-gray-900 mb-1">{{ $propiedad->habitaciones ?? '-' }}</div>
                                <div class="text-xs text-gray-500 uppercase tracking-wide">Dormitorios</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-semibold text-gray-900 mb-1">{{ $propiedad->banos ?? '-' }}</div>
                                <div class="text-xs text-gray-500 uppercase tracking-wide">Baños</div>
                            </div>
                        </div>

                        {{-- Botones CTA --}}
                        <div class="space-y-3">
                            <a href="https://wa.me/5493456256190?text=Hola,%20me%20interesa%20la%20propiedad:%20{{ urlencode($propiedad->titulo) }}%20(#{{ $propiedad->id }})" 
                               target="_blank" 
                               class="group flex items-center justify-center gap-3 w-full bg-gray-900 hover:bg-gray-800 text-white font-medium py-4 rounded-xl transition-all">
                                <i class="fa-brands fa-whatsapp text-xl"></i>
                                <span>Consultar por WhatsApp</span>
                                <i class="fa-solid fa-arrow-right text-sm opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all"></i>
                            </a>

                            <a href="tel:+5493456256190" 
                               class="flex items-center justify-center gap-3 w-full bg-white hover:bg-gray-50 text-gray-900 font-medium py-4 rounded-xl border border-gray-300 hover:border-gray-400 transition-all">
                                <i class="fa-solid fa-phone"></i>
                                <span>+54 9 3456 256190</span>
                            </a>
                        </div>

                        {{-- Acciones secundarias --}}
                        <div class="mt-6 pt-6 border-t border-gray-100">
                            <div class="grid grid-cols-2 gap-3">
                                <button onclick="navigator.share({title: '{{ $propiedad->titulo }}', url: window.location.href})" 
                                        class="flex items-center justify-center gap-2 py-3 text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-all">
                                    <i class="fa-solid fa-share-nodes"></i>
                                    <span class="text-sm font-medium">Compartir</span>
                                </button>
                                <button class="flex items-center justify-center gap-2 py-3 text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-all">
                                    <i class="fa-regular fa-heart"></i>
                                    <span class="text-sm font-medium">Guardar</span>
                                </button>
                            </div>
                        </div>

                        {{-- Trust badges --}}
                        <div class="mt-8 space-y-4">
                            <div class="flex items-start gap-3 text-sm">
                                <i class="fa-solid fa-shield-check text-gray-400 text-lg mt-0.5"></i>
                                <div>
                                    <p class="font-medium text-gray-900">Propiedad verificada</p>
                                    <p class="text-gray-500 text-xs">Documentación completa</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 text-sm">
                                <i class="fa-solid fa-headset text-gray-400 text-lg mt-0.5"></i>
                                <div>
                                    <p class="font-medium text-gray-900">Asesoramiento profesional</p>
                                    <p class="text-gray-500 text-xs">Sin costo adicional</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="px-8 py-6 bg-gray-50 border-t border-gray-100">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500 font-mono">REF: #{{ $propiedad->id }}</span>
                            <img src="{{ asset('img/dalmolin_logo2.png') }}" alt="Dalmolin" class="h-6 opacity-40">
                        </div>
                    </div>
                </div>

                {{-- Info adicional --}}
                <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-gray-900 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-info text-white text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900 mb-1">¿Necesitás más información?</p>
                            <p class="text-xs text-gray-600 leading-relaxed">Un agente te puede ayudar con el proceso de compra o alquiler.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    {{-- Propiedades similares --}}
    @if(isset($sugeridas) && $sugeridas->count() > 0)
    <div class="border-t border-gray-200 py-16">
        <h2 class="text-2xl font-semibold text-gray-900 mb-8">Propiedades similares</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($sugeridas as $sugerencia)
                <x-propiedad-card :propiedad="$sugerencia" />
            @endforeach
        </div>
    </div>
    @endif

  </div>
</div>

{{-- Lightbox --}}
<div id="lightboxModal" class="fixed inset-0 z-[1000] bg-black/95 hidden flex-col items-center justify-center backdrop-blur-sm">
    <button class="absolute top-4 right-4 text-white p-4 hover:text-gray-300 transition" onclick="closeLightbox()">
        <i class="fa-solid fa-xmark text-4xl"></i>
    </button>
    <button class="absolute left-4 top-1/2 -translate-y-1/2 text-white p-4 hover:bg-white/10 rounded-full transition" onclick="changeLightboxImage(-1)">
        <i class="fa-solid fa-chevron-left text-3xl"></i>
    </button>
    <button class="absolute right-4 top-1/2 -translate-y-1/2 text-white p-4 hover:bg-white/10 rounded-full transition" onclick="changeLightboxImage(1)">
        <i class="fa-solid fa-chevron-right text-3xl"></i>
    </button>
    
    <img id="lightboxImage" src="" class="max-h-[85vh] max-w-[90vw] object-contain rounded-lg shadow-2xl transition-opacity duration-300">
    
    <div class="absolute bottom-6 text-white font-mono bg-black/50 px-4 py-2 rounded-full">
        <span id="lightboxCounter">1 / 1</span>
    </div>
</div>

{{-- SCRIPTS --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    const propertyData = {
        lat: {{ $propiedad->latitud ?? 'null' }},
        lng: {{ $propiedad->longitud ?? 'null' }},
        title: "{{ $propiedad->titulo }}",
        address: "{{ $propiedad->direccion }}",
        iconUrl: "{{ asset('img/dalmolin_icon2.png') }}"
    };

    const lightboxImages = [
      "{{ asset('storage/' . $propiedad->imagen_principal) }}",
      @foreach($propiedad->imagenes as $img)
      "{{ asset('storage/' . $img->ruta) }}",
      @endforeach
    ];

    if (propertyData.lat && propertyData.lng) {
        document.addEventListener('DOMContentLoaded', function() {
            var map = L.map('map-detail', { scrollWheelZoom: false }).setView([propertyData.lat, propertyData.lng], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap'
            }).addTo(map);

            var houseIcon = L.icon({
                iconUrl: propertyData.iconUrl,
                iconSize: [40, 40],
                iconAnchor: [20, 40],
                popupAnchor: [0, -40]
            });

            L.marker([propertyData.lat, propertyData.lng]).addTo(map)
                .bindPopup(`<b>${propertyData.title}</b><br>${propertyData.address}`)
                .openPopup();
        });
    }

    let currentLightboxIndex = 0;

    function openLightbox(index) {
        if(index >= lightboxImages.length) index = 0;
        currentLightboxIndex = index;
        
        const modal = document.getElementById('lightboxModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden'; 
        
        updateLightboxImage();
    }

    function closeLightbox() {
        const modal = document.getElementById('lightboxModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }

    function changeLightboxImage(direction) {
        currentLightboxIndex += direction;
        if (currentLightboxIndex < 0) currentLightboxIndex = lightboxImages.length - 1;
        if (currentLightboxIndex >= lightboxImages.length) currentLightboxIndex = 0;
        
        updateLightboxImage();
    }

    function updateLightboxImage() {
        const img = document.getElementById('lightboxImage');
        img.style.opacity = '0.5';
        img.src = lightboxImages[currentLightboxIndex];
        
        setTimeout(() => {
            img.style.opacity = '1';
        }, 150);
        
        document.getElementById('lightboxCounter').innerText = `${currentLightboxIndex + 1} / ${lightboxImages.length}`;
    }

    document.addEventListener('keydown', (e) => {
        if (document.getElementById('lightboxModal').classList.contains('hidden')) return;
        
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') changeLightboxImage(-1);
        if (e.key === 'ArrowRight') changeLightboxImage(1);
    });
</script>

@if(isset($schema))
<script type="application/ld+json">
    {!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endif

@endsection