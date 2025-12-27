<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Nueva Propiedad') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            
            <form action="{{ route('admin.properties.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    {{-- === COLUMNA IZQUIERDA (Principal) === --}}
                    <div class="lg:col-span-2 space-y-6">
                        
                        {{-- 1. TARJETA DE INFORMACIÓN BÁSICA --}}
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class=" px-6 py-4 border-b ">
                                <h3 class="text-black font-bold text-lg flex items-center gap-2">
                                     Información Principal
                                </h3>
                            </div>
                            
                            <div class="p-6 space-y-6">
                                {{-- Título --}}
                                <div>
                                    <label class="block font-bold text-sm text-gray-700 mb-2">Título del Anuncio</label>
                                    <input type="text" name="titulo" value="{{ old('titulo') }}" 
                                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm text-lg" 
                                           placeholder="Ej: Casa moderna con piscina en zona norte" required>
                                </div>

                                {{-- Precio y Operación --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block font-bold text-sm text-gray-700 mb-2">Precio (USD)</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 font-bold">$</span>
                                            </div>
                                            <input type="number" name="precio" value="{{ old('precio') }}" 
                                                   class="w-full pl-8 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm font-bold text-gray-700" 
                                                   placeholder="0.00" required>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block font-bold text-sm text-gray-700 mb-2">Tipo de Operación</label>
                                        <select name="tipo_operacion" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                                            <option value="venta">Venta</option>
                                            <option value="alquiler">Alquiler</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Tipo de Inmueble (Lista Completa) --}}
                                <div>
                                    <label class="block font-bold text-sm text-gray-700 mb-2">Tipo de Inmueble</label>
                                    <div class="relative">
                                        <i class="fa-solid fa-building absolute left-3 top-3 text-gray-400"></i>
                                        <select name="tipo_propiedad" class="w-full pl-10 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                                            <option value="casa">Casa</option>
                                            <option value="departamento">Departamento</option>
                                            <option value="terreno">Terreno</option>
                                            <option value="local">Local Comercial</option>
                                            <option value="oficina">Oficina</option>
                                            <option value="galpon">Galpón / Depósito</option>
                                            <option value="campo">Campo / Chacra</option>
                                            <option value="cochera">Cochera</option>
                                            <option value="edificio">Edificio</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Estado (Selector Visual) --}}
                                <div>
                                    <label class="block font-bold text-sm text-gray-700 mb-3">Estado Inicial</label>
                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                        @foreach(['disponible' => '🟢 Disponible', 'reservado' => '🟡 Reservado', 'vendido' => '🔴 Vendido', 'alquilado' => '🔵 Alquilado'] as $val => $label)
                                            <label class="cursor-pointer relative">
                                                <input type="radio" name="estado" value="{{ $val }}" class="peer sr-only" {{ $val == 'disponible' ? 'checked' : '' }}>
                                                <div class="w-full text-center py-2 px-1 text-sm font-medium rounded-lg border border-gray-200 bg-gray-50 text-gray-600 hover:bg-gray-100 peer-checked:bg-gray-900 peer-checked:text-white peer-checked:border-gray-900 peer-checked:shadow-md transition-all">
                                                    {{ $label }}
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 2. TARJETA DE DESCRIPCIÓN --}}
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-gray-800 font-bold text-lg mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-align-left text-blue-600"></i> Descripción
                            </h3>
                            <textarea name="descripcion" rows="6" 
                                      class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm" 
                                      placeholder="Describe los detalles más atractivos de la propiedad...">{{ old('descripcion') }}</textarea>
                            <p class="text-xs text-gray-500 mt-2 text-right">Se recomienda escribir al menos 2 párrafos.</p>
                        </div>

                        {{-- 3. TARJETA MULTIMEDIA --}}
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-gray-800 font-bold text-lg mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-images text-blue-600"></i> Multimedia
                            </h3>
                            
                            <div class="space-y-6">
                                {{-- Portada --}}
                                <div class="bg-blue-50 border border-blue-100 rounded-lg p-4">
                                    <label class="block font-bold text-sm text-blue-800 mb-2">
                                        <i class="fa-solid fa-star text-yellow-500 mr-1"></i> Foto de Portada (Obligatoria)
                                    </label>
                                    <input type="file" name="imagen" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer" accept="image/*" required>
                                </div>

                                {{-- Galería --}}
                                <div class="border-t border-gray-100 pt-4">
                                    <label class="block font-bold text-sm text-gray-700 mb-2">Galería de Fotos (Opcional)</label>
                                    <input type="file" name="imagenes[]" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 cursor-pointer" accept="image/*">
                                    <p class="text-xs text-gray-500 mt-2">
                                        <i class="fa-solid fa-circle-info"></i> Puedes seleccionar varios archivos a la vez presionando la tecla <strong>Ctrl</strong> (o Cmd en Mac).
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- === COLUMNA DERECHA (Lateral) === --}}
                    <div class="space-y-6">
                        
                        {{-- 4. TARJETA DETALLES --}}
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-gray-800 font-bold text-lg mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-ruler-combined text-blue-600"></i> Características
                            </h3>
                            
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <label class="text-sm text-gray-600 font-medium"><i class="fa-solid fa-bed w-6 text-center"></i> Dormitorios</label>
                                    <input type="number" name="habitaciones" class="w-20 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm text-center" placeholder="0">
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <label class="text-sm text-gray-600 font-medium"><i class="fa-solid fa-bath w-6 text-center"></i> Baños</label>
                                    <input type="number" name="banos" class="w-20 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm text-center" placeholder="0">
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <label class="text-sm text-gray-600 font-medium"><i class="fa-solid fa-car w-6 text-center"></i> Cocheras</label>
                                    <input type="number" name="cocheras" class="w-20 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm text-center" placeholder="0">
                                </div>

                                <hr class="border-gray-100">
                                
                                <div>
                                    <label class="text-sm text-gray-600 font-medium block mb-1">Superficie Total (m²)</label>
                                    <input type="number" name="superficie_total" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm" placeholder="Ej: 150">
                                </div>
                            </div>
                        </div>

                        {{-- 5. TARJETA UBICACIÓN --}}
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-gray-800 font-bold text-lg mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-map-location-dot text-blue-600"></i> Ubicación
                            </h3>
                            
                            <div class="space-y-3">
                                <div>
                                    <label class="block font-bold text-xs text-gray-500 uppercase tracking-wider mb-1">Ciudad</label>
                                    <input type="text" name="ciudad" value="{{ old('ciudad') }}" 
                                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm" required>
                                </div>
                                <div>
                                    <label class="block font-bold text-xs text-gray-500 uppercase tracking-wider mb-1">Dirección Exacta</label>
                                    <input type="text" name="direccion" value="{{ old('direccion') }}" 
                                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                                </div>
                            </div>
                        </div>

                        {{-- BOTONES DE ACCIÓN (Pegajosos) --}}
                        <div class="sticky top-6 bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 px-4 rounded-lg shadow-lg transform active:scale-95 transition-all flex justify-center items-center gap-2 mb-3">
                                <i class="fa-solid fa-save"></i> GUARDAR PROPIEDAD
                            </button>
                            
                            <a href="{{ route('admin.properties.index') }}" class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold py-3 px-4 rounded-lg text-center transition">
                                Cancelar
                            </a>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>