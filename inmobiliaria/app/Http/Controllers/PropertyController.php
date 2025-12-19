<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests\PropertyStoreRequest;
use App\Http\Requests\PropertyUpdateRequest;

// los modelos 
use App\Models\Property;
use App\Models\Ciudad;
use App\Models\Provincia;


class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Property::with(['provincia', 'city']);

        // Filtrar por provincia
        if ($request->filled('provincia_id')) {
            $query->where('provincia_id', $request->provincia_id);
        }

        // Filtrar por ciudad
        if ($request->filled('ciudad_id')) {
            $query->where('ciudad_id', $request->ciudad_id);
        }

        $properties = $query->get();

        return view('inmuebles.index', [
            'propiedades' => $properties,
            'provincias' => Provincia::all(),
            'ciudades' => Ciudad::all(),
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
            'ciudades'   => Ciudad::all()
        ]);
    }


    /**
     * Store a newly created resource
     */
    public function create(PropertyStoreRequest $request)
    {
        $data = $request->validated();

        if (empty($data['referencia_interna'])) {
            $data['referencia_interna'] = 'REF' . uniqid();
        }

        $property = Property::create($data);

        // Guardar imágenes si vienen en la petición
        if ($request->hasFile('imagen')) {
            $archivos = $request->file('imagen');
            if (!is_array($archivos)) {
                $archivos = [$archivos];
            }

            $total = count($archivos);
            foreach ($archivos as $index => $archivo) {
                $extension = $archivo->getClientOriginalExtension();
                if ($total === 1) {
                    $nombreArchivo = 'foto.' . $extension;
                } else {
                    $nombreArchivo = 'foto' . ($index + 1) . '.' . $extension;
                }

                Storage::disk('public')->putFileAs('imagenes/' . $data['referencia_interna'], $archivo, $nombreArchivo);
            }
        }

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
            'ciudades' => Ciudad::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PropertyUpdateRequest $request, Property $property)
    {
        $data = $request->validated();
        $property->fill($data);
        $property->save();

        return redirect(route('admin.index'))->with('success', 'Inmueble actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        $carpeta = 'imagenes/' . $property->referencia_interna;

        if (Storage::disk('public')->exists($carpeta)) {
            Storage::disk('public')->deleteDirectory($carpeta);
        }

        $property->delete();
        return redirect(route('admin.index'))->with('success', 'Inmueble eliminado correctamente');
    }
}
