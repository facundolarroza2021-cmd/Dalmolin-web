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
Route::get('/nosotros', [HomeController::class, 'nosotros'])->name('public.nosotros');

// Catálogo y Filtros (Importante: poner antes de /{slug} para evitar conflictos)
Route::get('/propiedades/{operacion?}/{tipo?}', [PropiedadController::class, 'index'])
    ->where('operacion', 'venta|alquiler|temporal')
    ->name('public.listado');

// Detalle de Propiedad
Route::get('/propiedad/{slug}', [PropiedadController::class, 'show'])->name('public.propiedad.show');

Route::get('/propiedad/quick-view/{id}', [PropiedadController::class, 'quickView'])->name('public.quickview');
// =========================================================================
// 2. PANEL DE ADMINISTRACIÓN (Requiere Login)
// =========================================================================

Route::middleware(['auth', 'verified'])->group(function () {

    Route::patch('/admin/properties/{id}/toggle', [\App\Http\Controllers\Admin\PropiedadController::class, 'toggle'])
         ->name('admin.propiedades.toggle');
    // Dashboard (Estadísticas)
// Dashboard (Estadísticas Mejoradas)
    Route::get('/dashboard', function () {
        // 1. Totales
        $total = Propiedad::count();
        
        // 2. Desglose por Estado (KPIs)
        $disponibles = Propiedad::where('estado', 'disponible')->count();
        $reservadas  = Propiedad::where('estado', 'reservado')->count();
        $vendidas    = Propiedad::where('estado', 'vendido')->count();
        
        // 3. Últimas 5 cargadas
        $ultimas = Propiedad::latest()->take(5)->get();

        return view('dashboard', compact('total', 'disponibles', 'reservadas', 'vendidas', 'ultimas'));
    })->name('dashboard');

    // Rutas de Admin (Prefijo: /admin)
    Route::prefix('admin')->name('admin.')->group(function () {
        
        // CRUD Completo de Propiedades
        Route::resource('properties', AdminPropiedadController::class);
        
        // Borrar imagen de galería (Método DELETE seguro)
        Route::get('/imagen/{id}/delete', [AdminPropiedadController::class, 'destroyImagen'])
            ->name('imagen.destroy');
    });

    // Perfil de Usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas de Autenticación (Login, Registro, etc.)
require __DIR__.'/auth.php';