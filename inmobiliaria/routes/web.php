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
Route::put('/admin/update/{id}',  [PropertyController::class, 'update'])->name('properties.update'); // Nueva ruta
Route::get('/admin/destroy/{id}', [PropertyController::class, 'destroy'])->name('admin.inmuebles.delete');

// rutas para las provincias y ciudades
Route::post('/provincias/store', [ProvinciaController::class, 'store'])->name('provincias.store');
Route::post('/ciudades/store',   [CiudadController::class, 'store'])->name('ciudades.store');


// subidor de imagenes
Route::any('/upload', [SubidorController::class, 'upload'])->name('upload');
