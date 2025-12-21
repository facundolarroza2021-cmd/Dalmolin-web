<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Propiedad;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Storage; 

class PropiedadController extends Controller
{
    // Muestra el formulario
    public function create()
    {
        return view('admin.propiedades.create');
    }

    // Guarda los datos
    public function store(Request $request)
    {
        // 1. Validación (Seguridad básica)
        $validated = $request->validate([
            'titulo' => 'required|max:255',
            'precio' => 'required|numeric',
            'tipo_operacion' => 'required',
            'tipo_propiedad' => 'required',
            'descripcion' => 'required',
            'ciudad' => 'required',
            'imagen' => 'nullable|image|max:2048', // Máx 2MB, solo imágenes
        ]);

        // 2. Generar Slug único (SEO)
        // Si el título es "Casa Linda", el slug será "casa-linda"
        $slug = Str::slug($request->titulo);
        
        // Verificación simple para no repetir slugs (básico)
        if (Propiedad::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . time();
        }

        // 3. Subir Imagen (Si existe)
        $rutaImagen = null;
        if ($request->hasFile('imagen')) {
            // Guarda en storage/app/public/propiedades
            $rutaImagen = $request->file('imagen')->store('propiedades', 'public');
        }

        // 4. Crear en Base de Datos
        Propiedad::create([
            'titulo' => $request->titulo,
            'slug' => $slug,
            'precio' => $request->precio,
            'tipo_operacion' => $request->tipo_operacion,
            'tipo_propiedad' => $request->tipo_propiedad,
            'descripcion' => $request->descripcion,
            'ciudad' => $request->ciudad,
            'provincia' => 'Entre Ríos', // Valor por defecto o agrega el campo al form
            'imagen_principal' => $rutaImagen,
            'publicada' => true, // Publicamos directo para probar
        ]);

        // 5. Redireccionar
        return redirect()->route('admin.properties.index')
            ->with('success', '¡Propiedad creada correctamente!');
    }
    
    public function index()
    {
        // Traemos las propiedades ordenadas por fecha (más nuevas primero)
        $propiedades = Propiedad::latest()->paginate(10);
        
        return view('admin.propiedades.index', compact('propiedades'));
    }
    
    public function destroy(Propiedad $property)
    {
        // 1. Borrar imagen si existe
        if ($property->imagen_principal) {
            Storage::disk('public')->delete($property->imagen_principal);
        }

        // 2. Borrar registro
        $property->delete();

        return redirect()->route('admin.properties.index')->with('success', 'Propiedad eliminada.');
    }
}