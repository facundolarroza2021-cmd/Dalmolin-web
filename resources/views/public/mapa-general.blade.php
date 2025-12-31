@extends('public.layouts.app')

@section('meta_title', 'Mapa de Propiedades | Inmobiliaria Dalmolin')

@section('contenido')
<div class="h-[calc(100vh-80px)] w-full relative">
    
    {{-- Contenedor del Mapa --}}
    <div id="map" class="h-full w-full z-0"></div>

    {{-- Filtros Flotantes (Ejemplo visual) --}}
    <div class="absolute top-4 left-4 z-[500] bg-white p-4 rounded-lg shadow-lg max-w-xs">
        <h1 class="font-bold text-gray-800 mb-2">Explorar Mapa</h1>
        <p class="text-sm text-gray-600 mb-4">Navega para ver las propiedades agrupadas por zona.</p>
        <a href="{{ route('public.listado') }}" class="text-indigo-600 text-sm hover:underline">
            <i class="fa-solid fa-list"></i> Volver al listado
        </a>
    </div>

</div>

{{-- Estilos de Leaflet + Clusters --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />

<style>
    /* Personalización del Popup */
    .leaflet-popup-content-wrapper { border-radius: 10px; overflow: hidden; padding: 0; }
    .leaflet-popup-content { margin: 0; width: 260px !important; }
    
    /* Cluster personalizado (Círculo de color) */
    .marker-cluster-small { background-color: rgba(99, 102, 241, 0.6); } /* Indigo */
    .marker-cluster-small div { background-color: rgba(79, 70, 229, 0.8); color: white; }
    
    .marker-cluster-medium { background-color: rgba(245, 158, 11, 0.6); } /* Amber */
    .marker-cluster-medium div { background-color: rgba(217, 119, 6, 0.8); color: white; }
</style>

{{-- Scripts --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Inicializar Mapa (Centrado en Concordia)
        var map = L.map('map').setView([-31.3929, -58.0209], 13);

        // 2. Capa de Mapa (OpenStreetMap - Gratis)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // 3. Crear grupo de clusters
        var markers = L.markerClusterGroup();

        // 4. Icono personalizado (Opcional)
        var houseIcon = L.icon({
            iconUrl: '{{ asset("img/dalmolin_icon2.png") }}', // Tu icono
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        });

        // 5. Cargar datos de la API
        fetch('{{ route("api.mapa") }}')
            .then(response => response.json())
            .then(data => {
                data.forEach(propiedad => {
                    if(propiedad.latitud && propiedad.longitud) {
                        
                        // HTML del Popup (Mini ficha)
                        var popupContent = `
                            <div class="flex flex-col">
                                <img src="/storage/${propiedad.imagen_principal}" class="w-full h-32 object-cover">
                                <div class="p-3">
                                    <span class="text-xs font-bold text-indigo-600 uppercase">${propiedad.tipo_operacion}</span>
                                    <h3 class="font-bold text-gray-800 text-sm leading-tight mt-1 mb-1">${propiedad.titulo}</h3>
                                    <span class="font-black text-gray-900">${propiedad.moneda} ${new Intl.NumberFormat('es-AR').format(propiedad.precio)}</span>
                                    <a href="/propiedad/${propiedad.slug}" class="block mt-2 text-center bg-red text-white text-xs py-2 rounded hover:bg-gray-700">Ver Propiedad</a>
                                </div>
                            </div>
                        `;

                        // Crear marcador y agregarlo al cluster
                        var marker = L.marker([propiedad.latitud, propiedad.longitud]); // Puedes agregar {icon: houseIcon}
                        marker.bindPopup(popupContent);
                        markers.addLayer(marker);
                    }
                });

                // Agregar todos los clusters al mapa
                map.addLayer(markers);
                
                // Ajustar zoom para ver todos los pines si hay datos
                if(data.length > 0) {
                    map.fitBounds(markers.getBounds());
                }
            })
            .catch(error => console.error('Error cargando mapa:', error));
    });
</script>
@endsection