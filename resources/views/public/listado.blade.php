@extends('public.layouts.app')

@section('meta_title', $titulo . ' | Dalmolin Inmobiliaria')

@section('contenido')

    {{-- 1. HEADER MODIFICADO (Fondo Blanco) --}}
    <div class="bg-white py-10 border-b border-gray-200">
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $titulo }}</h1>
            <p class="text-gray-500 text-sm">
                Mostrando {{ $propiedades->firstItem() ?? 0 }} - {{ $propiedades->lastItem() ?? 0 }} de {{ $propiedades->total() }} resultados
            </p>
        </div>
    </div>

    {{-- 2. LAYOUT PRINCIPAL (Sidebar + Grid) --}}
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            {{-- === SIDEBAR DE FILTROS (Columna Izquierda) === --}}
            <aside class="lg:col-span-1">
                <div class="sticky top-24">
                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="bg-gray-50 px-5 py-3 border-b border-gray-200 flex justify-between items-center">
                            <h3 class="font-bold text-gray-800">Filtrar Búsqueda</h3>
                            @if(request()->anyFilled(['habitaciones', 'banos', 'cocheras', 'precio_min', 'precio_max', 'ciudad']))
                                <a href="{{ url()->current() }}" class="text-xs text-red-600 font-bold hover:underline">Limpiar</a>
                            @endif
                        </div>

                        <form action="{{ url()->current() }}" method="GET" class="p-5 space-y-6">
                            
                            {{-- Ubicación --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Ubicación / Ciudad</label>
                                <div class="relative">
                                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-gray-400 text-sm"></i>
                                    <input type="text" name="ciudad" value="{{ request('ciudad') }}" 
                                           placeholder="Ej: Centro, Concordia..." 
                                           class="w-full pl-9 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-red-500 focus:border-red-500">
                                </div>
                            </div>

                            <hr class="border-gray-100">

                            {{-- Características --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-3">Características</label>
                                
                                <div class="space-y-3">
                                    {{-- Habitaciones --}}
                                    <div>
                                        <span class="text-xs text-gray-500 mb-1 block">Dormitorios</span>
                                        <div class="flex gap-2">
                                            @foreach([1, 2, 3, 4] as $num)
                                                <label class="cursor-pointer">
                                                    <input type="radio" name="habitaciones" value="{{ $num }}" 
                                                           onchange="this.form.submit()" class="peer hidden"
                                                           {{ request('habitaciones') == $num ? 'checked' : '' }}>
                                                    <span class="block w-8 h-8 text-center leading-8 rounded bg-gray-100 text-gray-600 text-sm font-bold peer-checked:bg-red-600 peer-checked:text-white transition-colors hover:bg-gray-200">
                                                        {{ $num }}+
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    {{-- Baños --}}
                                    <div>
                                        <span class="text-xs text-gray-500 mb-1 block">Baños</span>
                                        <div class="flex gap-2">
                                            @foreach([1, 2, 3] as $num)
                                                <label class="cursor-pointer">
                                                    <input type="radio" name="banos" value="{{ $num }}" 
                                                           onchange="this.form.submit()" class="peer hidden"
                                                           {{ request('banos') == $num ? 'checked' : '' }}>
                                                    <span class="block w-8 h-8 text-center leading-8 rounded bg-gray-100 text-gray-600 text-sm font-bold peer-checked:bg-gray-800 peer-checked:text-white transition-colors hover:bg-gray-200">
                                                        {{ $num }}+
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="border-gray-100">

                            {{-- Cocheras --}}
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="checkbox" name="cocheras" value="si" onchange="this.form.submit()"
                                       class="rounded text-red-600 focus:ring-red-500 border-gray-300 w-5 h-5"
                                       {{ request('cocheras') == 'si' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 font-medium group-hover:text-red-700 transition">Solo con Cochera</span>
                            </label>

                            <hr class="border-gray-100">

                            {{-- Precio --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Rango de Precio (USD)</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="number" name="precio_min" value="{{ request('precio_min') }}" placeholder="Mín" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                    <input type="number" name="precio_max" value="{{ request('precio_max') }}" placeholder="Máx" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-red-700 hover:bg-red-800 text-white font-bold py-3 rounded-lg transition-all shadow-md mt-4">
                                Aplicar Filtros
                            </button>

                        </form>
                    </div>
                </div>
            </aside>

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
                        <article class="property-card">
                          
                          <div class="card-image">
                            <a href="{{ route('public.propiedad.show', $propiedad->slug) }}">
                                @if($propiedad->imagen_principal)
                                    <img src="{{ asset('storage/' . $propiedad->imagen_principal) }}" alt="{{ $propiedad->titulo }}">
                                @else
                                    <img src="{{ asset('img/placeholder-casa.jpg') }}" alt="Sin imagen">
                                @endif
                            </a>
                            
                            <div class="card-badge">{{ ucfirst($propiedad->tipo_operacion) }}</div>
                          </div>
                          
                          <div class="card-content">
                            
                            <div class="card-location">
                                <i class="fa-solid fa-location-dot"></i>
                                <span>{{ $propiedad->ciudad }}</span>
                            </div>
                            
                            <h3 class="card-title">{{ Str::limit($propiedad->titulo, 45) }}</h3>
                            
                            <div class="card-features">
                              <div class="card-feature">
                                <i class="fa-solid fa-ruler-combined"></i>
                                <span>{{ $propiedad->superficie_total }} m²</span>
                              </div>
                              <div class="card-feature">
                                <i class="fa-solid fa-bed"></i>
                                <span>{{ $propiedad->habitaciones }}</span>
                              </div>
                              <div class="card-feature">
                                <i class="fa-solid fa-bath"></i>
                                <span>{{ $propiedad->banos }}</span>
                              </div>
                            </div>
                
                            <div class="card-divider"></div>
                
                            <div class="card-footer">
                              <div class="card-price">
                                <span class="price-tag">Precio</span>
                                <span class="price-text">{{ $propiedad->moneda }} {{ number_format($propiedad->precio, 0, ',', '.') }}</span>
                              </div>
                              
                              <a href="{{ route('public.propiedad.show', $propiedad->slug) }}" class="btn-card">
                                Ver más
                                <i class="fa-solid fa-arrow-right"></i>
                              </a>
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

@endsection