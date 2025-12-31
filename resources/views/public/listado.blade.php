@extends('public.layouts.app')

@section('meta_title', $titulo . ' | Dalmolin Inmobiliaria')

@section('contenido')
<div x-data="{ 
    moneda: 'USD', 
    cotizacion: {{ $valor_dolar ?? 1200 }}, 
    formatMoney(monto) {
        let valor = this.moneda === 'USD' ? monto : (monto * this.cotizacion);
        return new Intl.NumberFormat('es-AR', {
            style: 'currency',
            currency: this.moneda,
            maximumFractionDigits: 0
        }).format(valor);
    }
}">    {{-- 1. HEADER MODIFICADO (Fondo Blanco) --}}
        <div class="bg-white py-10 border-b border-gray-200">
        <div class="bg-white py-8 border-b border-gray-200 sticky top-0 z-30 shadow-sm">
            <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-4">
                
                {{-- Título y Contador --}}
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-1">{{ $titulo }}</h1>
                    <p class="text-gray-500 text-sm">
                        {{ $propiedades->total() }} propiedades encontradas
                    </p>
                </div>

                {{-- SWITCH DE MONEDA --}}
                <div class="flex flex-col items-end">
                    <div class="flex items-center bg-gray-100 rounded-lg p-1 border border-gray-200">
                        <button 
                            @click="moneda = 'USD'" 
                            :class="moneda === 'USD' ? 'bg-indigo-600 text-white shadow' : 'text-gray-500 hover:text-gray-700'"
                            class="px-4 py-1.5 rounded-md text-sm font-bold transition-all duration-200">
                            USD
                        </button>
                        <button 
                            @click="moneda = 'ARS'" 
                            :class="moneda === 'ARS' ? 'bg-indigo-600 text-white shadow' : 'text-gray-500 hover:text-gray-700'"
                            class="px-4 py-1.5 rounded-md text-sm font-bold transition-all duration-200">
                            ARS
                        </button>
                    </div>
                    {{-- Info Cotización --}}
                    <div class="text-[10px] text-gray-400 mt-1 font-mono" x-show="moneda === 'ARS'" x-transition>
                        1 USD ≈ $ {{ number_format($valor_dolar ?? 1200, 0, ',', '.') }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- 2. LAYOUT PRINCIPAL (Sidebar + Grid) --}}
    <div  class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            {{-- === SIDEBAR DE FILTROS (Columna Izquierda) === --}}
            <div class="container mx-auto px-4 py-8 flex gap-6">
                @include('public.components.filtros-sidebar')

                <main class="w-full lg:w-3/4">
                </main>
            </div>

            {{-- === GRILLA DE RESULTADOS (Columna Derecha) === --}}
            <div class="lg:col-span-3">
                
                {{-- Filtros Superiores --}}
                <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-100">
                    <p class="text-sm text-gray-500">Ordenado por:</p>
                    <form action="{{ url()->current() }}" method="GET">
                        @foreach(request()->except('orden', 'page') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <select name="orden" onchange="this.form.submit()" class="border-none text-sm font-bold text-gray-700 focus:ring-0 cursor-pointer bg-transparent">
                            <option value="recientes" {{ request('orden') == 'recientes' ? 'selected' : '' }}>Más Recientes</option>
                            <option value="precio_asc" {{ request('orden') == 'precio_asc' ? 'selected' : '' }}>Menor Precio</option>
                            <option value="precio_desc" {{ request('orden') == 'precio_desc' ? 'selected' : '' }}>Mayor Precio</option>
                        </select>
                    </form>
                </div>

                {{-- Grid de Propiedades --}}
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse($propiedades as $propiedad)
                        
                        {{-- CARD EXACTA DEL HOME --}}
                        <article class="bg-white rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 border border-gray-100 overflow-hidden group flex flex-col h-full relative">
                            
                            {{-- 1. IMAGEN Y BADGES --}}
                            <div class="relative h-64 overflow-hidden bg-gray-100">
                                <a href="{{ route('public.propiedad.show', $propiedad->slug) }}">
                                    @if($propiedad->imagen_principal)
                                        <img src="{{ asset('storage/' . $propiedad->imagen_principal) }}" 
                                            alt="{{ $propiedad->titulo }}" 
                                            loading="lazy"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                    @else
                                        <img src="{{ asset('img/placeholder-casa.jpg') }}" class="w-full h-full object-cover opacity-50" alt="Sin Imagen">
                                    @endif
                                </a>

                                {{-- Badge de Operación (Venta/Alquiler) --}}
                                <div class="absolute top-3 left-3 z-10">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider text-white shadow-sm {{ $propiedad->tipo_operacion == 'venta' ? 'bg-indigo-600' : 'bg-orange-500' }}">
                                        {{ $propiedad->tipo_operacion }}
                                    </span>
                                </div>

                                {{-- Lógica de Estados (Vendido/Reservado) --}}
                                @if($propiedad->estado === 'reservado')
                                    <div class="absolute inset-0 bg-yellow-500/65 flex items-center justify-center z-10 pointer-events-none">
                                        <span class="text-white font-black text-xl tracking-widest uppercase border-4 border-white px-4 py-2 transform -rotate-12">
                                            RESERVADO
                                        </span>
                                    </div>
                                @elseif($propiedad->estado === 'vendido')
                                    <div class="absolute inset-0 bg-red-600/65 flex items-center justify-center z-10 pointer-events-none">
                                        <span class="text-white font-black text-xl tracking-widest uppercase border-4 border-white px-4 py-2 transform -rotate-12">
                                            VENDIDO
                                        </span>
                                    </div>
                                @elseif($propiedad->estado === 'alquilado')
                                    <div class="absolute inset-0 bg-blue-600/65 flex items-center justify-center z-10 pointer-events-none">
                                        <span class="text-white font-black text-xl tracking-widest uppercase border-4 border-white px-4 py-2 transform -rotate-12">
                                            ALQUILADO
                                        </span>
                                    </div>
                                @endif

                                {{-- BOTÓN VISTA RÁPIDA --}}
                                <button 
                                    onclick="openQuickView('{{ $propiedad->id }}')" 
                                    class="absolute top-3 right-3 z-20 w-10 h-10 bg-white/95 hover:bg-white backdrop-blur-sm rounded-full flex items-center justify-center transition-all duration-300 shadow-lg  opacity-0 group-hover:opacity-100"
                                    title="Vista Rápida"
                                >
                                    <i class="fa-solid fa-eye text-gray-700  transition-colors"></i>
                                </button>
                            </div>

                            {{-- 2. CONTENIDO --}}
                            <div class="p-5 flex flex-col flex-1">
                                
                                {{-- Precio y Ubicación --}}
                                <div class="mb-3">
                                        <div class="mb-2">
                                        @if($propiedad->porcentaje_descuento > 0)
                                            @php
                                                $montoDescuento = $propiedad->precio * ($propiedad->porcentaje_descuento / 100);
                                                $precioFinal = $propiedad->precio - $montoDescuento;
                                            @endphp

                                            {{-- Etiqueta Oferta --}}
                                            <div class="inline-block bg-green-100 text-green-700 text-xs font-bold px-2 py-1 rounded mb-1">
                                                -{{ $propiedad->porcentaje_descuento }}% OFF
                                            </div>

                                            <div class="flex items-baseline gap-2">
                                                {{-- Precio Viejo (Tachado) --}}
                                                <span class="text-sm text-gray-400 line-through decoration-red-400" 
                                                      x-text="formatMoney({{ $propiedad->precio }})">
                                                    USD {{ number_format($propiedad->precio, 0, ',', '.') }}
                                                </span>
                                                
                                                {{-- Precio Nuevo (Grande) --}}
                                                <span class="text-2xl font-bold text-gray-900"
                                                      x-text="formatMoney({{ $precioFinal }})">
                                                    USD {{ number_format($precioFinal, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        @else
                                            {{-- Precio Normal --}}
                                            <p class="text-2xl font-bold text-gray-900" 
                                               x-text="formatMoney({{ $propiedad->precio }})">
                                                USD {{ number_format($propiedad->precio, 0, ',', '.') }}
                                            </p>
                                        @endif
                                    </div>
                                    <p class="text-gray-500 text-sm flex items-center gap-1">
                                        <i class="fa-solid fa-location-dot text-red-500"></i> {{ Str::limit($propiedad->ciudad, 25) }}
                                    </p>
                                </div>

                                {{-- Título --}}
                                <h3 class="text-lg text-gray-900 leading-tight mb-4 hover:text-blue-600 transition-colors">
                                    <a href="{{ route('public.propiedad.show', $propiedad->slug) }}">
                                        {{ Str::limit($propiedad->titulo, 45) }}
                                    </a>
                                </h3>
                                <div class="mb-4 text-xs text-gray-400 flex items-center">
                                    <i class="fa-regular fa-clock mr-1.5"></i>
                                    @if($propiedad->fecha_publicacion)
                                        Publicado {{ $propiedad->fecha_publicacion->diffForHumans() }}
                                    @else
                                        Recientemente
                                    @endif
                                </div>

                                {{-- Características --}}
                                <div class="grid grid-cols-3 gap-2 border-t border-gray-100 pt-4 mt-auto">
                                    <div class="text-center">
                                        <span class="block font-bold text-gray-800">{{ $propiedad->habitaciones ?? '-' }}</span>
                                        <span class="text-xs text-gray-500">Dorms</span>
                                    </div>
                                    <div class="text-center border-l border-gray-100">
                                        <span class="block font-bold text-gray-800">{{ $propiedad->banos ?? '-' }}</span>
                                        <span class="text-xs text-gray-500">Baños</span>
                                    </div>
                                    <div class="text-center border-l border-gray-100">
                                        <span class="block font-bold text-gray-800">{{ $propiedad->superficie_total ?? '-' }}</span>
                                        <span class="text-xs text-gray-500">m²</span>
                                    </div>
                                </div>

                            </div>
                        </article>
                        {{-- FIN CARD --}}

                    @empty
                        <div class="col-span-full py-12 text-center bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                            <i class="fa-solid fa-filter text-4xl text-gray-300 mb-4"></i>
                            <h3 class="text-lg font-bold text-gray-700">Sin resultados</h3>
                            <p class="text-gray-500 text-sm mt-1">Prueba ajustando los filtros de búsqueda.</p>
                            <a href="{{ url()->current() }}" class="mt-4 inline-block text-red-600 font-bold hover:underline">Ver todo</a>
                        </div>
                    @endforelse
                </div>

                {{-- Paginación --}}
                <div class="mt-12">
                    {{ $propiedades->links() }}
                </div>

            </div>
        </div>
    </div>

</div>
@endsection