<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SubidorController extends Controller
{
    //
    public function upload(Request $request)
    {

        // Validar la solicitud
        $referencia = $request->input('referencia');
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $archivo = $request->file('imagen');

        // Crear nombre único de carpeta si no existe
        $rutaCarpeta = public_path('imagenes/' . $referencia);

        if (!File::exists($rutaCarpeta)) {
            File::makeDirectory($rutaCarpeta, 0755, true);
        }

        // Guardar archivo
        $nombreArchivo = 'foto' . '.' . $archivo->getClientOriginalExtension();
        $archivo->move($rutaCarpeta, $nombreArchivo);

        // como puedo regresar al mismo formulario pero con un parametro pasado por la URL
        return redirect('/admin?ref=' . $referencia)->with('success', 'Imagen subida con éxito');
    }
}
