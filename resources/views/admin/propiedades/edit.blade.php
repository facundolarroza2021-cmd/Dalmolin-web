<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Editar Propiedad') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <form action="{{ route('admin.properties.update', $propiedad->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    {{-- COLUMNA IZQUIERDA --}}
                    <div class="lg:col-span-2 space-y-8">
                        
                        {{-- INFO BÁSICA --}}
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                                    <i class="fa-solid fa-pen-to-square text-orange-500"></i> Información
                                </h3>
                                {{-- Link para ver en web --}}
                                <a href="{{ route('public.propiedad.show', $propiedad->slug) }}" target="_blank" class="text-sm text-blue-600 hover:underline">
                                    Ver en web <i class="fa-solid fa-external-link-alt ml-1"></i>
                                </a>
                            </div>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block font-medium text-sm text-gray-700 mb-1">Título</label>
                                    <input type="text" name="titulo" value="{{ old('titulo', $propiedad->titulo) }}" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm" required>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block font-medium text-sm text-gray-700 mb-1">Precio (USD)</label>
                                        <input type="number" name="precio" value="{{ old('precio', $propiedad->precio) }}" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm" required>
                                    </div>
                                    <div>
                                        <label class="block font-medium text-sm text-gray-700 text-green-600 font-bold">
                                            % Descuento (Opcional)
                                        </label>
                                        <div class="relative mt-1">
                                            <input type="number" name="porcentaje_descuento" min="0" max="99" placeholder="Ej: 10" 
                                                class="border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm block w-full pl-3 pr-8">
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">%</span>
                                            </div>
                                        </div>
                                        <p class="text-xs text-gray-400 mt-1">Si pones 10, se mostrará un 10% OFF.</p>
                                    </div>
                                    <div>
                                        <label class="block font-medium text-sm text-gray-700 mb-1">Operación</label>
                                        <select name="tipo_operacion" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm">
                                            <option value="venta" {{ $propiedad->tipo_operacion == 'venta' ? 'selected' : '' }}>Venta</option>
                                            <option value="alquiler" {{ $propiedad->tipo_operacion == 'alquiler' ? 'selected' : '' }}>Alquiler</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label class="block font-medium text-sm text-gray-700 mb-1">Tipo</label>
                                    <select name="tipo_propiedad" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm">
                                        @foreach(['casa', 'departamento', 'terreno', 'local', 'oficina'] as $tipo)
                                            <option value="{{ $tipo }}" {{ $propiedad->tipo_propiedad == $tipo ? 'selected' : '' }}>{{ ucfirst($tipo) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- ESTADO --}}
                                <div class="pt-2">
                                    <label class="block font-medium text-sm text-gray-700 mb-2">Estado Actual</label>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                        @foreach(['disponible' => '🟢 Disponible', 'reservado' => '🟡 Reservado', 'vendido' => '🔴 Vendido', 'alquilado' => '🔵 Alquilado'] as $val => $label)
                                            <label class="cursor-pointer">
                                                <input type="radio" name="estado" value="{{ $val }}" class="peer sr-only" {{ $propiedad->estado == $val ? 'checked' : '' }}>
                                                <div class="text-center py-2 text-sm rounded-md border border-gray-200 bg-gray-50 peer-checked:bg-gray-800 peer-checked:text-white peer-checked:border-gray-800 hover:bg-gray-100 transition">
                                                    {{ $label }}
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- DESCRIPCIÓN --}}
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-align-left text-orange-500"></i> Descripción
                            </h3>
                            <textarea name="descripcion" rows="6" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm">{{ old('descripcion', $propiedad->descripcion) }}</textarea>
                        </div>

                        {{-- FOTOS --}}
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-camera text-orange-500"></i> Gestión de Fotos
                            </h3>
                            
                            {{-- Portada Actual --}}
                            <div class="mb-6">
                                <label class="block font-medium text-sm text-gray-700 mb-2">Portada Actual</label>
                                <div class="flex items-center gap-4">
                                    <div class="w-32 h-20 bg-gray-100 rounded-lg overflow-hidden border border-gray-200">
                                        @if($propiedad->imagen_principal)
                                            <img src="{{ asset('storage/' . $propiedad->imagen_principal) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="flex items-center justify-center h-full text-xs text-gray-400">Sin imagen</div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <label class="block text-xs text-gray-500 mb-1">Cambiar Portada:</label>
                                        <input type="file" name="imagen" class="block w-full text-sm text-gray-500 file:mr-4 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer">
                                    </div>
                                </div>
                            </div>

                            {{-- Galería --}}
                            <div class="border-t border-gray-100 pt-4">
                                <label class="block font-medium text-sm text-gray-700 mb-2">Galería (Agregar nuevas)</label>
                                <input type="file" name="imagenes[]" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 cursor-pointer mb-4">
                                
                                {{-- Lista de fotos existentes --}}
                                @if($propiedad->imagenes->count() > 0)
                                    <p class="text-sm font-bold text-gray-700 mb-2">Fotos en Galería ({{ $propiedad->imagenes->count() }})</p>
                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                        @foreach($propiedad->imagenes as $img)
                                            <div class="relative group rounded-lg overflow-hidden border border-gray-200">
                                                <img src="{{ asset('storage/' . $img->ruta) }}" class="w-full h-24 object-cover">
                                                {{-- Botón Borrar Foto --}}
                                                <a href="{{ route('admin.imagen.destroy', $img->id) }}" 
                                                   onclick="return confirm('¿Borrar esta foto?')"
                                                   class="absolute inset-0 bg-black/50 flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition duration-200">
                                                    <i class="fa-solid fa-trash text-xl"></i>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-400 italic">No hay fotos extra en la galería.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- COLUMNA DERECHA --}}
                    <div class="space-y-8">
                        {{-- CARACTERÍSTICAS --}}
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Detalles</h3>
                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-sm text-gray-600">Habitaciones</label>
                                        <input type="number" name="habitaciones" value="{{ old('habitaciones', $propiedad->habitaciones) }}" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm h-9">
                                    </div>
                                    <div>
                                        <label class="text-sm text-gray-600">Baños</label>
                                        <input type="number" name="banos" value="{{ old('banos', $propiedad->banos) }}" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm h-9">
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-sm text-gray-600">Cocheras</label>
                                        <input type="number" name="cocheras" value="{{ old('cocheras', $propiedad->cocheras) }}" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm h-9">
                                    </div>
                                    <div>
                                        <label class="text-sm text-gray-600">M² Totales</label>
                                        <input type="number" name="superficie_total" value="{{ old('superficie_total', $propiedad->superficie_total) }}" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm h-9">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- UBICACIÓN --}}
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Ubicación</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block font-medium text-sm text-gray-700 mb-1">Ciudad</label>
                                    <input type="text" name="ciudad" value="{{ old('ciudad', $propiedad->ciudad) }}" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm" required>
                                </div>
                                <div>
                                    <label class="block font-medium text-sm text-gray-700 mb-1">Dirección</label>
                                    <input type="text" name="direccion" value="{{ old('direccion', $propiedad->direccion) }}" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm">
                                </div>
                            </div>
                        </div>

                        {{-- BOTONES --}}
                        <div class="flex flex-col gap-3 sticky top-6">
                            <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white font-bold py-3 px-4 rounded-lg shadow-md transition flex justify-center items-center gap-2">
                                <i class="fa-solid fa-save"></i> Actualizar Cambios
                            </button>
                            <a href="{{ route('admin.properties.index') }}" class="w-full bg-white hover:bg-gray-50 text-gray-700 font-medium py-3 px-4 rounded-lg border border-gray-300 text-center transition">
                                Cancelar
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>