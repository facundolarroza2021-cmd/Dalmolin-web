@extends('public.layouts.app')

@section('meta_title', 'Sobre Nosotros | Dalmolin Inmobiliaria')
@section('meta_description', 'Conocé nuestra historia y por qué somos líderes en el mercado inmobiliario de Concordia desde hace más de 15 años.')

@section('contenido')

    {{-- 1. HERO SECTION --}}
    <div class="relative bg-gray-900 py-24 sm:py-32">
        <div class="absolute inset-0 overflow-hidden">
            <img src="{{ asset('img/dalmolin-entrada_LE_upscale_balanced.jpg') }}" alt="Oficina Dalmolin" class="w-full h-full object-cover opacity-20">
        </div>
        <div class="relative max-w-7xl mx-auto px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl mb-6">
                Construyendo confianza <br> <span class="text-red-600">desde hace 15 años</span>
            </h1>
            <p class="text-lg leading-8 text-gray-300 max-w-2xl mx-auto">
                En Dalmolin Inmobiliaria no solo vendemos propiedades; ayudamos a familias y empresas a encontrar su lugar en Concordia con seguridad y transparencia.
            </p>
        </div>
    </div>

    {{-- 2. NUESTRA HISTORIA Y MISIÓN --}}
    <div class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                
                {{-- Texto --}}
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl mb-6">Más que una inmobiliaria, tu socio estratégico</h2>
                    <div class="space-y-6 text-lg text-gray-600">
                        <p>
                            Nuestra historia comienza con una visión clara: profesionalizar el mercado inmobiliario de Concordia ofreciendo un servicio basado en la honestidad y el conocimiento profundo de la zona.
                        </p>
                        <p>
                            A lo largo de los años, hemos gestionado cientos de operaciones exitosas, desde primeras viviendas hasta grandes desarrollos comerciales. Entendemos que cada cliente es único y que detrás de cada operación hay un proyecto de vida o una inversión importante.
                        </p>
                        <p class="font-bold text-gray-900">
                            "Nuestro compromiso es simple: asesorarte como si la inversión fuera nuestra."
                        </p>
                    </div>
                </div>

                {{-- Imagen o Gráfica --}}
                <div class="relative">
                    <div class="aspect-[4/3] rounded-2xl bg-gray-100 overflow-hidden shadow-xl">
                        {{-- Puedes poner una foto de Rodrigo firmando o en la oficina --}}
                        <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=1073&q=80" 
                             alt="Asesoramiento Inmobiliario" class="w-full h-full object-cover">
                    </div>
                    {{-- Stats Flotantes --}}
                    <div class="absolute -bottom-6 -left-6 bg-red-600 text-white p-8 rounded-xl shadow-lg hidden md:block">
                        <p class="text-4xl font-bold">+500</p>
                        <p class="text-sm uppercase tracking-wider mt-1">Operaciones<br>Exitosas</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- 3. POR QUÉ ELEGIRNOS (Valores) --}}
    <div class="bg-gray-50 py-24">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Nuestros Pilares</h2>
                <p class="mt-4 text-lg text-gray-600">Lo que nos diferencia en el mercado.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                {{-- Valor 1 --}}
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 text-center">
                    <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center text-2xl mx-auto mb-6">
                        <i class="fa-solid fa-handshake"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Transparencia Total</h3>
                    <p class="text-gray-600">
                        Sin letras chicas. Te acompañamos en cada paso legal y administrativo para que operes con total tranquilidad.
                    </p>
                </div>

                {{-- Valor 2 --}}
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 text-center">
                    <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center text-2xl mx-auto mb-6">
                        <i class="fa-solid fa-bullseye"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Experiencia Local</h3>
                    <p class="text-gray-600">
                        Conocemos cada barrio de Concordia. Sabemos cuánto vale realmente tu propiedad y dónde están las mejores oportunidades.
                    </p>
                </div>

                {{-- Valor 3 --}}
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 text-center">
                    <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center text-2xl mx-auto mb-6">
                        <i class="fa-solid fa-laptop-house"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Innovación Digital</h3>
                    <p class="text-gray-600">
                        Usamos tecnología de punta, fotografía profesional y marketing digital para que tu propiedad llegue al comprador ideal.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- 4. EL EQUIPO --}}
    <div class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl mb-12">Liderazgo</h2>
            
            <div class="max-w-xs mx-auto">
                <div class="group relative">
                    <div class="aspect-[1/1] overflow-hidden rounded-2xl bg-gray-200">
                        {{-- FOTO DE RODRIGO (Si la tienes, úsala aquí) --}}
                        <img src="{{ asset('img/dalmolin_logo2.png') }}" alt="Rodrigo Dalmolin" class="h-full w-full object-contain object-center group-hover:scale-105 transition duration-500 p-4 bg-gray-50">
                    </div>
                    <div class="mt-6">
                        <h3 class="text-xl font-bold text-gray-900">Rodrigo Dalmolin</h3>
                        <p class="text-red-600 font-medium">Corredor Inmobiliario Mat. Nº 123</p> <p class="mt-4 text-sm text-gray-500">
                            "Mi objetivo es que cada cliente se sienta escuchado y respaldado. La confianza se gana con hechos, no con palabras."
                        </p>
                        
                        {{-- Redes Personales --}}
                        <div class="flex justify-center gap-4 mt-6">
                            <a href="#" class="text-gray-400 hover:text-red-600 transition"><i class="fa-brands fa-linkedin text-xl"></i></a>
                            <a href="#" class="text-gray-400 hover:text-red-600 transition"><i class="fa-brands fa-whatsapp text-xl"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 5. CTA FINAL --}}
    <div class="bg-red-700">
        <div class="px-6 py-24 sm:px-6 sm:py-32 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                    ¿Listo para dar el siguiente paso?
                </h2>
                <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-red-100">
                    Ya sea que quieras vender, comprar o alquilar, estamos listos para asesorarte con la seriedad que mereces.
                </p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <a href="{{ route('public.contacto') }}" class="rounded-md bg-white px-3.5 py-2.5 text-sm font-bold text-red-600 shadow-sm hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white transition">
                        Contactar ahora
                    </a>
                    <a href="https://wa.me/543456256190" target="_blank" class="text-sm font-semibold leading-6 text-white hover:text-red-100">
                        WhatsApp directo <span aria-hidden="true">→</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection