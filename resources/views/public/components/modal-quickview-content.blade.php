<div class="flex flex-col md:grid md:grid-cols-12 h-full w-full overflow-hidden rounded-2xl bg-white shadow-2xl">
    
    {{-- COLUMNA IZQUIERDA: IMAGEN (7 de 12 columnas - 60% aprox) --}}
    <div class="relative h-72 md:h-full md:col-span-7 bg-gray-900 group overflow-hidden">
        
        {{-- Swiper Container --}}
        <div class="swiper quickview-swiper w-full h-full">
            <div class="swiper-wrapper">
                {{-- Foto Principal --}}
                <div class="swiper-slide h-full bg-black flex items-center justify-center">
                    <img src="{{ asset('storage/' . $propiedad->imagen_principal) }}" 
                         class="w-full h-full object-cover" 
                         alt="{{ $propiedad->titulo }}">
                </div>
                {{-- Galería --}}
                @foreach($propiedad->imagenes as $img)
                    <div class="swiper-slide h-full bg-black flex items-center justify-center">
                        <img src="{{ asset('storage/' . $img->ruta) }}" 
                             class="w-full h-full object-cover" 
                             alt="{{ $propiedad->titulo }}">
                    </div>
                @endforeach
            </div>
            
            {{-- Navegación: Solo Flechas (Sin círculo de fondo) --}}
            <div class="swiper-button-prev transition-transform hover:-translate-x-1"></div>
            <div class="swiper-button-next transition-transform hover:translate-x-1"></div>
            
            {{-- Paginación --}}
            <div class="swiper-pagination !bottom-6"></div>
        </div>

        {{-- Badges Flotantes --}}
        <div class="absolute top-5 left-5 z-20 flex flex-col gap-2 items-start pointer-events-none">
            <span class="px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wider text-white shadow-md backdrop-blur-md
                {{ $propiedad->tipo_operacion == 'venta' ? 'bg-indigo-600/90' : 'bg-orange-500/90' }}">
                {{ $propiedad->tipo_operacion }}
            </span>
            @if($propiedad->porcentaje_descuento > 0)
                <span class="bg-red-500/90 text-white px-3 py-1.5 rounded-lg text-xs font-bold shadow-md animate-pulse backdrop-blur-md">
                    {{ $propiedad->porcentaje_descuento }}% OFF
                </span>
            @endif
        </div>
    </div>

    {{-- COLUMNA DERECHA: DETALLES (5 de 12 columnas - 40% aprox) --}}
    <div class="flex flex-col h-full md:col-span-5 bg-white overflow-y-auto custom-scrollbar relative">
        
        <div class="p-6 flex flex-col min-h-full">
            
            {{-- 1. Encabezado --}}
            <div class="flex justify-between items-start mb-4">
                <div class="flex flex-col">
                    <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-1">
                        {{ ucfirst($propiedad->tipo_propiedad) }}
                    </span>
                    <div class="flex items-center text-gray-500 text-sm">
                        <i class="fa-solid fa-location-dot mr-1.5 text-red-500"></i>
                        {{ $propiedad->ciudad }}
                    </div>
                </div>
            </div>

            {{-- 2. Título --}}
            <h2 class="text-2xl font-bold text-gray-900 leading-tight mb-4">
                {{ $propiedad->titulo }}
            </h2>

            {{-- 3. Precio --}}
            <div class="mb-6">
                @if($propiedad->porcentaje_descuento > 0)
                    <div class="flex flex-col">
                        <span class="text-sm text-gray-400 line-through decoration-red-400">
                            {{ $propiedad->moneda }} {{ number_format($propiedad->precio, 0, ',', '.') }}
                        </span>
                        <div class="flex items-center gap-2">
                            <span class="text-3xl  text-gray-900">
                                {{ $propiedad->moneda }} {{ number_format($propiedad->getPrecioFinalAttribute(), 0, ',', '.') }}
                            </span>
                            <span class="text-xs font-bold text-green-600 bg-green-100 px-2 py-1 rounded-full">
                                Oportunidad
                            </span>
                        </div>
                    </div>
                @else
                    <span class="text-3xl text-gray-900">
                        {{ $propiedad->moneda }} {{ number_format($propiedad->precio, 0, ',', '.') }}
                    </span>
                @endif
            </div>

            {{-- 4. Specs --}}
            <div class="grid grid-cols-3 gap-0 border-y border-gray-100 py-4 mb-6">
                <div class="text-center px-2 border-r border-gray-100">
                    <i class="fa-solid fa-bed text-gray-400 text-lg mb-1 block"></i>
                    <span class="font-bold text-gray-800 text-lg block leading-none">{{ $propiedad->habitaciones ?? '-' }}</span>
                    <span class="text-[10px] text-gray-400 uppercase font-medium">Dorm.</span>
                </div>
                <div class="text-center px-2 border-r border-gray-100">
                    <i class="fa-solid fa-bath text-gray-400 text-lg mb-1 block"></i>
                    <span class="font-bold text-gray-800 text-lg block leading-none">{{ $propiedad->banos ?? '-' }}</span>
                    <span class="text-[10px] text-gray-400 uppercase font-medium">Baños</span>
                </div>
                <div class="text-center px-2">
                    <i class="fa-solid fa-ruler-combined text-gray-400 text-lg mb-1 block"></i>
                    <span class="font-bold text-gray-800 text-lg block leading-none">{{ $propiedad->superficie_total ?? '-' }}</span>
                    <span class="text-[10px] text-gray-400 uppercase font-medium">m²</span>
                </div>
            </div>

            {{-- 5. Descripción --}}
            <div class="prose prose-sm text-gray-600 mb-8 leading-relaxed">
                <p>
                    {{ Str::limit($propiedad->descripcion, 250) }}
                </p>
                @if(strlen($propiedad->descripcion) > 250)
                    <a href="{{ route('public.propiedad.show', $propiedad->slug) }}" class="text-indigo-600 font-medium text-xs hover:underline mt-2 inline-block">
                        Seguir leyendo en la ficha...
                    </a>
                @endif
            </div>

            {{-- 6. Botones --}}
            <div class="mt-auto grid grid-cols-1 sm:grid-cols-2 gap-3 pt-4 border-t border-gray-50">
                <a href="https://wa.me/5493456256190?text=Hola,%20me%20interesa%20la%20propiedad%20#{{ $propiedad->id }}%20({{ $propiedad->titulo }})" 
                   target="_blank"
                   class="flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white font-bold py-3.5 px-4 rounded-xl transition-all hover:shadow-lg hover:shadow-green-200 group">
                    <i class="fa-brands fa-whatsapp text-xl group-hover:scale-110 transition-transform"></i>
                    <span>Consultar</span>
                </a>
                
                <a href="{{ route('public.propiedad.show', $propiedad->slug) }}" 
                   class="flex items-center justify-center gap-2 bg-gray-900 hover:bg-gray-800 text-white font-bold py-3.5 px-4 rounded-xl transition-all hover:shadow-lg">
                    <span>Ver Detalles</span>
                    <i class="fa-solid fa-arrow-right-long text-sm"></i>
                </a>
            </div>

        </div>
    </div>
</div>

<style>
    /* 1. FLECHAS MINIMALISTAS (SOLO FLECHA) */
    .swiper-button-prev, .swiper-button-next {
        /* Eliminamos cualquier fondo o caja */
        background: transparent !important;
        box-shadow: none !important;
        border: none !important;
        
        /* Flecha blanca pura con sombra para contraste */
        color: #ffffff !important;
        text-shadow: 0 2px 5px rgba(0,0,0,0.6); /* Sombra clave para que se vea sobre blanco */

        /* Centrado y posición */
        top: 50% !important;
        transform: translateY(-50%) !important;
        margin-top: 0 !important;
        z-index: 50;
        
        /* Área de click generosa aunque no se vea el fondo */
        width: 40px !important;
        height: 100% !important; /* Ocupa toda la altura para clickear fácil (opcional) o dejar en px */
        height: 50px !important;
    }

    /* Aumentar tamaño del ícono */
    .swiper-button-prev::after, .swiper-button-next::after {
        font-size: 24px !important; /* Flecha más grande y elegante */
        font-weight: bold;
    }
    
    /* Separarlas un poco del borde */
    .swiper-button-prev { left: 10px !important; }
    .swiper-button-next { right: 10px !important; }

    /* 2. Paginación (Puntitos) */
    .quickview-swiper .swiper-pagination-bullet {
        background: white;
        opacity: 0.5;
        width: 6px;
        height: 6px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.5); /* Sombra para verlos sobre blanco */
        transition: all 0.3s;
    }
    .quickview-swiper .swiper-pagination-bullet-active {
        opacity: 1;
        width: 18px;
        border-radius: 4px;
        background: white;
    }

    /* 3. Scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 5px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
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