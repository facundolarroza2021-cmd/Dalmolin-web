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
                        
                        <a href="{{ route('admin.properties.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Nueva Propiedad
                        </a>
                    </div>
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Foto
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Título / Ubicación
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Precio
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($propiedades as $propiedad)
                            <tr>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <div class="flex-shrink-0 w-16 h-16">
                                        @if($propiedad->imagen_principal)
                                            <img class="w-full h-full rounded object-cover" src="{{ asset('storage/' . $propiedad->imagen_principal) }}" alt="" />
                                        @else
                                            <div class="w-full h-full bg-gray-200 rounded flex items-center justify-center text-gray-500 text-xs">Sin foto</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap font-bold">
                                        {{ $propiedad->titulo }}
                                    </p>
                                    <p class="text-gray-600 whitespace-no-wrap text-xs">
                                        {{ $propiedad->ciudad }} - {{ ucfirst($propiedad->tipo_propiedad) }}
                                    </p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        {{ $propiedad->moneda }} {{ number_format($propiedad->precio, 0, ',', '.') }}
                                    </p>
                                    <p class="text-xs text-gray-500">{{ ucfirst($propiedad->tipo_operacion) }}</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                        <span class="relative">{{ $propiedad->publicada ? 'Publicada' : 'Borrador' }}</span>
                                    </span>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('public.propiedad.show', $propiedad->slug) }}" target="_blank" class="text-blue-600 hover:text-blue-900" title="Ver en web">
                                            🔍
                                        </a>
                                        <a href="{{ route('admin.properties.edit', $propiedad->id) }}" class="text-orange-600 hover:text-orange-900 font-bold">
                                            Editar
                                        </a>

                                        <form action="{{ route('admin.properties.destroy', $propiedad->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de borrar esta propiedad?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 ml-2">
                                                🗑️
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