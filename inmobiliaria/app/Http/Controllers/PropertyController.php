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
