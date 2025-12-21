<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Propiedad;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Iniciamos la consulta
        $query = Propiedad::activas(); // Usamos el scope que definimos antes

        // 1. Filtro por Ubicación (Buscador simple)
        if ($request->filled('ubicacion')) {
            $query->where('ciudad', 'like', '%' . $request->ubicacion . '%')
                  ->orWhere('titulo', 'like', '%' . $request->ubicacion . '%');
        }

        // 2. Filtro por Tipo de Propiedad
        if ($request->filled('tipo_propiedad')) {
            $query->where('tipo_propiedad', $request->tipo_propiedad);
        }

        // 3. Ordenamiento (Opcional, por defecto mas recientes)
        $query->latest('created_at');

        // Ejecutamos la consulta con paginación (12 propiedades por página)
        $propiedades = $query->paginate(12);

        return view('public.home', compact('propiedades'));
    }
}