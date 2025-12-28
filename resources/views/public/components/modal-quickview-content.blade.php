<div class="grid grid-cols-1 md:grid-cols-5 gap-0 h-full">
    
    {{-- COLUMNA IZQUIERDA: CARRUSEL DE FOTOS --}}
    <div class="bg-black relative group h-64 md:h-auto md:col-span-3">
        
        <div class="swiper quickview-swiper w-full h-full">
            <div class="swiper-wrapper">
                {{-- Foto Principal --}}
                <div class="swiper-slide">
                    <img src="{{ asset('storage/' . $propiedad->imagen_principal) }}" 
                         class="w-full h-full object-cover" 
                         alt="{{ $propiedad->titulo }}">
                </div>
                {{-- Galería --}}
                @foreach($propiedad->imagenes as $img)
                    <div class="swiper-slide">
                        <img src="{{ asset('storage/' . $img->ruta) }}" 
                             class="w-full h-full object-cover" 
                             alt="{{ $propiedad->titulo }}">
                    </div>
                @endforeach
            </div>
            
            {{-- Navegación minimalista --}}
            <div class="swiper-button-next !w-10 !h-10 !rounded-full after:!text-sm after:!text-gray-800"></div>
            <div class="swiper-button-prev !w-10 !h-10 !rounded-full after:!text-sm after:!text-gray-800"></div>
            <div class="swiper-pagination !bottom-4"></div>
        </div>

        {{-- Badge simple VENTA/ALQUILER --}}
        <div class="absolute top-4 left-4 z-10">
            <span class="px-3 py-1.5 rounded-md text-xs font-bold uppercase bg-blue-600 text-white shadow-lg">
                {{ $propiedad->tipo_operacion }}
            </span>
        </div>

        {{-- Contador de fotos discreto --}}
        <div class="absolute bottom-4 left-4 z-10 bg-black/60 backdrop-blur-sm px-2.5 py-1 rounded-md">
            <span class="text-white text-xs font-medium">
                <span class="quickview-photo-counter">1</span> / {{ $propiedad->imagenes->count() + 1 }}
            </span>
        </div>
    </div>

    {{-- COLUMNA DERECHA: INFORMACIÓN LIMPIA --}}
    <div class="p-8 flex flex-col h-full overflow-y-auto bg-white md:col-span-2">
        
        {{-- Ubicación --}}
        <div class="flex items-center gap-1.5 text-sm text-gray-500 mb-3">
            <i class="fa-solid fa-location-dot text-gray-400"></i>
            <span>{{ $propiedad->ciudad }}</span>
            @if($propiedad->direccion)
                <span>• {{ $propiedad->direccion }}</span>
            @endif
        </div>

        {{-- Título limpio --}}
        <h2 class="text-2xl text-gray-900 leading-tight mb-6">
            {{ $propiedad->titulo }}
        </h2>
        <div class="flex items-center text-sm text-gray-500 mb-4">
            <span class="flex items-center">
                <i class="fa-regular fa-clock mr-1"></i>
                {{ $propiedad->fecha_publicacion ? 'Publicado ' . $propiedad->fecha_publicacion->diffForHumans() : 'Reciente' }}
            </span>
        </div>

        {{-- Precio destacado minimalista --}}
        <div class="mb-6">
            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Precio</p>
            <p class="text-4xl  text-gray-900">
                {{ $propiedad->moneda }} {{ number_format($propiedad->precio, 0, ',', '.') }}
            </p>
        </div>

        {{-- Características minimalistas --}}
        <div class="flex gap-6 pb-6 mb-6 border-b border-gray-200">
            @if($propiedad->habitaciones)
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-bed text-gray-400"></i>
                <span class="text-sm font-semibold text-gray-900">{{ $propiedad->habitaciones }}</span>
                <span class="text-xs text-gray-500">dorms</span>
            </div>
            @endif

            @if($propiedad->banos)
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-bath text-gray-400"></i>
                <span class="text-sm font-semibold text-gray-900">{{ $propiedad->banos }}</span>
                <span class="text-xs text-gray-500">baños</span>
            </div>
            @endif

            @if($propiedad->superficie_total)
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-expand text-gray-400"></i>
                <span class="text-sm font-semibold text-gray-900">{{ $propiedad->superficie_total }}</span>
                <span class="text-xs text-gray-500">m²</span>
            </div>
            @endif
        </div>

        {{-- Descripción --}}
        <div class="mb-6 flex-1">
            <h4 class="text-sm font-semibold text-gray-900 mb-2">Descripción</h4>
            <p class="text-sm text-gray-600 leading-relaxed line-clamp-3">
                {{ $propiedad->descripcion }}
            </p>
        </div>

        {{-- Botones limpios y espaciados --}}
        <div class="mb-[120px] space-y-3">
            <a href="{{ route('public.propiedad.show', $propiedad->slug) }}" 
               class="block w-full text-center bg-gray-900 hover:bg-black text-white font-semibold py-3.5 rounded-lg transition-colors">
                Ver Ficha Completa
            </a>
            
            <a href="https://wa.me/5493456256190?text=Hola,%20me%20interesa%20{{ urlencode($propiedad->titulo) }}" 
               target="_blank" 
               class="block w-full text-center bg-green-500 hover:bg-green-600 text-white font-semibold py-3.5 rounded-lg transition-colors flex items-center justify-center gap-2">
                <i class="fa-brands fa-whatsapp"></i>
                Consultar
            </a>
        </div>
    </div>
</div>

<style>
    /* Paginación minimalista */
    .quickview-swiper .swiper-pagination-bullet {
        background: white;
        opacity: 0.4;
        width: 6px;
        height: 6px;
    }

    .quickview-swiper .swiper-pagination-bullet-active {
        opacity: 1;
        width: 20px;
        border-radius: 3px;
    }

    /* Line clamp */
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Scrollbar minimalista */
    .overflow-y-auto::-webkit-scrollbar {
        width: 4px;
    }

    .overflow-y-auto::-webkit-scrollbar-track {
        background: transparent;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb {
        background: #e5e7eb;
        border-radius: 2px;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background: #d1d5db;
    }
    .swiper-button-prev, .swiper-button-next {
        color: #ffffff !important;
    }
</style>

<script>

    // Actualizar contador
    document.addEventListener('DOMContentLoaded', function() {
        const swiper = document.querySelector('.quickview-swiper')?.swiper;
        if (swiper) {
            swiper.on('slideChange', function() {
                const counter = document.querySelector('.quickview-photo-counter');
                if (counter) {
                    counter.textContent = swiper.activeIndex + 1;
                }
            });
        }
    });
</script>