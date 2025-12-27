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
            'estado' => 'required|in:disponible,reservado,vendido,alquilado',
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
            'estado' => $request->estado,
            'moneda' => 'USD',
            'tipo_operacion' => $request->tipo_operacion,
            'tipo_propiedad' => $request->tipo_propiedad,
            'descripcion' => $request->descripcion,
            'meta_descripcion' => $request->meta_descripcion ?? Str::limit("Propiedad en " . $request->tipo_operacion . " en " . $request->ciudad . ". " . $request->descripcion, 155),
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
    
    public function index(Request $request)
    {
        // Iniciamos la consulta
        $query = Propiedad::query();
    
        // Si hay una búsqueda, aplicamos el filtro
        if ($request->has('search')) {
            $search = $request->get('search');
            
            $query->where(function($q) use ($search) {
                $q->where('titulo', 'LIKE', "%{$search}%")
                  ->orWhere('ciudad', 'LIKE', "%{$search}%")
                  ->orWhere('tipo_operacion', 'LIKE', "%{$search}%"); // Agregué este extra por si buscan "Alquiler"
            });
        }
    
        // Ordenamos por fecha y paginamos manteniendo el filtro en los links
        $propiedades = $query->latest()
            ->paginate(10)
            ->withQueryString(); 
    
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
            'estado' => 'required',
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
            'estado' => $request->estado,
            'tipo_operacion' => $request->tipo_operacion,
            'tipo_propiedad' => $request->tipo_propiedad,
            'descripcion' => $request->descripcion,
            'ciudad' => $request->ciudad,
            'direccion' => $request->direccion,
            // Agrega aquí los campos de habitaciones/baños si los usas
        ]);

        return redirect()->route('admin.properties.index')->with('success', 'Propiedad actualizada correctamente.');
    }
    
    public function destroy($id)
    {
        // 1. Buscar la propiedad
        $propiedad = Propiedad::findOrFail($id);

        // 2. Eliminar la imagen de portada del disco (Storage)
        if ($propiedad->imagen_principal) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($propiedad->imagen_principal);
        }

        // 3. Eliminar las imágenes de la galería del disco
        foreach ($propiedad->imagenes as $imagen) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($imagen->ruta);
        }

        // 4. Eliminar los registros de las fotos de la galería en BD
        $propiedad->imagenes()->delete();

        // 5. Eliminar la propiedad de la base de datos
        $propiedad->delete();

        return redirect()->route('admin.properties.index')
        ->with('success', 'La propiedad fue eliminada correctamente.');
    }
    // Método para eliminar una imagen individual de la galería
    public function destroyImagen($id)
    {
        // 1. Buscar la imagen
        $imagen = Imagen::findOrFail($id);
        
        // 2. Borrar archivo del disco (Storage)
        if(\Illuminate\Support\Facades\Storage::disk('public')->exists($imagen->ruta)){
            \Illuminate\Support\Facades\Storage::disk('public')->delete($imagen->ruta);
        }

        // 3. Borrar registro de la BD
        $imagen->delete();

        return back()->with('success', 'Imagen eliminada de la galería.');
    }

    public function toggle($id, Request $request)
    {
        $propiedad = Propiedad::findOrFail($id);
        
        // Detectamos qué botón apretaste: 'publicada' o 'destacada'
        $campo = $request->input('field');

        if (in_array($campo, ['publicada', 'destacada'])) {
            // Invertimos el valor (true -> false, false -> true)
            $propiedad->$campo = ! $propiedad->$campo;
            $propiedad->save();
            
            return back()->with('success', 'Estado actualizado correctamente.');
        }

        return back()->with('error', 'Acción no válida.');
    }
}