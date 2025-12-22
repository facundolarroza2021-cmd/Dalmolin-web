<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Panel de Control') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8">
                <h3 class="text-2xl font-bold text-gray-800">¡Hola, {{ Auth::user()->name }}! 👋</h3>
                <p class="text-gray-600">Aquí tienes un resumen de tu inmobiliaria hoy.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-medium uppercase tracking-wide">Total Propiedades</p>
                                <h4 class="text-3xl font-bold text-gray-800">{{ $totalPropiedades }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-green-500">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-500 mr-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-medium uppercase tracking-wide">En Venta</p>
                                <h4 class="text-3xl font-bold text-gray-800">{{ $enVenta }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-orange-500">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-orange-100 text-orange-500 mr-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-medium uppercase tracking-wide">En Alquiler</p>
                                <h4 class="text-3xl font-bold text-gray-800">{{ $enAlquiler }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h4 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2">Accesos Rápidos</h4>
                    <div class="space-y-3">
                        <a href="{{ route('admin.properties.create') }}" class="block w-full text-center py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded transition">
                            + Publicar Nueva Propiedad
                        </a>
                        <a href="{{ route('home') }}" target="_blank" class="block w-full text-center py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded transition">
                            Ir al Sitio Web Público
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-2 bg-white shadow-sm sm:rounded-lg p-6">
                    <h4 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2">Últimas Publicaciones</h4>
                    
                    @if($ultimas->count() > 0)
                        <ul class="divide-y divide-gray-200">
                            @foreach($ultimas as $casa)
                            <li class="py-3 flex items-center justify-between">
                                <div class="flex items-center">
                                    @if($casa->imagen_principal)
                                        <img src="{{ asset('storage/' . $casa->imagen_principal) }}" class="h-10 w-10 rounded-full object-cover mr-3">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-xs mr-3">Img</div>
                                    @endif
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $casa->titulo }}</p>
                                        <p class="text-xs text-gray-500">{{ $casa->ciudad }}</p>
                                    </div>
                                </div>
                                <span class="text-sm font-bold text-gray-700">{{ $casa->moneda }} {{ number_format($casa->precio, 0, ',', '.') }}</span>
                            </li>
                            @endforeach
                        </ul>
                        <div class="mt-4 text-right">
                            <a href="{{ route('admin.properties.index') }}" class="text-sm text-blue-600 hover:underline">Ver todas &rarr;</a>
                        </div>
                    @else
                        <p class="text-gray-500 text-sm">Aún no hay propiedades cargadas.</p>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>