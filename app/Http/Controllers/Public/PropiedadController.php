<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Propiedad;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class PropiedadController extends Controller
{
    public function show($slug)
    {
        // 1. Cargar propiedad con imágenes
        $propiedad = Propiedad::where('slug', $slug)
            ->where('publicada', true)
            ->with('imagenes')
            ->firstOrFail();

        $sugeridas = Propiedad::where('publicada', true)
            ->where('tipo_operacion', $propiedad->tipo_operacion)
            ->where('id', '!=', $propiedad->id)
            ->latest()
            ->take(3)
            ->get();


        $schema = [
            "@context" => "https://schema.org",
            "@type" => "SingleFamilyResidence", 
            "name" => $propiedad->titulo,
            "description" => Str::limit($propiedad->descripcion, 160),
            "image" => [asset('storage/' . $propiedad->imagen_principal)],
            "url" => url()->current(),
            "address" => [
                "@type" => "PostalAddress",
                "streetAddress" => $propiedad->direccion ? $propiedad->direccion : 'Consultar dirección en oficina',
                "addressLocality" => $propiedad->ciudad,
                "addressRegion" => "Entre Ríos",
                "addressCountry" => "AR"
            ],
            "numberOfRooms" => $propiedad->habitaciones, 
            "numberOfBathroomsTotal" => $propiedad->banos,
            "floorSize" => [
                "@type" => "QuantitativeValue",
                "value" => $propiedad->superficie_total,
                "unitCode" => "MTK" 
            ],
            "offers" => [
                "@type" => "Offer",
                "priceCurrency" => $propiedad->moneda, 
                "price" => $propiedad->precio,
                "availability" => "https://schema.org/InStock",
                "url" => url()->current(),
                "seller" => [
                    "@type" => "RealEstateAgent",
                    "name" => "Inmobiliaria Dalmolin",
                    "logo" => asset('img/dalmolin_logo2.png'),
                    "image" => asset('img/dalmolin_logo2.png'), 
                    "url" => route('home'),
                    "address" => [
                        "@type" => "PostalAddress",
                        "streetAddress" => "La Rioja 654",
                        "addressLocality" => "Concordia",
                        "addressRegion" => "Entre Ríos",
                        "postalCode" => "3200",
                        "addressCountry" => "AR"
                    ],
                ]
            ]
        ];

        // Agregar galería al Schema
        if($propiedad->imagenes->count() > 0) {
            foreach($propiedad->imagenes as $img) {
                $schema['image'][] = asset('storage/' . $img->ruta);
            }
        }

        // Pasamos la variable $schema a la vista
        return view('public.propiedad', compact('propiedad', 'schema', 'sugeridas'));
    }

    /**
     * Muestra el listado de propiedades con filtros (Venta, Alquiler, Tipo).
     */
    public function index(Request $request, $operacion = null, $tipo = null)
    {
        // ======================================================
        // 1. TU LÓGICA DE FILTROS (Que ya funciona bien)
        // ======================================================
        $query = Propiedad::where('publicada', true);
        $titulo = 'Todas las Propiedades'; 

        // Filtro de Operación
        if ($operacion) {
            $query->where('tipo_operacion', $operacion);
            $titulo = ucfirst($operacion);
        }
        
        if ($request->filled('operacion')) {
            $op = $request->operacion;
            // Si viene como array (checkboxes) usamos whereIn, si es string usamos where
            if(is_array($op)) {
                $query->whereIn('tipo_operacion', $op);
            } else {
                $query->where('tipo_operacion', $op);
            }
        }
        
        // Filtro de Tipo
        $tipoReal = $tipo ?? $request->tipo; 

        if ($tipoReal) {
            $query->where('tipo_propiedad', $tipoReal);
            $plural = ucfirst($tipoReal) . 's'; 
            $titulo = $operacion ? "$plural en " . ucfirst($operacion) : $plural;
        }

        // Filtros del Buscador Lateral
        if ($request->filled('habitaciones')) {
            $query->where('habitaciones', '>=', $request->habitaciones);
        }

        if ($request->filled('banos')) {
            $query->where('banos', '>=', $request->banos);
        }

        if ($request->filled('cocheras') && $request->cocheras == 'si') {
             $query->where('cocheras', '>=', 1);
        }

        if ($request->filled('precio_min')) {
            $query->where('precio', '>=', $request->precio_min);
        }
        if ($request->filled('precio_max')) {
            $query->where('precio', '<=', $request->precio_max);
        }

        if ($request->filled('ciudad')) {
            $query->where('ciudad', 'like', '%' . $request->ciudad . '%');
        }
        $tiposRequest = $request->tipos; // Del formulario sidebar
    
        // Si hay parámetros en URL (/propiedades/venta/casa), tienen prioridad o se suman
        // Aquí priorizamos el filtro del sidebar si existe
        if ($request->filled('tipos')) {
            $query->whereIn('tipo_propiedad', $request->tipos);
        } elseif ($tipo) { // $tipo viene de la ruta function index(..., $tipo=null)
            $query->where('tipo_propiedad', $tipo);
        }

        // 3. PRECIO Y MONEDA
        if ($request->filled('precio_min')) {
            $query->where('precio', '>=', $request->precio_min);
        }
        if ($request->filled('precio_max')) {
            $query->where('precio', '<=', $request->precio_max);
        }
        if ($request->filled('moneda')) {
            $query->where('moneda', $request->moneda);
        }

        // 4. SUPERFICIE (Total y Cubierta)
        if ($request->filled('m2_min')) {
            $query->where('superficie_total', '>=', $request->m2_min);
        }
        if ($request->filled('m2_max')) {
            $query->where('superficie_total', '<=', $request->m2_max);
        }
        if ($request->filled('m2c_min')) {
            $query->where('superficie_cubierta', '>=', $request->m2c_min);
        }
        if ($request->filled('m2c_max')) {
            $query->where('superficie_cubierta', '<=', $request->m2c_max);
        }

        // Ordenamiento
        if ($request->has('orden')) {
            if ($request->orden == 'precio_asc') $query->orderBy('precio', 'asc');
            elseif ($request->orden == 'precio_desc') $query->orderBy('precio', 'desc');
            else $query->latest();
        } else {
            $query->latest();
        }

        // Ejecutar consulta
        $propiedades = $query->paginate(12)->withQueryString();


        // ======================================================
        // 2. LÓGICA DEL DÓLAR (Insertada AQUÍ, antes del return)
        // ======================================================
        
        // Usamos 'dolar_v6' para forzar una caché nueva y limpia
        $valor_dolar = Cache::remember('dolar_v6', 60 * 60, function () {
            try {
                $ch = curl_init("https://dolarapi.com/v1/dolares/blue");
                
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Vital para local
                curl_setopt($ch, CURLOPT_TIMEOUT, 3);
                
                $response = curl_exec($ch);
                
                if(curl_errno($ch)) {
                    curl_close($ch);
                    return 1480; 
                }
                curl_close($ch);

                $data = json_decode($response, true);
                return $data['venta'] ?? 1480;

            } catch (\Exception $e) {
                return 1480;
            }
        });


        // ======================================================
        // 3. RETORNO ÚNICO (Fusionado)
        // ======================================================
        return view('public.listado', [
            'propiedades' => $propiedades,
            'titulo'      => $titulo,
            'operacion'   => $operacion,
            'tipo'        => $tipoReal,
            'valor_dolar' => $valor_dolar  // <--- Agregamos la variable aquí
        ]);
    }


    public function quickView($id)
    {
        $propiedad = Propiedad::with('imagenes')->findOrFail($id);
        
        // Retornamos solo el HTML del contenido del modal, no toda la página
        return view('public.components.modal-quickview-content', compact('propiedad'));
    }

    /**
     * API para alimentar el mapa interactivo (JSON)
     */
    public function apiMapa(Request $request)
    {
        // Seleccionamos SOLO los campos necesarios para que el mapa cargue rápido
        $propiedades = Propiedad::select(
                'id', 
                'titulo', 
                'slug', 
                'precio', 
                'moneda', 
                'latitud', 
                'longitud', 
                'imagen_principal', 
                'tipo_operacion',
                'tipo_propiedad',
                'ciudad'
            )
            ->where('publicada', true)
            ->whereNotNull('latitud') // Solo las que tienen ubicación
            ->whereNotNull('longitud')
            ->get();

        return response()->json($propiedades);
    }
    public function mapaGeneral()
    {
        return view('public.mapa-general');
    }



}