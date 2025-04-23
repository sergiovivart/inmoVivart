<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ProvinciaController;
use App\Http\Controllers\CiudadController;


Route::get('/', function () {
    return redirect(route('inmuebles.index'));
});

// rutas usuarios
Route::get('/inmuebles', [PropertyController::class, 'index'])->name('inmuebles.index');

// rutas administrador
Route::get('/admin', [PropertyController::class, 'admin'])->name('admin.index');
Route::post('/admin/create', [PropertyController::class, 'create'])->name('admin.inmuebles.create');

// las provincioas y ciudades
Route::get('/provincias', [ProvinciaController::class, 'index'])->name('provincias.index');
Route::post('/provincias/store', [ProvinciaController::class, 'store'])->name('provincias.store');

Route::get('/ciudades', [CiudadController::class, 'index'])->name('ciudades.index');
Route::post('/ciudades/store', [CiudadController::class, 'store'])->name('ciudades.store');
