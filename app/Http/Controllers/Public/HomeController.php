<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Propiedad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // 1. Contar propiedades activas
        $conteos = Propiedad::where('publicada', true)
            ->select('tipo_propiedad', DB::raw('count(*) as total'))
            ->groupBy('tipo_propiedad')
            ->pluck('total', 'tipo_propiedad')
            ->all();

        // 2. Definición completa de categorías con tus imágenes
        $categorias = [
            'casa' => [
                'label' => 'Casas', 
                'img' => 'https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=800&q=80'
            ],
            'departamento' => [
                'label' => 'Departamentos', 
                'img' => 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=800&q=80'
            ],
            'quinta' => [
                'label' => 'Quintas', 
                'img' => 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800&q=80'
            ],
            'terreno' => [
                'label' => 'Terrenos', 
                'img' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=800&q=80'
            ],
            'campo' => [
                'label' => 'Campos', 
                'img' => 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=800&q=80'
            ],
            'cochera' => [
                'label' => 'Cocheras', 
                'img' => 'https://images.unsplash.com/photo-1590674899484-d5640e854abe?w=800&q=80'
            ],
            'fondo_comercio' => [
                'label' => 'Fondos de Comercio', 
                'img' => 'https://images.unsplash.com/photo-1556761175-b413da4baf72?w=800&q=80'
            ],
            'galpon' => [
                'label' => 'Galpones', 
                'img' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=800&q=80'
            ],
            'local' => [
                'label' => 'Locales', 
                'img' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=800&q=80'
            ],
            'edificio' => [
                'label' => 'Edificios', 
                'img' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=800&q=80'
            ],
            'hotel' => [
                'label' => 'Hoteles', 
                'img' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&q=80'
            ],
        ];

        // 3. Filtrado (sin cambios)
        $query = Propiedad::query()->where('publicada', true);
        if ($request->filled('tipo')) {
            $query->where('tipo_propiedad', $request->tipo);
        }
        if ($request->has('nuevo')) {
            $query->latest();
        }
        $propiedades = $query->latest()->take(6)->get();

        return view('public.home', compact('propiedades', 'conteos', 'categorias'));
    }
}