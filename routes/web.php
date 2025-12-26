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

// 1. RUTA PRINCIPAL (Home Público)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Ruta de Contacto
Route::get('/contacto', [HomeController::class, 'contacto'])->name('public.contacto');

// 2. Ruta de Detalle de Propiedad (Pública)
Route::get('/propiedad/{slug}', [PropiedadController::class, 'show'])->name('public.propiedad.show');

// 3. Rutas de Autenticación y Admin (Dashboard)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('properties', AdminPropiedadController::class);
    Route::get('/imagen/{imagen}/delete', [AdminPropiedadController::class, 'destroyImagen'])->name('imagen.delete');
});

Route::get('/dashboard', function () {
    // Calculamos las estadísticas en tiempo real
    $totalPropiedades = Propiedad::count();
    $enVenta = Propiedad::where('tipo_operacion', 'venta')->count();
    $enAlquiler = Propiedad::where('tipo_operacion', 'alquiler')->count();
    
    // Traemos las últimas 3 propiedades cargadas para mostrar un resumen
    $ultimas = Propiedad::latest()->take(3)->get();

    return view('dashboard', compact('totalPropiedades', 'enVenta', 'enAlquiler', 'ultimas'));
})->middleware(['auth', 'verified'])->name('dashboard');

// 4. RUTAS DE PERFIL (Esto es lo que faltaba)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Ruta mágica para listados (Venta, Alquiler, por Tipo, etc.)
Route::get('/propiedades/{operacion?}/{tipo?}', [PropiedadController::class, 'index'])
    ->where('operacion', 'venta|alquiler|temporal') // Opcional: restringe palabras válidas
    ->name('public.listado');
require __DIR__.'/auth.php';