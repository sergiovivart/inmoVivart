<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

// los modelos 
use App\Models\Property;
use App\Models\Cities;
use App\Models\Provincia;


class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = Property::with('city')->get();
        return view('inmuebles.index', [
            'propiedades' => Property::all()
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $property = Property::find($id);
        if (!$property) {
            return redirect(route('admin.index'))->with('error', 'Inmueble no encontrado');
        }
        return view('admin.edit', [
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

        $property->nombre = $request->input('name');
        $property->descripcion = $request->input('description');
        // $property->precio  = $request->input('price');
        $property->provincia_id = $request->input('provincia_id');
        $property->ciudad_id = $request->input('ciudad_id');
        $property->save();

        return redirect(route('admin.index'))->with('success', 'Inmueble actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $property = Property::find($id);
        if ($property) {
            $carpeta = 'imagenes/' . $property->referencia_interna;

            if (File::exists($carpeta)) {
                File::deleteDirectory($carpeta);
            }

            $property->delete();
            return redirect(route('admin.index'))->with('success', 'Inmueble eliminado correctamente');
        } else {
            return redirect(route('admin.index'))->with('error', 'Inmueble no encontrado');
        }
    }
}
