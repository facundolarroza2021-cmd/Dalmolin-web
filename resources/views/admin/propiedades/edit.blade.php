<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Propiedad') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('admin.properties.update', $propiedad->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Título</label>
                            <input type="text" name="titulo" value="{{ old('titulo', $propiedad->titulo) }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Precio (USD)</label>
                                <input type="number" name="precio" value="{{ old('precio', $propiedad->precio) }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Operación</label>
                                <select name="tipo_operacion" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1">
                                    <option value="venta" {{ $propiedad->tipo_operacion == 'venta' ? 'selected' : '' }}>Venta</option>
                                    <option value="alquiler" {{ $propiedad->tipo_operacion == 'alquiler' ? 'selected' : '' }}>Alquiler</option>
                                    <option value="temporal" {{ $propiedad->tipo_operacion == 'temporal' ? 'selected' : '' }}>Alquiler Temporal</option>
                                </select>
                            </div>
                            <div class="mb-4 bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Estado de la Propiedad</label>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    
                                    <label class="cursor-pointer">
                                        <input type="radio" name="estado" value="disponible" class="peer sr-only" {{ $propiedad->estado == 'disponible' ? 'checked' : '' }}>
                                        <div class="text-center py-2 rounded-md border border-gray-300 peer-checked:bg-green-600 peer-checked:text-white peer-checked:border-green-600 hover:bg-gray-100 transition">
                                            🟢 Disponible
                                        </div>
                                    </label>

                                    <label class="cursor-pointer">
                                        <input type="radio" name="estado" value="reservado" class="peer sr-only" {{ $propiedad->estado == 'reservado' ? 'checked' : '' }}>
                                        <div class="text-center py-2 rounded-md border border-gray-300 peer-checked:bg-yellow-500 peer-checked:text-white peer-checked:border-yellow-500 hover:bg-gray-100 transition">
                                            🟡 Reservado
                                        </div>
                                    </label>

                                    <label class="cursor-pointer">
                                        <input type="radio" name="estado" value="vendido" class="peer sr-only" {{ $propiedad->estado == 'vendido' ? 'checked' : '' }}>
                                        <div class="text-center py-2 rounded-md border border-gray-300 peer-checked:bg-red-600 peer-checked:text-white peer-checked:border-red-600 hover:bg-gray-100 transition">
                                            🔴 Vendido
                                        </div>
                                    </label>
                                    
                                    <label class="cursor-pointer">
                                        <input type="radio" name="estado" value="alquilado" class="peer sr-only" {{ $propiedad->estado == 'alquilado' ? 'checked' : '' }}>
                                        <div class="text-center py-2 rounded-md border border-gray-300 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 hover:bg-gray-100 transition">
                                            🔵 Alquilado
                                        </div>
                                    </label>

                                </div>
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Tipo Inmueble</label>
                                <select name="tipo_propiedad" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1">
                                    <option value="casa" {{ $propiedad->tipo_propiedad == 'casa' ? 'selected' : '' }}>Casa</option>
                                    <option value="departamento" {{ $propiedad->tipo_propiedad == 'departamento' ? 'selected' : '' }}>Departamento</option>
                                    <option value="terreno" {{ $propiedad->tipo_propiedad == 'quinta' ? 'selected' : '' }}>Quinta</option>
                                    <option value="local" {{ $propiedad->tipo_propiedad == 'terreno' ? 'selected' : '' }}>Terreno</option>
                                    <option value="garage" {{ $propiedad->tipo_propiedad == 'campo' ? 'selected' : '' }}>Campo</option>
                                    <option value="bodega" {{ $propiedad->tipo_propiedad == 'cochera' ? 'selected' : '' }}>Cochera</option>
                                    <option value="oficina" {{ $propiedad->tipo_propiedad == 'fondo de comercio' ? 'selected' : '' }}>Fondo de Comercio</option>
                                    <option value="hotel" {{ $propiedad->tipo_propiedad == 'galpon' ? 'selected' : '' }}>Galpon</option>
                                    <option value="otro" {{ $propiedad->tipo_propiedad == 'local' ? 'selected' : '' }}>Local</option>
                                    <option value="otro" {{ $propiedad->tipo_propiedad == 'edificio' ? 'selected' : '' }}>Edificio</option>
                                    <option value="otro" {{ $propiedad->tipo_propiedad == 'hotel' ? 'selected' : '' }}>Hotel</option>
                                </select>
                            </div>
                            <div class="ml-6 flex items-center gap-2">
                                <input type="checkbox" name="destacada" value="1" {{ old('destacada', $propiedad->destacada ?? false) ? 'checked' : '' }} class="rounded border-gray-300 text-yellow-500 shadow-sm focus:ring-yellow-500">
                               <label class="font-bold text-gray-700">⭐ Destacar en Inicio</label>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Administrar Imágenes</h3>

                            <div class="mb-6">
                                <label class="block font-bold text-sm text-gray-700 mb-2">Foto de Portada Actual</label>
                                <div class="flex items-center gap-4">
                                    @if($propiedad->imagen_principal)
                                        <img src="{{ asset('storage/' . $propiedad->imagen_principal) }}" class="w-32 h-20 object-cover rounded shadow-sm border">
                                    @else
                                        <div class="w-32 h-20 bg-gray-200 flex items-center justify-center rounded text-xs text-gray-500">Sin portada</div>
                                    @endif
                                    
                                    <div class="flex-1">
                                        <label class="text-xs text-gray-500">Cambiar Portada:</label>
                                        <input type="file" name="imagen" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 mt-1">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="block font-bold text-sm text-gray-700 mb-2">Galería ({{ $propiedad->imagenes->count() }} fotos)</label>
                                
                                @if($propiedad->imagenes->count() > 0)
                                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-4">
                                    @foreach($propiedad->imagenes as $img)
                                    <div class="relative group">
                                        <img src="{{ asset('storage/' . $img->ruta) }}" class="w-full h-24 object-cover rounded shadow border">
                                        
                                        <button type="button" 
                                            onclick="if(confirm('¿Seguro que deseas eliminar esta imagen?')) { 
                                                var form = document.getElementById('deleteImageForm');
                                                form.action = '{{ route('admin.imagen.delete', $img->id) }}';
                                                form.submit();
                                            }" 
                                            class="absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition shadow-md hover:bg-red-700" 
                                            title="Borrar foto">
                                            ✕
                                        </button>
                                    </div>
                                    @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500 italic mb-4">No hay fotos extra en la galería.</p>
                                @endif

                                <label class="text-xs text-gray-500 font-bold">Agregar más fotos a la galería:</label>
                                <input type="file" name="imagenes[]" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 mt-1">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Ciudad</label>
                                <input type="text" name="ciudad" value="{{ old('ciudad', $propiedad->ciudad) }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1">
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Dirección</label>
                                <input type="text" name="direccion" value="{{ old('direccion', $propiedad->direccion) }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1">
                            </div>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Descripción</label>
                            <textarea name="descripcion" rows="4" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1">{{ old('descripcion', $propiedad->descripcion) }}</textarea>
                        </div>

                        <div class="flex justify-end gap-3">
                            <a href="{{ route('admin.properties.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">Cancelar</a>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition font-bold shadow-md">
                                Guardar Cambios
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- Formulario oculto reutilizable para borrar imágenes --}}
    <form id="deleteImageForm" action="" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</x-app-layout>