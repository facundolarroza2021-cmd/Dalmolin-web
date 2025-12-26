<?php

use Illuminate\Support\Facades\Route;
use App\Models\Propiedad;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\PropiedadController;
use App\Http\Controllers\Admin\PropiedadController as AdminPropiedadController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =========================================================================
// 1. RUTAS PÚBLICAS (Accesibles para todos)
// =========================================================================

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Páginas Estáticas
Route::get('/contacto', [HomeController::class, 'contacto'])->name('public.contacto');

// Catálogo y Filtros (Importante: poner antes de /{slug} para evitar conflictos)
Route::get('/propiedades/{operacion?}/{tipo?}', [PropiedadController::class, 'index'])
    ->where('operacion', 'venta|alquiler|temporal')
    ->name('public.listado');

// Detalle de Propiedad
Route::get('/propiedad/{slug}', [PropiedadController::class, 'show'])->name('public.propiedad.show');


// =========================================================================
// 2. PANEL DE ADMINISTRACIÓN (Requiere Login)
// =========================================================================

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard (Estadísticas)
    Route::get('/dashboard', function () {
        $totalPropiedades = Propiedad::count();
        $enVenta = Propiedad::where('tipo_operacion', 'venta')->count();
        $enAlquiler = Propiedad::where('tipo_operacion', 'alquiler')->count();
        
        // Últimas 5 cargadas para acceso rápido
        $ultimas = Propiedad::latest()->take(5)->get();

        return view('dashboard', compact('totalPropiedades', 'enVenta', 'enAlquiler', 'ultimas'));
    })->name('dashboard');

    // Rutas de Admin (Prefijo: /admin)
    Route::prefix('admin')->name('admin.')->group(function () {
        
        // CRUD Completo de Propiedades
        Route::resource('properties', AdminPropiedadController::class);
        
        // Borrar imagen de galería (Método DELETE seguro)
        Route::delete('/imagen/{id}/delete', [AdminPropiedadController::class, 'destroyImagen'])
            ->name('imagen.delete');
    });

    // Perfil de Usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas de Autenticación (Login, Registro, etc.)
require __DIR__.'/auth.php';