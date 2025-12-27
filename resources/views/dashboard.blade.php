<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Control') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- 1. BIENVENIDA --}}
            <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="text-3xl font-bold text-gray-800">¡Hola, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-gray-500 mt-1">Aquí tienes el resumen de tu inmobiliaria hoy.</p>
                </div>
                <a href="{{ route('admin.properties.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg transition flex items-center gap-2 transform hover:scale-105">
                    <i class="fa-solid fa-plus"></i> Publicar Nueva Propiedad
                </a>
            </div>

            {{-- 2. TARJETAS DE ESTADÍSTICAS (KPIs) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                
                {{-- Total --}}
                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500 flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Total Cartera</p>
                        <h4 class="text-3xl font-black text-gray-800">{{ $total }}</h4>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center text-xl">
                        <i class="fa-solid fa-building"></i>
                    </div>
                </div>

                {{-- Disponibles --}}
                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500 flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Disponibles</p>
                        <h4 class="text-3xl font-black text-gray-800">{{ $disponibles }}</h4>
                    </div>
                    <div class="w-12 h-12 bg-green-50 text-green-500 rounded-full flex items-center justify-center text-xl">
                        <i class="fa-solid fa-check-circle"></i>
                    </div>
                </div>

                {{-- Reservadas --}}
                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-400 flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Reservadas</p>
                        <h4 class="text-3xl font-black text-gray-800">{{ $reservadas }}</h4>
                    </div>
                    <div class="w-12 h-12 bg-yellow-50 text-yellow-500 rounded-full flex items-center justify-center text-xl">
                        <i class="fa-solid fa-handshake"></i>
                    </div>
                </div>

                {{-- Vendidas --}}
                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500 flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Vendidas Histórico</p>
                        <h4 class="text-3xl font-black text-gray-800">{{ $vendidas }}</h4>
                    </div>
                    <div class="w-12 h-12 bg-red-50 text-red-500 rounded-full flex items-center justify-center text-xl">
                        <i class="fa-solid fa-trophy"></i>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- 3. ÚLTIMAS PUBLICACIONES --}}
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h4 class="font-bold text-gray-800">Últimas Agregadas</h4>
                        <a href="{{ route('admin.properties.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Ver todo el inventario &rarr;</a>
                    </div>
                    
                    <div class="divide-y divide-gray-100">
                        @forelse($ultimas as $propiedad)
                            <div class="p-4 flex items-center hover:bg-gray-50 transition">
                                {{-- Foto --}}
                                <div class="h-12 w-12 rounded-lg bg-gray-200 overflow-hidden flex-shrink-0 border border-gray-200">
                                    @if($propiedad->imagen_principal)
                                        <img src="{{ asset('storage/' . $propiedad->imagen_principal) }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center text-gray-400"><i class="fa-solid fa-image"></i></div>
                                    @endif
                                </div>
                                
                                {{-- Info --}}
                                <div class="ml-4 flex-1">
                                    <div class="flex items-center gap-2">
                                        <h5 class="text-sm font-bold text-gray-900 truncate w-48">{{ $propiedad->titulo }}</h5>
                                        {{-- Badge de Estado --}}
                                        @if($propiedad->estado == 'vendido')
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-700 uppercase">Vendido</span>
                                        @elseif($propiedad->estado == 'reservado')
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-yellow-100 text-yellow-700 uppercase">Reservado</span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        {{ ucfirst($propiedad->tipo_operacion) }} en {{ $propiedad->ciudad }}
                                    </p>
                                </div>

                                {{-- Precio y Botón --}}
                                <div class="text-right">
                                    <p class="text-sm font-bold text-gray-900">{{ $propiedad->moneda }} {{ number_format($propiedad->precio, 0, ',', '.') }}</p>
                                    <a href="{{ route('admin.properties.edit', $propiedad->id) }}" class="text-xs text-gray-400 hover:text-blue-600 flex items-center justify-end gap-1 mt-1">
                                        <i class="fa-solid fa-pen"></i> Editar
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-gray-500">
                                <i class="fa-regular fa-folder-open text-3xl mb-2 opacity-30"></i>
                                <p>Aún no has cargado propiedades.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- 4. ACCESOS RÁPIDOS LATERALES --}}
                <div class="space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h4 class="font-bold text-gray-800 mb-4">Accesos Directos</h4>
                        <div class="space-y-3">
                            <a href="{{ route('home') }}" target="_blank" class="block w-full text-center py-3 bg-gray-50 hover:bg-gray-100 text-gray-700 font-bold rounded-lg border border-gray-200 transition flex items-center justify-center gap-2">
                                <i class="fa-solid fa-globe"></i> Ver Sitio Web
                            </a>
                            <a href="{{ route('profile.edit') }}" class="block w-full text-center py-3 bg-gray-50 hover:bg-gray-100 text-gray-700 font-bold rounded-lg border border-gray-200 transition flex items-center justify-center gap-2">
                                <i class="fa-solid fa-user-gear"></i> Mi Perfil
                            </a>
                        </div>
                    </div>
                    
                    {{-- Mini Tip --}}
                    <div class="bg-blue-600 rounded-xl shadow-lg p-6 text-white relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 text-blue-500 opacity-20">
                            <i class="fa-solid fa-lightbulb text-9xl"></i>
                        </div>
                        <h4 class="font-bold text-lg relative z-10">¿Sabías qué?</h4>
                        <p class="text-blue-100 text-sm mt-2 relative z-10">
                            Puedes marcar una propiedad como <span class="font-bold text-white">"Destacada"</span> desde el listado haciendo clic en la estrella ⭐.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>