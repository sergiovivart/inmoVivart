<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use Illuminate\Http\Request;

use App\Models\Provincia;


class CiudadController extends Controller
{
    //
    public function index()
    {
        $provincias = Provincia::all();
        return view('ciudades.index', compact('provincias'));
    }

    /**
     * Devuelve ciudades por provincia en JSON (para uso AJAX)
     */
    public function byProvincia($provinciaId)
    {
        $ciudades = Ciudad::where('provincia_id', $provinciaId)->get();
        return response()->json($ciudades);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'provincia_id' => 'required|exists:provincias,id',
        ]);

        Ciudad::create([
            'nombre'       => $request->nombre,
            'provincia_id' => $request->provincia_id,
        ]);

        return redirect()->route('admin.index')->with('success', 'Ciudad creada.');
    }
}
