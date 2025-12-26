<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Propiedad;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

        // 2. Generar Schema.org (SEO)para evitar errores en la vista
        $schema = [
            "@context" => "https://schema.org",
            "@type" => "RealEstateListing",
            "name" => $propiedad->titulo,
            "image" => [asset('storage/' . $propiedad->imagen_principal)],
            "description" => \Illuminate\Support\Str::limit($propiedad->descripcion, 160),
            "url" => url()->current(),
            "address" => [
                "@type" => "PostalAddress",
                "addressLocality" => $propiedad->ciudad,
                "addressRegion" => "Entre Ríos",
                "addressCountry" => "AR"
            ],
            "price" => $propiedad->precio,
            "priceCurrency" => $propiedad->moneda
        ];

        // Agregar imágenes de la galería al Schema
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
        // 1. Iniciar Query base
        $query = Propiedad::where('publicada', true);
        $titulo = 'Todas las Propiedades';
    
        // 2. Filtros de Ruta (URL amigable)
        if ($operacion) {
            $query->where('tipo_operacion', $operacion);
            $titulo = ucfirst($operacion);
        }
    
        if ($tipo) {
            $query->where('tipo_propiedad', $tipo);
            $plural = Str::plural(ucfirst($tipo));
            $titulo = $operacion ? "$plural en " . ucfirst($operacion) : $plural;
        }
    
        // 3. --- NUEVOS FILTROS (Query Strings) ---
    
        // Habitaciones (Mayor o igual)
        if ($request->filled('habitaciones')) {
            $query->where('habitaciones', '>=', $request->habitaciones);
        }
    
        // Baños (Mayor o igual)
        if ($request->filled('banos')) {
            $query->where('banos', '>=', $request->banos);
        }
    
        // Cocheras (Exacto o Mayor o igual)
        if ($request->filled('cocheras')) {
            if ($request->cocheras == 'si') {
                $query->where('cocheras', '>=', 1);
            } else {
                $query->where('cocheras', '>=', $request->cocheras);
            }
        }
    
        // Rango de Precio
        if ($request->filled('precio_min')) {
            $query->where('precio', '>=', $request->precio_min);
        }
        if ($request->filled('precio_max')) {
            $query->where('precio', '<=', $request->precio_max);
        }
    
        // Ciudad (Buscador por texto)
        if ($request->filled('ciudad')) {
            $query->where('ciudad', 'like', '%' . $request->ciudad . '%');
        }
    
        // 4. Ordenamiento (Opcional: Más recientes primero)
        if ($request->has('orden')) {
            if ($request->orden == 'precio_asc') $query->orderBy('precio', 'asc');
            elseif ($request->orden == 'precio_desc') $query->orderBy('precio', 'desc');
            else $query->latest();
        } else {
            $query->latest();
        }
    
        // 5. Paginación (¡Importante! Mantener filtros en los links de página)
        $propiedades = $query->paginate(12)->withQueryString();
    
        return view('public.listado')
            ->with('propiedades', $propiedades)
            ->with('titulo', $titulo);
    }
}