@extends('public.layouts.app')

@section('meta_title', 'Página no encontrada | Inmobiliaria Dalmolin')

@section('contenido')
<div class="min-h-[70vh] flex flex-col items-center justify-center text-center px-4 py-12 relative overflow-hidden">
    
    {{-- Fondo decorativo --}}
    <div class="absolute inset-0 -z-10 opacity-5">
        <div class="absolute top-10 left-10 w-72 h-72 bg-red-700 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-red-600 rounded-full blur-3xl"></div>
    </div>

    {{-- Código 404 grande --}}
    <div class="relative mb-8">
        <div class="text-[180px] font-black text-gray-200 leading-none select-none">
            404
        </div>
        <div class="absolute inset-0 flex items-center justify-center">
            <i class="fa-solid fa-house-crack text-7xl text-red-600 animate-bounce"></i>
        </div>
    </div>

    {{-- Título y descripción --}}
    <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
        ¡Ups! Esta propiedad no está disponible
    </h1>
    <p class="text-lg text-gray-600 max-w-2xl mx-auto mb-10 leading-relaxed">
        Es posible que la propiedad haya sido vendida, alquilada o el enlace sea incorrecto.<br>
        Pero no te preocupes, <span class="text-red-600 font-semibold">tenemos más opciones perfectas para ti</span>.
    </p>

    {{-- Botones de acción --}}
    <div class="flex flex-col sm:flex-row gap-4">
        <a href="{{ route('home') }}" 
           class="group px-8 py-4 bg-white border-2 border-gray-300 text-gray-700 font-bold rounded-xl hover:border-red-600 hover:text-red-600 transition-all duration-300 shadow-sm hover:shadow-md">
            <i class="fa-solid fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform duration-300"></i>
            Volver al Inicio
        </a>
        <a href="{{ route('public.listado', ['operacion' => 'venta']) }}" 
           class="group px-8 py-4 bg-gradient-to-r from-red-700 to-red-600 text-white font-bold rounded-xl hover:from-red-800 hover:to-red-700 transition-all duration-300 shadow-lg shadow-red-200 hover:shadow-xl  hover:-translate-y-0.5">
            <i class="fa-solid fa-house-circle-check mr-2"></i>
            Ver Catálogo Completo
        </a>
    </div>

</div>

{{-- Animación CSS adicional --}}
<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    .fa-house-crack {
        animation: float 3s ease-in-out infinite;
    }
</style>
@endsection