<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PropertyController;

Route::get('/', function () {
    return redirect(route('inmuebles.index'));
});

// rutas usuarios
Route::get('/inmuebles', [PropertyController::class, 'index'])->name('inmuebles.index');

// rutas administrador
Route::get('/admin', [PropertyController::class, 'admin'])->name('admin.index');
Route::post('/admin/create', [PropertyController::class, 'create'])->name('admin.inmuebles.create');
