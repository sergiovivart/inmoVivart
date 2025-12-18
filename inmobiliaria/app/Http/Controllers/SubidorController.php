<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SubidorController extends Controller
{
    //
    public function upload(Request $request)
    {

        // Validar la solicitud (soporta un archivo o varios)
        $referencia = $request->input('referencia');
        $request->validate([
            'imagen' => 'required',
            'imagen.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

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

            Storage::disk('public')->putFileAs('imagenes/' . $referencia, $archivo, $nombreArchivo);
        }

        // como puedo regresar al mismo formulario pero con un parametro pasado por la URL
        return redirect('/admin?ref=' . $referencia)->with('success', 'Imagen subida con éxito');
    }
}
