<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PropertyUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $propertyId = $this->route('property') ? $this->route('property')->id : null;

        return [
            'referencia_interna' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('properties', 'referencia_interna')->ignore($propertyId),
            ],
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'superficie' => 'required|numeric',
            'habitaciones' => 'required|integer',
            'baños' => 'required|integer',
            'provincia_id' => 'required|exists:provincias,id',
            'ciudad_id' => 'required|exists:cities,id',
            'calle' => 'required|string|max:255',
            'imagen' => 'nullable',
            'imagen.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}
