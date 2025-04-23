<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// los modelos 
use App\Models\Property;
use App\Models\Ciudad;
use App\Models\Provincia;


class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 
        return view('inmuebles.index', [
            'properties' => Property::all(),
            'provincias' => Provincia::all(),
            'ciudades'   => Ciudad::all(),
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function admin(Request $request)
    {
        // dd($request->all());
        return view('admin.index', [
            'properties' => Property::all(),
            'provincias' => Provincia::all(),
            'ciudades'   => Ciudad::all()
        ]);
    }


    /**
     * Store a newly created resource
     */
    public function create(Request $request)
    {
        // dd($request->all());
        $property = new Property();
        $property->referencia_interna = $request->referencia_interna;
        $property->nombre             = $request->nombre;
        $property->descripcion        = $request->descripcion;
        $property->precio             = $request->precio;
        $property->superficie         = $request->superficie;
        $property->habitaciones       = $request->habitaciones;
        $property->baños              = $request->baños;
        $property->provincia_id       = $request->provincia_id;
        $property->ciudad_id          = $request->ciudad_id;
        $property->calle              = $request->calle;
        $property->save();

        return redirect(route('admin.inmuebles.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
