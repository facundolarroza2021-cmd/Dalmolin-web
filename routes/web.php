<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\PropiedadController;
use App\Http\Controllers\Admin\PropiedadController as AdminPropiedadController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ESTA es la línea clave. Debe apuntar a tu HomeController, NO a 'welcome'
Route::get('/', [HomeController::class, 'index'])->name('home');

// Detalle de propiedad
Route::get('/propiedad/{slug}', [PropiedadController::class, 'show'])->name('public.propiedad.show');

// Rutas de Autenticación y Admin (Laravel Breeze)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('properties', AdminPropiedadController::class);
});

require __DIR__.'/auth.php';