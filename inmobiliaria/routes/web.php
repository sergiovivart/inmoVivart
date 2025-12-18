<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ProvinciaController;
use App\Http\Controllers\CiudadController;
use App\Http\Controllers\SubidorController;

Route::get('/', function () {
    return redirect(route('inmuebles.index'));
});

// rutas usuarios
Route::get('/inmuebles', [PropertyController::class, 'index'])->name('inmuebles.index');

// rutas administrador
Route::get('/admin',              [PropertyController::class, 'admin'])->name('admin.index');
Route::post('/admin/create',      [PropertyController::class, 'create'])->name('admin.inmuebles.create');
Route::get('/admin/edit/{id}',    [PropertyController::class, 'edit'])->name('admin.inmuebles.edit');
Route::put('/admin/update/{property}',  [PropertyController::class, 'update'])->name('properties.update'); // Nueva ruta
Route::get('/admin/destroy/{property}', [PropertyController::class, 'destroy'])->name('admin.inmuebles.delete');

// rutas para las provincias y ciudades
Route::post('/provincias/store', [ProvinciaController::class, 'store'])->name('provincias.store');
Route::post('/ciudades/store',   [CiudadController::class, 'store'])->name('ciudades.store');

// API: obtener ciudades por provincia (AJAX)
Route::get('/provincias/{id}/ciudades', [CiudadController::class, 'byProvincia'])->name('provincias.ciudades');

// subidor de imagenes
Route::any('/upload', [SubidorController::class, 'upload'])->name('upload');
