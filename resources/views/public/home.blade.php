@extends('public.layouts.app')

@section('contenido')

{{-- LIBRERÍAS DE SWIPER (Para el Hero) Y LEAFLET (Para el Mapa) --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />

{{-- =============================================================== --}}
{{-- 1. ESTILOS GENERALES --}}
{{-- =============================================================== --}}
<style>
    :root {
      --dalmolin-red: #c41e3a;
      --dalmolin-red-dark: #9a1829;
    }

    /* --- HERO --- */
    .hero-split-section { background-color: #ffffff; position: relative; width: 100%; height: 90vh; min-height: 650px; display: flex; align-items: center; overflow: hidden; }
    .hero-swiper { width: 100%; height: 100%; }
    .swiper-slide { background: white; display: flex; align-items: center; justify-content: center; }
    .hero-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; width: 100%; max-width: 1280px; padding: 0 2rem; align-items: center; height: 100%; }
    .hero-text-col { z-index: 10; text-align: left; }
    .hero-badge-pill { display: inline-block; background: rgba(235, 37, 37, 0.15); color: rgb(235, 37, 37); font-weight: 700; font-size: 0.85rem; padding: 8px 16px; border-radius: 50px; margin-bottom: 25px; text-transform: uppercase; letter-spacing: 0.5px; border: 2px solid rgba(235, 37, 37, 0.3); backdrop-filter: blur(10px); }
    .hero-title { font-size: 3.5rem; font-weight: 800; color: #111827; line-height: 1.1; margin-bottom: 25px; opacity: 0; transform: translateY(30px); transition: all 0.8s ease; }
    .hero-subtitle { font-size: 1.25rem; color: #6b7280; margin-bottom: 40px; line-height: 1.6; max-width: 90%; opacity: 0; transform: translateY(30px); transition: all 0.8s ease 0.2s; }
    .hero-btn { display: inline-flex; align-items: center; gap: 10px; padding: 16px 40px; background-color: rgb(235, 37, 37); color: white; font-weight: bold; border-radius: 12px; text-decoration: none; transition: all 0.3s; box-shadow: 0 10px 20px -5px rgba(235, 37, 37, 0.3); opacity: 0; transform: translateY(30px); transition: opacity 0.8s ease 0.4s, transform 0.8s ease 0.4s, background 0.3s, box-shadow 0.3s; }
    .hero-btn:hover { background-color: rgb(187, 0, 0); box-shadow: 0 15px 25px -5px rgba(235, 37, 37, 0.4); transform: translateY(-2px); }
    .hero-img-col { position: relative; height: 80%; display: flex; align-items: center; justify-content: center; }
    .hero-img-wrapper { position: relative; width: 100%; height: 550px; border-radius: 30px; overflow: hidden; box-shadow: 20px 20px 60px rgba(0,0,0,0.1); transform: scale(0.95); opacity: 0; transition: all 1s ease 0.2s; }
    .hero-img-wrapper::after { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, rgba(0, 0, 0, 0.4) 0%, rgba(185, 28, 28, 0.3) 50%, rgba(0, 0, 0, 0.5) 100%); z-index: 1; transition: opacity 0.4s ease; }
    .hero-img-wrapper:hover::after { opacity: 0.9; }
    .hero-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; }
    .hero-img-badge { position: absolute; top: 25px; left: 25px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); padding: 12px 20px; border-radius: 12px; font-size: 13px; font-weight: 700; color: rgb(235, 37, 37); z-index: 2; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); display: flex; align-items: center; gap: 8px; }
    .swiper-slide-active .hero-title, .swiper-slide-active .hero-subtitle, .swiper-slide-active .hero-btn { opacity: 1; transform: translateY(0); }
    .swiper-slide-active .hero-img-wrapper { opacity: 1; transform: scale(1); }
    .swiper-pagination-bullet { background: #cbd5e1 !important; width: 12px; height: 12px; opacity: 1; transition: all 0.3s; }
    .swiper-pagination-bullet-active { background: rgb(235, 37, 37) !important; width: 30px; border-radius: 6px; }

    /* --- COMPARADOR --- */
    .comparador-section { padding: 80px 20px; background: white; }
    .comparador-grid { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(3, 1fr); gap: 2px; background: #e5e7eb; border: 2px solid #e5e7eb; border-radius: 20px; overflow: hidden; }
    .comparador-item { background: white; padding: 40px 24px; text-align: center; display: flex; flex-direction: column; align-items: center; }
    .comparador-item.featured { background: linear-gradient(180deg, #fef2f2 0%, #ffffff 100%); position: relative; }
    .comparador-item.featured::before { content: 'POPULAR'; position: absolute; top: 16px; left: 50%; transform: translateX(-50%); background: #dc2626; color: white; padding: 4px 16px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; }
    .comparador-icon { width: 80px; height: 80px; margin: 0 auto 20px; background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: #dc2626; }
    .comparador-item h3 { font-size: 1.5rem; font-weight: 700; color: #111827; margin-bottom: 16px; }
    .comparador-features { list-style: none; padding: 0; margin: 24px 0; width: 100%; }
    .comparador-features li { padding: 12px 0; color: #6b7280; border-bottom: 1px solid #f3f4f6; font-size: 0.95rem; }
    .comparador-features li:last-child { border-bottom: none; }

    /* --- MAPA --- */
/* --- MAPA (Actualizado) --- */
    .mapa-section { padding: 80px 20px; background: #f9fafb; }
    
    /* Cambiamos la proporción: El mapa ocupa más espacio (2.5) y el texto menos (1) */
    .mapa-grid { 
        max-width: 1200px; 
        margin: 0 auto; 
        display: grid; 
        grid-template-columns: 2.5fr 1fr; /* Mapa más ancho */
        gap: 50px; 
        align-items: center; 
    }

    /* Contenedor del Texto Lateral */
    .mapa-info-side {
        padding-left: 10px;
    }
    .mapa-info-side h3 {
        font-size: 2rem;
        font-weight: 800;
        color: #111827;
        margin-bottom: 20px;
        line-height: 1.1;
    }
    .mapa-info-side p {
        font-size: 1.05rem;
        color: #6b7280;
        margin-bottom: 30px;
        line-height: 1.6;
    }

    /* Ajustes Leaflet */
    .leaflet-popup-content-wrapper { border-radius: 10px; overflow: hidden; padding: 0; }
    .leaflet-popup-content { margin: 0; width: 200px !important; }
    .marker-cluster-small { background-color: rgba(220, 38, 38, 0.6); } 
    .marker-cluster-small div { background-color: rgba(185, 28, 28, 0.8); color: white; }

    @media (max-width: 1024px) {
        .mapa-grid { grid-template-columns: 1fr; gap: 30px; }
        .mapa-info-side { text-align: center; padding-left: 0; order: -1; margin-bottom: 20px; } /* Texto arriba en móvil */
    }
    /* --- TIMELINE --- */
    .timeline-section { padding: 80px 20px; background: linear-gradient(180deg, #ffffff 0%, #f9fafb 100%); }
    .section-header { text-align: center; max-width: 700px; margin: 0 auto 60px; }
    .section-header h2 { font-size: 2.5rem; font-weight: 700; color: #111827; margin-bottom: 16px; }
    .section-header p { font-size: 1.1rem; color: #6b7280; }
    .timeline-container { max-width: 1200px; margin: 0 auto; position: relative; }
    .timeline-line { position: absolute; left: 50%; transform: translateX(-50%); width: 4px; height: 100%; background: linear-gradient(180deg, #dc2626 0%, #fca5a5 100%); z-index: 0; }
    .timeline-step { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; margin-bottom: 60px; position: relative; }
    .timeline-step:nth-child(even) .step-content:first-child { order: 2; }
    .timeline-step:nth-child(even) .step-number-container { order: 1; }
    .step-content { background: white; padding: 32px; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 2px solid #f3f4f6; position: relative; z-index: 10; }
    .step-number-container { display: flex; align-items: center; justify-content: center; }
    .step-number { width: 80px; height: 80px; background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem; font-weight: 700; box-shadow: 0 10px 20px rgba(220, 38, 38, 0.3); position: relative; z-index: 1; }

    /* --- FAQ & CTA --- */
    .faq-section { padding: 80px 20px; background: white; }
    .faq-container { max-width: 800px; margin: 0 auto; }
    .faq-item { background: white; border: 2px solid #e5e7eb; border-radius: 12px; margin-bottom: 16px; overflow: hidden; }
    .faq-question { padding: 24px; cursor: pointer; display: flex; justify-content: space-between; align-items: center; font-size: 1.125rem; font-weight: 600; color: #111827; }
    .faq-question i { color: #dc2626; transition: transform 0.3s; }
    .faq-item.active .faq-question i { transform: rotate(180deg); }
    .faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.3s ease; }
    .faq-item.active .faq-answer { max-height: 500px; }
    .faq-answer-content { padding: 0 24px 24px; color: #6b7280; line-height: 1.6; }

    .cta-split { max-width: 1400px; margin: 80px auto; display: grid; grid-template-columns: 1fr 1fr; gap: 24px; padding: 0 20px; }
    .cta-card { background: linear-gradient(135deg, #1e293b 0%, #334155 100%); padding: 60px 40px; border-radius: 20px; color: white; position: relative; overflow: hidden; display: flex; flex-direction: column; justify-content: center; }
    .cta-card::before { content: ''; position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); }
    .cta-card.red { background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%); }
    .cta-card h3 { font-size: 2rem; font-weight: 700; margin-bottom: 16px; position: relative; z-index: 1; }
    .cta-card p { font-size: 1.1rem; margin-bottom: 32px; opacity: 0.9; position: relative; z-index: 1; }
    .cta-button { display: inline-flex; align-items: center; justify-content: center; gap: 10px; padding: 14px 32px; background: white; color: #111827; font-weight: 600; border-radius: 10px; text-decoration: none; position: relative; z-index: 1; transition: transform 0.2s; width: fit-content; }
    .cta-button:hover { transform: scale(1.05); }
    .cta-card.red .cta-button { color: #dc2626; }

    @media (max-width: 1024px) {
        .hero-grid, .comparador-grid, .mapa-grid, .cta-split { grid-template-columns: 1fr; }
        .hero-img-col, .timeline-line { display: none; }
        .comparador-grid { background: transparent; border: none; gap: 20px; }
        .comparador-item { border: 2px solid #e5e7eb; border-radius: 20px; }
        .timeline-step { grid-template-columns: 1fr !important; gap: 20px; }
        .step-number-container { order: -1 !important; margin-bottom: 20px; }
    }
</style>


{{-- =============================================================== --}}
{{-- 2. SECCIÓN HERO --}}
{{-- =============================================================== --}}
<section class="hero-split-section">
    <div class="swiper hero-swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="hero-grid">
                    <div class="hero-text-col">
                        <span class="hero-badge-pill">
                            <i class="fa-solid fa-medal"></i> Líderes en Concordia
                        </span>
                        <h1 class="hero-title">Encontrá el lugar <br><span style="color:rgb(235, 37, 37);">donde querés vivir</span></h1>
                        <p class="hero-subtitle">En Rodrigo Dalmolin Inmobiliaria te acompañamos en cada paso para encontrar tu hogar ideal.</p>
                        <a href="{{ route('public.listado') }}" class="hero-btn">Ver Propiedades <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                    <div class="hero-img-col">
                        <div class="hero-img-wrapper">
                            <img src="{{ asset('img/dalmolin-entrada_LE_upscale_balanced.jpg') }}" alt="Inmobiliaria Dalmolin" class="hero-img">
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="hero-grid">
                    <div class="hero-text-col">
                        <span class="hero-badge-pill" style="background:rgb(253, 236, 236); color:rgb(206, 8, 8);">
                            <i class="fa-solid fa-chart-line"></i> Tasaciones Reales
                        </span>
                        <h1 class="hero-title">¿Pensando en <br><span style="color:rgb(206, 8, 8);">Vender tu Propiedad?</span></h1>
                        <p class="hero-subtitle">Utilizamos estrategias de marketing digital avanzado para vender tu propiedad al mejor precio.</p>
                        <a href="{{ route('public.contacto') }}" class="hero-btn" style="background-color:rgb(206, 8, 8);">Solicitar Tasación <i class="fa-solid fa-clipboard-check"></i></a>
                    </div>
                    <div class="hero-img-col">
                        <div class="hero-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?q=80&w=1920&auto=format&fit=crop" alt="Ventas" class="hero-img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- =============================================================== --}}
{{-- 3. NUEVAS SECCIONES --}}
{{-- =============================================================== --}}

<section class="comparador-section">
    <div class="section-header">
        <h2>¿Qué Servicio Necesitás?</h2>
        <p>Elegí la opción que mejor se adapte a tu búsqueda inmobiliaria.</p>
    </div>
    <div class="comparador-grid">
        <div class="comparador-item">
            <div class="comparador-icon"><i class="fas fa-search"></i></div>
            <h3>Quiero Comprar</h3>
            <ul class="comparador-features">
                <li><i class="fas fa-check text-green-500 mr-2"></i> Asesoramiento personalizado</li>
                <li><i class="fas fa-check text-green-500 mr-2"></i> Búsqueda específica</li>
                <li><i class="fas fa-check text-green-500 mr-2"></i> Visitas coordinadas</li>
                <li><i class="fas fa-check text-green-500 mr-2"></i> Gestión legal incluida</li>
            </ul>
            <a href="{{ route('public.listado', ['operacion' => 'venta']) }}" class="mt-6 px-6 py-2 border-2 border-gray-800 text-gray-800 rounded-lg font-bold hover:bg-gray-800 hover:text-white transition">Buscar Propiedades</a>
        </div>
        <div class="comparador-item featured">
            <div class="comparador-icon"><i class="fas fa-hand-holding-usd"></i></div>
            <h3>Quiero Vender</h3>
            <ul class="comparador-features">
                <li><i class="fas fa-check text-red-500 mr-2"></i> <strong>Tasación profesional</strong></li>
                <li><i class="fas fa-check text-red-500 mr-2"></i> Marketing digital avanzado</li>
                <li><i class="fas fa-check text-red-500 mr-2"></i> Fotos profesionales</li>
                <li><i class="fas fa-check text-red-500 mr-2"></i> Negociación experta</li>
            </ul>
            <a href="{{ route('public.contacto') }}" class="mt-6 px-8 py-3 bg-red-600 text-white rounded-lg font-bold hover:bg-red-700 transition shadow-lg shadow-red-200">SOLICITAR TASACIÓN</a>
        </div>
        <div class="comparador-item">
            <div class="comparador-icon"><i class="fas fa-key"></i></div>
            <h3>Quiero Alquilar</h3>
            <ul class="comparador-features">
                <li><i class="fas fa-check text-green-500 mr-2"></i> Propiedades verificadas</li>
                <li><i class="fas fa-check text-green-500 mr-2"></i> Contratos seguros</li>
                <li><i class="fas fa-check text-green-500 mr-2"></i> Gestión de garantías</li>
                <li><i class="fas fa-check text-green-500 mr-2"></i> Acompañamiento continuo</li>
            </ul>
            <a href="{{ route('public.listado', ['operacion' => 'alquiler']) }}" class="mt-6 px-6 py-2 border-2 border-gray-800 text-gray-800 rounded-lg font-bold hover:bg-gray-800 hover:text-white transition">Ver Alquileres</a>
        </div>
    </div>
</section>
<section class="mapa-section">
    <div class="mapa-grid">
        
        <div class="h-[500px] w-full relative rounded-2xl overflow-hidden shadow-2xl border border-gray-200 z-0">
            <div id="map-home" class="h-full w-full"></div>
            <div id="map-loading" class="absolute inset-0 bg-white z-[1000] flex items-center justify-center">
                <div class="animate-pulse flex flex-col items-center">
                    <div class="h-12 w-12 bg-gray-200 rounded-full mb-4"></div>
                    <div class="h-4 w-32 bg-gray-200 rounded"></div>
                </div>
            </div>
        </div>

        <div class="mapa-info-side">
            <h3>Tu próximo hogar <br><span class="text-red-600">está en el mapa.</span></h3>
            
            <p>
                Olvídate de las listas interminables. Navegá por nuestra ciudad de forma interactiva y descubrí oportunidades en las zonas que realmente te interesan.
            </p>
            
            <div class="flex flex-col gap-4">
                <div class="flex items-start gap-3">
                    <div class="mt-1 text-red-500"><i class="fa-solid fa-location-dot"></i></div>
                    <p class="text-sm m-0 p-0 text-gray-500">Ubicaciones exactas y precios al instante.</p>
                </div>
                <div class="flex items-start gap-3">
                    <div class="mt-1 text-red-500"><i class="fa-solid fa-images"></i></div>
                    <p class="text-sm m-0 p-0 text-gray-500">Fotos principales en cada marcador.</p>
                </div>
            </div>

            <a href="{{ route('public.mapa') }}" 
               class="inline-flex items-center gap-2 mt-8 font-bold text-gray-900 hover:text-red-600 transition group">
                Explorar Pantalla Completa 
                <i class="fa-solid fa-arrow-right transition-transform group-hover:translate-x-1"></i>
            </a>
        </div>

    </div>
</section>

<section class="py-20 px-4">
    <div class="max-w-5xl mx-auto">
        
        <!-- Título -->
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Nuestro Proceso</h2>
            <p class="text-gray-600 text-lg">Simple, transparente y efectivo. Así te ayudamos.</p>
        </div>

        <!-- Timeline -->
        <div class="relative">
            <!-- Línea vertical -->
            <div class="absolute left-8 top-0 bottom-0 w-0.5 bg-gradient-to-b from-red-500 via-red-600 to-red-700"></div>

            <!-- Paso 1 -->
            <div class="relative flex items-start mb-12">
                <!-- Número -->
                <div class="relative z-10 flex-shrink-0">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center text-white font-bold text-2xl shadow-lg">
                        1
                    </div>
                </div>
                
                <!-- Contenido -->
                <div class="ml-8 bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-shadow duration-300 flex-1">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Consulta Inicial</h3>
                    <p class="text-gray-600">Nos reunimos para entender tus necesidades, presupuesto y objetivos reales.</p>
                </div>
            </div>

            <!-- Paso 2 -->
            <div class="relative flex items-start mb-12">
                <!-- Número -->
                <div class="relative z-10 flex-shrink-0">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-600 to-red-700 rounded-full flex items-center justify-center text-white font-bold text-2xl shadow-lg">
                        2
                    </div>
                </div>
                
                <!-- Contenido -->
                <div class="ml-8 bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-shadow duration-300 flex-1">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Búsqueda Inteligente</h3>
                    <p class="text-gray-600">Filtramos el mercado por vos. Te presentamos solo las opciones que valen la pena.</p>
                </div>
            </div>

            <!-- Paso 3 -->
            <div class="relative flex items-start">
                <!-- Número -->
                <div class="relative z-10 flex-shrink-0">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-700 to-red-800 rounded-full flex items-center justify-center text-white font-bold text-2xl shadow-lg">
                        3
                    </div>
                </div>
                
                <!-- Contenido -->
                <div class="ml-8 bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-shadow duration-300 flex-1">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Gestión y Cierre</h3>
                    <p class="text-gray-600">Nos encargamos de la negociación, revisión de documentos y trámites legales.</p>
                </div>
            </div>

        </div>

    </div>
</section>

<section class="faq-section">
    <div class="section-header">
        <h2>Preguntas Frecuentes</h2>
        <p>Resolvemos tus dudas antes de empezar.</p>
    </div>
    <div class="faq-container" x-data="{ active: null }">
        <div class="faq-item" :class="active === 1 ? 'active' : ''">
            <div class="faq-question" @click="active = (active === 1 ? null : 1)">¿Cuánto cobra la inmobiliaria? <i class="fas fa-chevron-down"></i></div>
            <div class="faq-answer"><div class="faq-answer-content">Nuestros honorarios se rigen por el Colegio de Corredores. Generalmente es el 3% en operaciones de compraventa.</div></div>
        </div>
        <div class="faq-item" :class="active === 2 ? 'active' : ''">
            <div class="faq-question" @click="active = (active === 2 ? null : 2)">¿Realizan tasaciones sin cargo? <i class="fas fa-chevron-down"></i></div>
            <div class="faq-answer"><div class="faq-answer-content">Sí. Ofrecemos tasaciones de mercado profesionales sin costo para propietarios que deseen vender con nosotros.</div></div>
        </div>
        <div class="faq-item" :class="active === 3 ? 'active' : ''">
            <div class="faq-question" @click="active = (active === 3 ? null : 3)">¿Qué documentación necesito para vender? <i class="fas fa-chevron-down"></i></div>
            <div class="faq-answer"><div class="faq-answer-content">Lo principal es tener la Escritura, DNI de los titulares y planos aprobados.</div></div>
        </div>
    </div>
</section>

<div class="cta-split">
    <div class="cta-card">
        <h3>¿Querés Comprar?</h3>
        <p>Encontrá la propiedad perfecta con nuestro asesoramiento.</p>
        <a href="{{ route('public.listado') }}" class="cta-button">Ver Catálogo <i class="fas fa-arrow-right"></i></a>
    </div>
    <div class="cta-card red">
        <h3>¿Querés Vender?</h3>
        <p>Tasamos tu propiedad hoy mismo sin compromiso.</p>
        <a href="{{ route('public.contacto') }}" class="cta-button">Contactar Ahora <i class="fas fa-envelope"></i></a>
    </div>
</div>


{{-- WHATSAPP FLOAT --}}
<div class="whatsapp-float">
  <a href="https://wa.me/5493454123456?text=Hola,%20estoy%20interesado%20en%20una%20propiedad" target="_blank" class="whatsapp-button" aria-label="Contactar por WhatsApp">
    <i class="fa-brands fa-whatsapp"></i>
    <span class="whatsapp-tooltip">¡Chateá con nosotros!</span>
  </a>
</div>

{{-- SCRIPTS SWIPER Y MAPA --}}
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>

<script>
    // 1. INICIALIZAR SWIPER HERO
    var swiper = new Swiper(".hero-swiper", {
        spaceBetween: 30,
        effect: "fade",
        fadeEffect: { crossFade: true },
        speed: 1000,
        loop: true,
        autoplay: { delay: 5000, disableOnInteraction: false },
        pagination: { el: ".swiper-pagination", clickable: true },
    });

    // 2. INICIALIZAR MAPA INTERACTIVO
    document.addEventListener('DOMContentLoaded', function() {
        // Coordenadas Concordia
        var map = L.map('map-home').setView([-31.3929, -58.0209], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var markers = L.markerClusterGroup();
        
        // Icono personalizado (opcional)
        var houseIcon = L.icon({
            iconUrl: '{{ asset("img/dalmolin_icon2.png") }}', 
            iconSize: [32, 32], iconAnchor: [16, 32], popupAnchor: [0, -32]
        });

        // Cargar datos de la API existente
        fetch('{{ route("api.mapa") }}')
            .then(response => response.json())
            .then(data => {
                // Ocultar loading
                document.getElementById('map-loading').style.display = 'none';

                data.forEach(propiedad => {
                    if(propiedad.latitud && propiedad.longitud) {
                        // Popup más compacto para el Home
                        var popupContent = `
                            <div class="flex flex-col text-center" style="width: 200px">
                                <img src="/storage/${propiedad.imagen_principal}" class="w-full h-24 object-cover rounded-t-lg">
                                <div class="p-2 bg-white">
                                    <h3 class="font-bold text-gray-800 text-xs mb-1 truncate">${propiedad.titulo}</h3>
                                    <span class="font-black text-red-600 text-sm block">${propiedad.moneda} ${new Intl.NumberFormat('es-AR').format(propiedad.precio)}</span>
                                    <a href="/propiedad/${propiedad.slug}" class="block mt-2 bg-gray-800 text-white text-[10px] py-1 rounded hover:bg-gray-700">VER</a>
                                </div>
                            </div>
                        `;
                        var marker = L.marker([propiedad.latitud, propiedad.longitud]); 
                        marker.bindPopup(popupContent);
                        markers.addLayer(marker);
                    }
                });

                map.addLayer(markers);
                if(data.length > 0) map.fitBounds(markers.getBounds());
            })
            .catch(error => {
                console.error('Error mapa:', error);
                document.getElementById('map-loading').innerHTML = '<p class="text-red-500 font-bold">Error cargando mapa</p>';
            });
    });
</script>

@endsection