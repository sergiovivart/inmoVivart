<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// los modelos 
use App\Models\Property;
use App\Models\Ciudad;
use App\Models\Cities;
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
            'ciudades'   => Cities::all(),
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function admin(Request $request)
    {
        // Usamos 'city' porque esa es la relación definida en Property
        $properties = Property::with('city')->get();

        // return view('properties.index', compact('properties'));
        return view('admin.index', [
            'properties' => $properties,
            'provincias' => Provincia::all(),
            'ciudades'   => Cities::all()
        ]);
    }


    /**
     * Store a newly created resource
     */
    public function create(Request $request)
    {
        Property::create($request->all());
        return redirect(route('admin.index'));
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
        $property = Property::find($id);
        if (!$property) {
            return redirect(route('admin.index'))->with('error', 'Inmueble no encontrado');
        }
        return view('inmuebles.edit', [
            'property' => $property,
            'provincias' => Provincia::all(),
            'ciudades' => Cities::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $property = Property::find($id);
        if (!$property) {
            return redirect(route('admin.index'))->with('error', 'Inmueble no encontrado');
        }

        //c omo puedo actualiar solos algunos campos de los que quiero  
        $property->nombre = $request->input('name');
        $property->descripcion = $request->input('description');
        // $property->precio  = $request->input('price');
        $property->provincia_id = $request->input('provincia_id');
        $property->ciudad_id = $request->input('ciudad_id');
        $property->save();
        // o puedo usar el metodo update
        // $property->fill($request->all());
        // $property->save();

        // o puedo usar el metodo update

        // $property->update($request->all());

        return redirect(route('admin.index'))->with('success', 'Inmueble actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $property = Property::find($id);
        if ($property) {
            $property->delete();
            return redirect(route('admin.index'))->with('success', 'Inmueble eliminado correctamente');
        } else {
            return redirect(route('admin.index'))->with('error', 'Inmueble no encontrado');
        }
    }
}
