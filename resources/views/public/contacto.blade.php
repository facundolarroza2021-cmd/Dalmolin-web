@extends('public.layouts.app')

@section('meta_title', 'Contacto | Dalmolin Inmobiliaria')
@section('meta_description', 'Comunicate con nosotros. Estamos en Concordia para asesorarte en la compra, venta o alquiler de tu propiedad.')

@section('contenido')

    {{-- 1. HERO HEADER (Encabezado Simple) --}}

    </div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
            
            {{-- 2. INFORMACIÓN DE CONTACTO (Columna Izquierda) --}}
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Información de Contacto</h2>
                <p class="text-gray-600 mb-8">
                    Podes visitarnos en nuestra oficina, llamarnos o escribirnos. Nuestro equipo te responderá a la brevedad.
                </p>

                <div class="space-y-8">
                    {{-- Dirección --}}
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-red-100 text-red-600 rounded-lg flex items-center justify-center text-xl">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Nuestra Oficina</h3>
                            <p class="text-gray-600">La Rioja Nº 654</p>
                            <p class="text-gray-600">Concordia, Entre Ríos (CP 3200)</p>
                        </div>
                    </div>

                    {{-- Teléfono --}}
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-red-100 text-red-600 rounded-lg flex items-center justify-center text-xl">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Llamanos</h3>
                            <p class="text-gray-600">Teléfono Fijo: +54 345 421 9999</p> {{-- Ajustar si tienes fijo --}}
                            <p class="text-gray-600">Móvil / WhatsApp: +54 345 625 6190</p>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-red-100 text-red-600 rounded-lg flex items-center justify-center text-xl">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Email</h3>
                            <a href="mailto:dalmolinnegociosinmobiliarios@gmail.com" class="text-red-600 hover:text-red-700 font-medium">
                                dalmolinnegociosinmobiliarios@gmail.com
                            </a>
                        </div>
                    </div>

                    {{-- Horarios --}}
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-red-100 text-red-600 rounded-lg flex items-center justify-center text-xl">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Horarios de Atención</h3>
                            <p class="text-gray-600">Lunes a Viernes: 8:00 - 12:00 | 16:00 - 20:00</p>
                            <p class="text-gray-600">Sábados: 9:00 - 12:30</p>
                        </div>
                    </div>
                </div>

                {{-- Redes Sociales --}}
                <div class="mt-10">
                    <h3 class="font-bold text-gray-900 mb-4">Seguinos en redes</h3>
                    <div class="flex gap-4">
                        <a href="https://www.facebook.com/rd.inmo" target="_blank" class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                        <a href="https://www.instagram.com/dalmolin_inmobiliaria/" target="_blank" class="w-10 h-10 bg-pink-600 text-white rounded-full flex items-center justify-center hover:bg-pink-700 transition">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="https://wa.me/543456256190" target="_blank" class="w-10 h-10 bg-green-500 text-white rounded-full flex items-center justify-center hover:bg-green-600 transition">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- 3. FORMULARIO DE CONTACTO (Columna Derecha) --}}
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Envianos un mensaje</h2>
                <p class="text-gray-600 mb-6 text-sm">Completá el formulario y te contactaremos a la brevedad.</p>

                {{-- NOTA: Aquí va la ruta para procesar el form. Por ahora lo dejamos sin action o apuntando a mismo lugar --}}
                <form action="#" method="POST" class="space-y-4">
                    @csrf 
                    
                    {{-- Nombre --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre y Apellido</label>
                        <input type="text" name="nombre" class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 shadow-sm" placeholder="Tu nombre" required>
                    </div>

                    {{-- Teléfono y Email --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono / WhatsApp</label>
                            <input type="tel" name="telefono" class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 shadow-sm" placeholder="Ej: 345..." required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 shadow-sm" placeholder="tu@email.com" required>
                        </div>
                    </div>

                    {{-- Asunto --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Asunto</label>
                        <select name="asunto" class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 shadow-sm">
                            <option value="consulta">Consulta General</option>
                            <option value="venta">Quiero Vender mi propiedad</option>
                            <option value="alquiler">Busco Alquiler</option>
                            <option value="tasacion">Solicitar Tasación</option>
                        </select>
                    </div>

                    {{-- Mensaje --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mensaje</label>
                        <textarea name="mensaje" rows="4" class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 shadow-sm" placeholder="¿En qué podemos ayudarte?" required></textarea>
                    </div>

                    <button type="submit" class="w-full bg-red-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-red-700 transition shadow-md flex justify-center items-center gap-2">
                        <span>Enviar Mensaje</span>
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- 4. MAPA DE UBICACIÓN (Google Maps Embed) --}}
    <div class="w-full h-96 bg-gray-200">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3399.999999999999!2d-58.01999999999999!3d-31.39299999999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzHCsDIzJzM0LjgiUyA1OMKwMDEnMTIuMCJX!5e0!3m2!1ses!2sar!4v1600000000000!5m2!1ses!2sar" 
            width="100%" 
            height="100%" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
        {{-- NOTA: He puesto coordenadas genéricas de Concordia. 
             Lo ideal es que busques "Inmobiliaria Dalmolin" en Google Maps, 
             le des a "Compartir" -> "Insertar mapa" y copies ese link exacto aquí. --}}
    </div>

@endsection