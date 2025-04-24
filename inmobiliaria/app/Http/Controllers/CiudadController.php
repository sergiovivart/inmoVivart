<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use App\Models\Cities;
use Illuminate\Http\Request;

//los modelos
// use App\Models\Ciudad;
// use App\Models\Ciudad; // Correct model
use App\Models\Provincia;
use Database\Seeders\CiudadSeeder;


class CiudadController extends Controller
{
    //
    public function index()
    {
        $provincias = Provincia::all();
        return view('ciudades.index', compact('provincias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'provincia_id' => 'required|exists:provincias,id',
        ]);

        Cities::create([
            'nombre'       => $request->nombre,
            'provincia_id' => $request->provincia_id,
        ]);



        return redirect()->route('admin.index')->with('success', 'Ciudad creada.');
    }
}
