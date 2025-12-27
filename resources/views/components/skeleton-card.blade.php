<div class="bg-white rounded-xl shadow-sm border border-gray-100 h-full flex flex-col animate-pulse overflow-hidden">
    
    {{-- 1. IMAGEN SKELETON --}}
    <div class="h-64 bg-gray-200 w-full relative">
        {{-- Simula el badge de operación --}}
        <div class="absolute top-3 left-3 w-20 h-6 bg-gray-300 rounded-full"></div>
    </div>

    {{-- 2. CONTENIDO --}}
    <div class="p-5 flex flex-col flex-1">
        
        {{-- Precio y Ubicación --}}
        <div class="mb-4 space-y-2">
            {{-- Precio --}}
            <div class="h-8 bg-gray-200 rounded w-1/2"></div>
            {{-- Ubicación (Icono + Texto) --}}
            <div class="flex items-center gap-2">
                <div class="h-3 w-3 bg-gray-200 rounded-full"></div>
                <div class="h-3 bg-gray-200 rounded w-1/3"></div>
            </div>
        </div>

        {{-- Título (Dos líneas simuladas) --}}
        <div class="space-y-2 mb-4">
            <div class="h-5 bg-gray-200 rounded w-full"></div>
            <div class="h-5 bg-gray-200 rounded w-2/3"></div>
        </div>

        {{-- Características (Grid de 3) --}}
        <div class="grid grid-cols-3 gap-2 border-t border-gray-100 pt-4 mt-auto">
            <div class="flex flex-col items-center gap-1">
                <div class="h-4 w-4 bg-gray-200 rounded"></div>
                <div class="h-2 w-8 bg-gray-200 rounded"></div>
            </div>
            <div class="flex flex-col items-center gap-1 border-l border-gray-100">
                <div class="h-4 w-4 bg-gray-200 rounded"></div>
                <div class="h-2 w-8 bg-gray-200 rounded"></div>
            </div>
            <div class="flex flex-col items-center gap-1 border-l border-gray-100">
                <div class="h-4 w-4 bg-gray-200 rounded"></div>
                <div class="h-2 w-8 bg-gray-200 rounded"></div>
            </div>
        </div>

    </div>
</div>