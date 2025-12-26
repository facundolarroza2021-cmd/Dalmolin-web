@props(['propiedad'])


<div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 group h-full flex flex-col">
    {{-- IMAGEN CON BADGES --}}
    <div class="relative h-64 overflow-hidden rounded-t-xl">
        <img src="{{ asset('storage/' . $propiedad->imagen_principal) }}" 
             alt="{{ $propiedad->titulo }}" 
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        
        {{-- Badge de Operación --}}
        <div class="absolute top-3 left-3">
            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider text-white shadow-sm
                {{ $propiedad->tipo_operacion == 'venta' ? 'bg-indigo-600' : 'bg-orange-500' }}">
                {{ $propiedad->tipo_operacion }}
            </span>
        </div>

        {{-- Badge de Destacada (Si aplica) --}}
        @if($propiedad->destacada)
            <div class="absolute top-3 right-3">
                <span class="bg-yellow-400 text-yellow-900 px-2 py-1 rounded-lg text-xs font-bold shadow-sm">
                    <i class="fa-solid fa-star"></i>
                </span>
            </div>
        @endif
    </div>

    {{-- CONTENIDO --}}
    <div class="p-5 flex flex-col flex-1">
        {{-- Precio y Ubicación --}}
        <div class="mb-4">
            <p class="text-2xl font-bold text-gray-900 mb-1">
                {{ $propiedad->moneda }} {{ number_format($propiedad->precio, 0, ',', '.') }}
            </p>
            <p class="text-gray-500 text-sm flex items-center">
                <i class="fa-solid fa-location-dot text-red-500 mr-2 text-xs"></i> 
                {{ Str::limit($propiedad->ciudad, 25) }}
            </p>
        </div>

        {{-- Título --}}
        <h3 class="text-lg font-bold text-gray-800 leading-tight mb-4 group-hover:text-indigo-600 transition-colors">
            <a href="{{ route('public.propiedad.show', $propiedad->slug) }}">
                {{ Str::limit($propiedad->titulo, 45) }}
            </a>
        </h3>

        {{-- Características (Iconos) --}}
        <div class="grid grid-cols-3 gap-2 border-t border-gray-100 pt-4 mt-auto">
            <div class="text-center">
                <span class="block text-gray-900 font-bold text-sm">{{ $propiedad->habitaciones ?? '-' }}</span>
                <span class="text-xs text-gray-400">Habs</span>
            </div>
            <div class="text-center border-l border-gray-100">
                <span class="block text-gray-900 font-bold text-sm">{{ $propiedad->banos ?? '-' }}</span>
                <span class="text-xs text-gray-400">Baños</span>
            </div>
            <div class="text-center border-l border-gray-100">
                <span class="block text-gray-900 font-bold text-sm">{{ $propiedad->superficie_total ?? '-' }}</span>
                <span class="text-xs text-gray-400">m²</span>
            </div>
        </div>
    </div>
</div>