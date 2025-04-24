<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{

    protected $table = 'properties'; // 👈 Solución al problema

    protected $fillable = [
        'referencia_interna',
        'nombre',
        'descripcion',
        'precio',
        'superficie',
        'habitaciones',
        'baños',
        'provincia_id',
        'ciudad_id',
        'calle'
    ];


    public function city()
    {
        // Especificamos la clave foránea si no es convencional
        return $this->belongsTo(Cities::class, 'ciudad_id');
    }

    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'provincia_id');
    }
}
