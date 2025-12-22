@extends('public.layouts.app')

@section('titulo', $propiedad->titulo . ' - Dalmolin Inmobiliaria')

@section('contenido')

<div style="margin-top: 100px;"></div> 

<div class="buy-container" style="padding: 40px 20px; max-width: 1200px; margin: 0 auto;">

    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 30px; flex-wrap: wrap; gap: 20px;">
        <div>
            <span style="background: #3b82f6; color: white; padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; text-transform: uppercase; font-weight: bold;">
                {{ $propiedad->tipo_operacion }}
            </span>
            <h1 style="font-size: 2rem; color: #1f2937; margin: 10px 0 5px 0;">{{ $propiedad->titulo }}</h1>
            <p style="color: #6b7280; font-size: 1.1rem;">
                <i class="fa-solid fa-location-dot"></i> {{ $propiedad->direccion ? $propiedad->direccion . ',' : '' }} {{ $propiedad->ciudad }}
            </p>
        </div>
        <div>
            <div style="font-size: 2.2rem; font-weight: 800; color: #1f2937;">
                {{ $propiedad->moneda }} {{ number_format($propiedad->precio, 0, ',', '.') }}
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 40px;">
        
        <main>
            <div style="width: 100%; height: 500px; border-radius: 12px; overflow: hidden; margin-bottom: 30px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                @if($propiedad->imagen_principal)
                    <img src="{{ asset('storage/' . $propiedad->imagen_principal) }}" alt="{{ $propiedad->titulo }}" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <img src="{{ asset('img/placeholder-casa.jpg') }}" alt="Sin imagen" style="width: 100%; height: 100%; object-fit: cover;">
                @endif
            </div>

            <div style="background: #f3f4f6; padding: 25px; border-radius: 12px; display: flex; justify-content: space-around; margin-bottom: 30px; text-align: center;">
                <div>
                    <i class="fa-solid fa-ruler-combined" style="font-size: 1.5rem; color: #3b82f6; margin-bottom: 8px;"></i>
                    <p style="font-weight: bold; color: #374151;">{{ $propiedad->superficie_total }} m²</p>
                    <span style="font-size: 0.85rem; color: #6b7280;">Total</span>
                </div>
                <div>
                    <i class="fa-solid fa-bed" style="font-size: 1.5rem; color: #3b82f6; margin-bottom: 8px;"></i>
                    <p style="font-weight: bold; color: #374151;">{{ $propiedad->habitaciones }}</p>
                    <span style="font-size: 0.85rem; color: #6b7280;">Dormitorios</span>
                </div>
                <div>
                    <i class="fa-solid fa-bath" style="font-size: 1.5rem; color: #3b82f6; margin-bottom: 8px;"></i>
                    <p style="font-weight: bold; color: #374151;">{{ $propiedad->banos }}</p>
                    <span style="font-size: 0.85rem; color: #6b7280;">Baños</span>
                </div>
                <div>
                    <i class="fa-solid fa-car" style="font-size: 1.5rem; color: #3b82f6; margin-bottom: 8px;"></i>
                    <p style="font-weight: bold; color: #374151;">{{ $propiedad->cocheras ?? 0 }}</p>
                    <span style="font-size: 0.85rem; color: #6b7280;">Cocheras</span>
                </div>
            </div>

            @if($propiedad->imagenes->count() > 0)
                <div class="mt-12">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Galería de Fotos</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($propiedad->imagenes as $imagen)
                            <div class="relative group overflow-hidden rounded-lg shadow-lg cursor-pointer h-64">
                                <img src="{{ asset('storage/' . $imagen->ruta) }}" 
                                    alt="Foto de {{ $propiedad->titulo }}" 
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                    onclick="window.open(this.src, '_blank')"
                                    >
                                
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center">
                                    <span class="text-white opacity-0 group-hover:opacity-100 font-bold bg-black bg-opacity-50 px-3 py-1 rounded">
                                        Ver Grande 🔍
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div style="margin-bottom: 40px;">
                <h3 style="font-size: 1.5rem; color: #1f2937; margin-bottom: 15px; border-bottom: 2px solid #e5e7eb; padding-bottom: 10px;">Descripción</h3>
                <div style="line-height: 1.8; color: #4b5563; white-space: pre-line;">
                    {{ $propiedad->descripcion }}
                </div>
            </div>

        </main>

        <aside>
            <div style="background: white; border: 1px solid #e5e7eb; padding: 30px; border-radius: 12px; position: sticky; top: 120px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
                <h3 style="margin-bottom: 20px; font-size: 1.2rem; text-align: center;">¿Te interesa esta propiedad?</h3>
                
                <a href="https://wa.me/5493456256190?text=Hola,%20me%20interesa%20la%20propiedad:%20{{ $propiedad->titulo }}" target="_blank" 
                   style="display: block; width: 100%; background: #22c55e; color: white; text-align: center; padding: 12px; border-radius: 8px; text-decoration: none; font-weight: bold; margin-bottom: 15px; transition: background 0.3s;">
                    <i class="fa-brands fa-whatsapp"></i> Consultar por WhatsApp
                </a>

                <div style="text-align: center; margin: 20px 0; color: #9ca3af;">o contáctanos</div>

                <div style="margin-bottom: 15px;">
                    <div style="font-weight: bold; color: #374151; margin-bottom: 5px;">Oficina</div>
                    <a href="tel:+543456256190" style="color: #3b82f6; text-decoration: none;">+54 345 625 6190</a>
                </div>

                <div>
                    <div style="font-weight: bold; color: #374151; margin-bottom: 5px;">Email</div>
                    <a href="mailto:info@dalmolin.com" style="color: #3b82f6; text-decoration: none;">info@dalmolin.com</a>
                </div>
            </div>
        </aside>

    </div>
</div>

<style>
    @media (max-width: 768px) {
        .buy-container > div { 
            grid-template-columns: 1fr !important; /* Columna única en móvil */
        }
        main > div:first-child {
            height: 300px !important; /* Imagen más baja en móvil */
        }
    }
</style>

@endsection