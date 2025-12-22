<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nueva Propiedad') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('admin.properties.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Título de la publicación</label>
                            <input type="text" name="titulo" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" placeholder="Ej: Casa Quinta en el Lago" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Precio (USD)</label>
                                <input type="number" name="precio" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                            </div>
                            
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Operación</label>
                                <select name="tipo_operacion" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1">
                                    <option value="venta">Venta</option>
                                    <option value="alquiler">Alquiler</option>
                                    <option value="temporal">Alquiler Temporal</option>
                                </select>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700">Tipo Inmueble</label>
                                <select name="tipo_propiedad" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1">
                                    <option value="casa">Casa</option>
                                    <option value="departamento">Departamento</option>
                                    <option value="terreno">Quinta</option>
                                    <option value="local">Terreno</option>
                                    <option value="oficina">Campo</option>
                                    <option value="garage">Cochera</option>
                                    <option value="bodega">Fondo de comercio</option>
                                    <option value="otro">Galpon</option>
                                    <option value="otro">Local</option>
                                    <option value="otro">Edificio</option>
                                    <option value="otro">Hotel</option>
                                </select>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h3 class="text-md font-bold text-gray-700 mb-3">Características</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div>
                                    <label class="block font-medium text-sm text-gray-700">Habitaciones</label>
                                    <input type="number" name="habitaciones" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" placeholder="0">
                                </div>
                                <div>
                                    <label class="block font-medium text-sm text-gray-700">Baños</label>
                                    <input type="number" name="banos" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" placeholder="0">
                                </div>
                                <div>
                                    <label class="block font-medium text-sm text-gray-700">Cocheras</label>
                                    <input type="number" name="cocheras" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" placeholder="0">
                                </div>
                                <div>
                                    <label class="block font-medium text-sm text-gray-700">Sup. Total (m²)</label>
                                    <input type="number" name="superficie_total" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" placeholder="Ej: 300">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Dirección</label>
                                <input type="text" name="direccion" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" placeholder="Ej: San Martín 123">
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Ciudad</label>
                                <input type="text" name="ciudad" value="Concordia" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1">
                            </div>
                        </div>

                        <div class="bg-indigo-50 p-4 rounded-lg border border-indigo-100 space-y-4">
                            <h3 class="text-md font-bold text-indigo-800 mb-3">Imágenes de la Propiedad</h3>
                            
                            <div>
                                <label class="block font-bold text-sm text-gray-700">
                                    Foto de Portada (Principal) <span class="text-red-500">*</span>
                                </label>
                                <p class="text-xs text-gray-500 mb-2">Esta es la imagen que se verá en Google y Redes Sociales.</p>
                                <input type="file" name="imagen" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-500 file:text-white hover:file:bg-indigo-600 cursor-pointer" accept="image/*">
                            </div>

                            <hr class="border-indigo-200">

                            <div>
                                <label class="block font-bold text-sm text-gray-700">
                                    Galería de Fotos (Adicionales)
                                </label>
                                <p class="text-xs text-gray-500 mb-2">Puedes seleccionar varias fotos a la vez (Ctrl + Click).</p>
                                <input type="file" name="imagenes[]" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-500 file:text-white hover:file:bg-gray-600 cursor-pointer" accept="image/*">
                            </div>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Descripción completa</label>
                            <textarea name="descripcion" rows="4" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" placeholder="Describe la propiedad..."></textarea>
                        </div>

                        <div class="flex justify-end gap-3">
                            <a href="{{ route('admin.properties.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
                                Cancelar
                            </a>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition font-bold shadow-md">
                                Guardar Propiedad
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>