<aside class="w-full lg:w-1/4 px-4 hidden lg:block">
    <div class="sticky top-24 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden" 
         x-data="filterComponent()">
        
        <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h3 class="font-bold text-gray-800"><i class="fas fa-filter mr-2 text-blue-600"></i> Filtros</h3>
            @if(request()->keys())
                <a href="{{ route('public.listado') }}" class="text-xs text-red-500 font-bold hover:underline">
                    LIMPIAR TODO
                </a>
            @endif
        </div>

        <form action="{{ route('public.listado') }}" method="GET" id="filterForm" class="p-5 space-y-6">

            <div x-data="{ open: true }" class="border-b border-gray-100 pb-5">
                <button type="button" @click="open = !open" class="flex justify-between w-full font-semibold text-gray-700 mb-3">
                    Tipo de Operación <span class="text-gray-400" x-text="open ? '−' : '+'"></span>
                </button>
                <div x-show="open" x-collapse class="space-y-2">
                    @foreach(['venta' => 'Venta', 'alquiler' => 'Alquiler', 'temporal' => 'Alquiler Temporal'] as $val => $label)
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="checkbox" name="operacion[]" value="{{ $val }}" 
                                   {{ in_array($val, (array)request('operacion')) ? 'checked' : '' }}
                                   class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                            <span class="text-gray-600 group-hover:text-blue-600 transition text-sm">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div x-data="{ open: true }" class="border-b border-gray-100 pb-5">
                <button type="button" @click="open = !open" class="flex justify-between w-full font-semibold text-gray-700 mb-3">
                    Tipo de Propiedad <span class="text-gray-400" x-text="open ? '−' : '+'"></span>
                </button>
                <div x-show="open" x-collapse class="max-h-48 overflow-y-auto space-y-2 pr-2 custom-scrollbar">
                    @php 
                        $tipos = ['Casa', 'Departamento', 'Terreno', 'Local Comercial', 'Campo', 'Galpón', 'Oficina', 'Cochera']; 
                    @endphp
                    @foreach($tipos as $tipo)
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="checkbox" name="tipos[]" value="{{ Str::slug($tipo) }}" 
                                   {{ in_array(Str::slug($tipo), (array)request('tipos')) ? 'checked' : '' }}
                                   class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300">
                            <span class="text-gray-600 group-hover:text-blue-600 transition text-sm">{{ $tipo }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div x-data="priceSlider()" class="border-b border-gray-100 pb-5">
                <div class="flex justify-between items-center mb-3">
                    <span class="font-semibold text-gray-700">Precio</span>
                    <div class="relative inline-block w-12 align-middle select-none transition duration-200 ease-in">
                        <input type="checkbox" name="moneda" id="toggle-moneda" value="ARS" class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 appearance-none cursor-pointer" 
                            {{ request('moneda') == 'ARS' ? 'checked' : '' }} @click="toggleCurrency"/>
                        <label for="toggle-moneda" class="toggle-label block overflow-hidden h-5 rounded-full bg-gray-300 cursor-pointer text-[10px] font-bold text-center leading-5 text-white">
                            <span class="ml-6" x-show="currency === 'USD'">$</span>
                            <span class="mr-6" x-show="currency === 'ARS'">A</span>
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-between gap-2 mb-4">
                    <div class="relative w-full">
                        <span class="absolute left-2 top-2 text-gray-400 text-xs" x-text="currency"></span>
                        <input type="number" name="precio_min" x-model="minPrice" @change="updateSlider" 
                               class="w-full pl-8 pr-2 py-1 text-sm border border-gray-300 rounded focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    </div>
                    <span class="text-gray-400">-</span>
                    <div class="relative w-full">
                        <span class="absolute left-2 top-2 text-gray-400 text-xs" x-text="currency"></span>
                        <input type="number" name="precio_max" x-model="maxPrice" @change="updateSlider"
                               class="w-full pl-8 pr-2 py-1 text-sm border border-gray-300 rounded focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    </div>
                </div>

                <div class="relative h-2 bg-gray-200 rounded-full mt-2">
                    <div class="absolute h-2 bg-blue-500 rounded-full" :style="'left: ' + minPercent + '%; right: ' + (100 - maxPercent) + '%'"></div>
                    <input type="range" min="0" :max="limit" step="1000" x-model="minPrice" @input="validateMin"
                           class="absolute w-full h-2 opacity-0 cursor-pointer pointer-events-none z-20 top-0 [&::-webkit-slider-thumb]:pointer-events-auto [&::-webkit-slider-thumb]:w-4 [&::-webkit-slider-thumb]:h-4">
                    <input type="range" min="0" :max="limit" step="1000" x-model="maxPrice" @input="validateMax"
                           class="absolute w-full h-2 opacity-0 cursor-pointer pointer-events-none z-20 top-0 [&::-webkit-slider-thumb]:pointer-events-auto [&::-webkit-slider-thumb]:w-4 [&::-webkit-slider-thumb]:h-4">
                </div>
            </div>

            <div class="border-b border-gray-100 pb-5">
                <label class="font-semibold text-gray-700 mb-3 block">Ubicación</label>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    <input type="text" name="ciudad" list="barrios" value="{{ request('ciudad') }}" 
                           class="w-full pl-9 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" 
                           placeholder="Barrio o Ciudad...">
                    <datalist id="barrios">
                        <option value="Centro">
                        <option value="Parque San Carlos">
                        <option value="Zona Norte">
                        <option value="Villa Adela">
                    </datalist>
                </div>
            </div>

            <div class="border-b border-gray-100 pb-5 space-y-4">
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-2 block">Dormitorios</label>
                    <div class="flex flex-wrap gap-2">
                        <label class="cursor-pointer">
                            <input type="radio" name="habitaciones" value="" class="peer sr-only" {{ !request('habitaciones') ? 'checked' : '' }}>
                            <span class="px-3 py-1 text-xs border rounded-full peer-checked:bg-gray-800 peer-checked:text-white transition hover:bg-gray-100">Any</span>
                        </label>
                        @foreach([1, 2, 3, 4] as $n)
                        <label class="cursor-pointer">
                            <input type="radio" name="habitaciones" value="{{ $n }}" class="peer sr-only" {{ request('habitaciones') == $n ? 'checked' : '' }}>
                            <span class="px-3 py-1 text-xs border rounded-full peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 transition hover:border-blue-400">{{ $n }}+</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-2 block">Baños</label>
                    <div class="flex flex-wrap gap-2">
                        <label class="cursor-pointer">
                            <input type="radio" name="banos" value="" class="peer sr-only" {{ !request('banos') ? 'checked' : '' }}>
                            <span class="px-3 py-1 text-xs border rounded-full peer-checked:bg-gray-800 peer-checked:text-white transition hover:bg-gray-100">Any</span>
                        </label>
                        @foreach([1, 2, 3] as $n)
                        <label class="cursor-pointer">
                            <input type="radio" name="banos" value="{{ $n }}" class="peer sr-only" {{ request('banos') == $n ? 'checked' : '' }}>
                            <span class="px-3 py-1 text-xs border rounded-full peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 transition hover:border-blue-400">{{ $n }}+</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div x-data="{ open: false }">
                <button type="button" @click="open = !open" class="flex justify-between w-full font-semibold text-gray-700 mb-3">
                    Superficie (m²) <span class="text-gray-400" x-text="open ? '−' : '+'"></span>
                </button>
                <div x-show="open" class="space-y-3">
                    <div>
                        <span class="text-xs text-gray-500 mb-1 block">Total</span>
                        <div class="flex items-center gap-2">
                            <input type="number" name="m2_min" placeholder="Min" value="{{ request('m2_min') }}" class="w-1/2 px-2 py-1 text-sm border rounded">
                            <span class="text-gray-400">-</span>
                            <input type="number" name="m2_max" placeholder="Max" value="{{ request('m2_max') }}" class="w-1/2 px-2 py-1 text-sm border rounded">
                        </div>
                    </div>
                    <div>
                        <span class="text-xs text-gray-500 mb-1 block">Cubierta</span>
                        <div class="flex items-center gap-2">
                            <input type="number" name="m2c_min" placeholder="Min" value="{{ request('m2c_min') }}" class="w-1/2 px-2 py-1 text-sm border rounded">
                            <span class="text-gray-400">-</span>
                            <input type="number" name="m2c_max" placeholder="Max" value="{{ request('m2c_max') }}" class="w-1/2 px-2 py-1 text-sm border rounded">
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-4 mt-4 border-t border-gray-100">
                <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 rounded-lg shadow-md transition transform active:scale-95">
                    Aplicar Filtros
                </button>
            </div>

        </form>
    </div>
</aside>

<script>
    function filterComponent() {
        return {
            // Lógica general del componente
        }
    }

    function priceSlider() {
        return {
            minPrice: {{ request('precio_min', 0) }},
            maxPrice: {{ request('precio_max', 500000) }},
            limit: 1000000, // Límite máximo del slider
            minPercent: 0,
            maxPercent: 100,
            currency: '{{ request('moneda', 'USD') }}',
            
            init() {
                this.updateSlider();
            },
            toggleCurrency() {
                this.currency = this.currency === 'USD' ? 'ARS' : 'USD';
                // Opcional: Ajustar límites si cambias moneda
            },
            validateMin() {
                if (parseInt(this.minPrice) > parseInt(this.maxPrice)) {
                    this.minPrice = parseInt(this.maxPrice) - 1000;
                }
                this.updateSlider();
            },
            validateMax() {
                if (parseInt(this.maxPrice) < parseInt(this.minPrice)) {
                    this.maxPrice = parseInt(this.minPrice) + 1000;
                }
                this.updateSlider();
            },
            updateSlider() {
                this.minPercent = (this.minPrice / this.limit) * 100;
                this.maxPercent = (this.maxPrice / this.limit) * 100;
            }
        }
    }
</script>

<style>
    /* CSS para el toggle switch */
    .toggle-checkbox:checked {
        right: 0;
        border-color: #3b82f6;
    }
    .toggle-checkbox:checked + .toggle-label {
        background-color: #3b82f6;
    }
    .toggle-checkbox {
        right: 0;
        transition: all 0.3s;
    }
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
        border-radius: 4px;
    }
</style>