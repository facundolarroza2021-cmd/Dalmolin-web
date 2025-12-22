<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Propiedad;
use Illuminate\Http\Request;
use App\Models\Imagen;
use Illuminate\Support\Str; 

use Illuminate\Support\Facades\Storage; 

class PropiedadController extends Controller
{
    // Muestra el formulario
    public function create()
    {
        return view('admin.propiedades.create');
    }

    public function store(Request $request)
    {
        // 1. Validaciones
        $request->validate([
            'titulo' => 'required|max:255',
            'precio' => 'required|numeric',
            'tipo_operacion' => 'required',
            'tipo_propiedad' => 'required',
            'descripcion' => 'required',
            'ciudad' => 'required',
            'imagen' => 'required|image|max:2048', // Portada obligatoria
            'imagenes.*' => 'image|max:2048',      // Galería opcional
            // Campos opcionales
            'habitaciones' => 'nullable|integer',
            'banos' => 'nullable|integer',
            'cocheras' => 'nullable|integer',
            'superficie_total' => 'nullable|integer',
            'direccion' => 'nullable|string|max:255',
        ]);
    
        // Generar Slug
        $slug = Str::slug($request->titulo);
        if (Propiedad::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . time();
        }
    
        // Subir imagen de portada
        $rutaImagen = null;
        if ($request->hasFile('imagen')) {
            $rutaImagen = $request->file('imagen')->store('propiedades', 'public');
        }
    
        // 2. CREAR LA PROPIEDAD Y GUARDARLA EN LA VARIABLE $propiedad
        // 👇👇 Fíjate en el "$propiedad =" al inicio 👇👇
        $propiedad = Propiedad::create([
            'titulo' => $request->titulo,
            'slug' => $slug,
            'precio' => $request->precio,
            'moneda' => 'USD',
            'tipo_operacion' => $request->tipo_operacion,
            'tipo_propiedad' => $request->tipo_propiedad,
            'descripcion' => $request->descripcion,
            'ciudad' => $request->ciudad,
            'provincia' => 'Entre Ríos',
            'direccion' => $request->direccion,
            'habitaciones' => $request->habitaciones,
            'banos' => $request->banos,
            'cocheras' => $request->cocheras,
            'superficie_total' => $request->superficie_total,
            'imagen_principal' => $rutaImagen,
            'publicada' => true,
        ]);
    
        // 3. Guardar Galería (Ahora sí $propiedad existe)
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $foto) {
                $ruta = $foto->store('galerias', 'public');
    
                Imagen::create([
                    'propiedad_id' => $propiedad->id, // ¡Ahora esto funciona!
                    'ruta' => $ruta
                ]);
            }
        }
    
        return redirect()->route('admin.properties.index')->with('success', 'Propiedad creada con éxito.');
    }
    public function show($slug)
    {
        // Agregamos 'with('imagenes')' para traer la galería
        $propiedad = Propiedad::where('slug', $slug)
            ->where('publicada', true)
            ->with('imagenes') // <--- ESTO ES LO NUEVO
            ->firstOrFail();

        return view('public.propiedad', compact('propiedad'));
    }
    
    public function index()
    {
        // Traemos las propiedades ordenadas por fecha (más nuevas primero)
        $propiedades = Propiedad::latest()->paginate(10);
        
        return view('admin.propiedades.index', compact('propiedades'));
    }

    // Método para mostrar el formulario de edición
    public function edit(Propiedad $property)
    {
        return view('admin.propiedades.edit', ['propiedad' => $property]);
    }

    public function update(Request $request, Propiedad $property)
    {
        $validated = $request->validate([
            'titulo' => 'required|max:255',
            'precio' => 'required|numeric',
            'tipo_operacion' => 'required',
            'tipo_propiedad' => 'required',
            'descripcion' => 'required',
            'ciudad' => 'required',
            // Imagen principal es opcional al editar
            'imagen' => 'nullable|image|max:2048', 
            // Galería también es opcional
            'imagenes.*' => 'image|max:2048',
        ]);

        // 1. Cambiar Portada (Solo si subieron una nueva)
        if ($request->hasFile('imagen')) {
            if ($property->imagen_principal) {
                Storage::disk('public')->delete($property->imagen_principal);
            }
            $property->imagen_principal = $request->file('imagen')->store('propiedades', 'public');
            $property->save();
        }

        // 2. Agregar nuevas fotos a la Galería (Sin borrar las viejas)
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $foto) {
                $ruta = $foto->store('galerias', 'public');
                Imagen::create([
                    'propiedad_id' => $property->id,
                    'ruta' => $ruta
                ]);
            }
        }

        // 3. Actualizar resto de datos
        $property->update([
            'titulo' => $request->titulo,
            'precio' => $request->precio,
            'tipo_operacion' => $request->tipo_operacion,
            'tipo_propiedad' => $request->tipo_propiedad,
            'descripcion' => $request->descripcion,
            'ciudad' => $request->ciudad,
            'direccion' => $request->direccion,
            // Agrega aquí los campos de habitaciones/baños si los usas
        ]);

        return redirect()->route('admin.properties.index')->with('success', 'Propiedad actualizada correctamente.');
    }
    
    // Método para borrar una sola foto de la galería
    public function destroyImagen(Imagen $imagen)
    {
        // 1. Borrar archivo del disco
        Storage::disk('public')->delete($imagen->ruta);
        
        // 2. Borrar registro de la BD
        $imagen->delete();

        // 3. Volver atrás
        return back()->with('success', 'Imagen eliminada de la galería.');
    }
}