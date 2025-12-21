<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Propiedad;
use Illuminate\Http\Request;

class PropiedadController extends Controller
{
    public function show($slug)
    {
        // Buscamos la propiedad activa por su slug
        $propiedad = Propiedad::where('slug', $slug)
            ->where('publicada', true)
            ->firstOrFail(); // Si no existe, da error 404 automáticamente

        return view('public.propiedad', compact('propiedad'));
    }
}