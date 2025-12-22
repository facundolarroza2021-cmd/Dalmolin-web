<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Propiedad;
use Illuminate\Http\Request;

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
}