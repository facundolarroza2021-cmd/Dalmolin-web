<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Administrar Propiedades') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-700">Listado de Inmuebles</h3>
                        

                        <form action="{{ route('admin.properties.index') }}" method="GET" class="w-full md:w-auto">
                            <div class="relative">
                                <input type="text" 
                                    name="search" 
                                    value="{{ request('search') }}" 
                                    placeholder="Buscar por nombre o ciudad..." 
                                    class="w-full md:w-80 pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700"
                                >
                                <div class="absolute top-0 left-0 h-full flex items-center pl-3 pointer-events-none text-gray-400">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </div>
                                
                                <button type="submit" class="absolute top-0 right-0 h-full px-3 text-blue-600 hover:text-blue-800 font-bold">
                                    Ir
                                </button>
                            </div>
                        </form>

                        <a href="{{ route('admin.properties.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Nueva Propiedad
                        </a>
                    </div>

                    @if(request('search'))
                        <div class="mb-4">
                            <a href="{{ route('admin.properties.index') }}" class="text-sm text-red-500 hover:text-red-700 underline">
                                <i class="fa-solid fa-xmark"></i> Borrar filtro de búsqueda: "{{ request('search') }}"
                            </a>
                        </div>
                    @endif
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Foto
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Info Propiedad
                                </th>
                                {{-- COLUMNA NUEVA: SITUACIÓN --}}
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Situación
                                </th>
                                {{-- COLUMNA MODIFICADA: VISIBILIDAD --}}
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Visibilidad / Destacada
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($propiedades as $propiedad)
                            <tr>
                                {{-- FOTO --}}
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <div class="flex-shrink-0 w-16 h-16 relative">
                                        @if($propiedad->imagen_principal)
                                            <img class="w-full h-full rounded object-cover shadow-sm" src="{{ asset('storage/' . $propiedad->imagen_principal) }}" alt="" />
                                        @else
                                            <div class="w-full h-full bg-gray-200 rounded flex items-center justify-center text-gray-500 text-xs">Sin foto</div>
                                        @endif
                                    </div>
                                </td>

                                {{-- INFO --}}
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 font-bold text-base mb-1">
                                        {{ Str::limit($propiedad->titulo, 30) }}
                                    </p>
                                    <p class="text-gray-600 text-xs mb-1">
                                        <i class="fa-solid fa-location-dot text-red-400"></i> {{ $propiedad->ciudad }} | {{ ucfirst($propiedad->tipo_propiedad) }}
                                    </p>
                                    <p class="font-bold text-blue-600">
                                        {{ $propiedad->moneda }} {{ number_format($propiedad->precio, 0, ',', '.') }}
                                    </p>
                                </td>

                                {{-- NUEVO: SITUACIÓN (Disponible/Vendido/etc) --}}
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                    @php
                                        $estadoClasses = [
                                            'disponible' => 'bg-green-100 text-green-800 border-green-200',
                                            'reservado' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                            'vendido' => 'bg-red-100 text-red-800 border-red-200',
                                            'alquilado' => 'bg-blue-100 text-blue-800 border-blue-200',
                                        ];
                                        $clase = $estadoClasses[$propiedad->estado] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full border {{ $clase }}">
                                        {{ ucfirst($propiedad->estado) }}
                                    </span>
                                </td>

                                {{-- NUEVO: SWITCHES (Publicar / Destacar) --}}
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                    <div class="flex flex-col gap-2 items-center justify-center">
                                        
                                        {{-- Switch Publicada --}}
                                        <form action="{{ route('admin.propiedades.toggle', $propiedad->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="field" value="publicada">
                                            <button type="submit" class="flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold transition-colors w-28 justify-center
                                                {{ $propiedad->publicada ? 'bg-green-100 text-green-700 hover:bg-green-200 border border-green-200' : 'bg-gray-100 text-gray-500 hover:bg-gray-200 border border-gray-200' }}">
                                                <div class="w-2 h-2 rounded-full {{ $propiedad->publicada ? 'bg-green-500 animate-pulse' : 'bg-gray-400' }}"></div>
                                                {{ $propiedad->publicada ? 'Visible' : 'Oculta' }}
                                            </button>
                                        </form>
                                    </div>
                                </td>

                                {{-- ACCIONES --}}
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('admin.properties.edit', $propiedad->id) }}" class="text-gray-500 hover:text-blue-600 transition-colors" title="Editar">
                                            <i class="fa-solid fa-pen-to-square text-lg"></i>
                                        </a>

                                        <form action="{{ route('admin.properties.destroy', $propiedad->id) }}" method="POST" onsubmit="return confirm('¿Borrar definitivamente?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-gray-500 hover:text-red-600 transition-colors" title="Eliminar">
                                                <i class="fa-solid fa-trash text-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $propiedades->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>