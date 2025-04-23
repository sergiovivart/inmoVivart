<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provincia;

class ProvinciaController extends Controller
{
    //
    public function index()
    {
        return view('provincias.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        // Crear la provincia
        Provincia::create(['nombre' => $request->nombre]);

        return redirect()->route('admin.index')->with('success', 'Provincia creada.');
    }
}
