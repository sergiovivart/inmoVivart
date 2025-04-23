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

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class);
    }

    public function provincia()
    {
        return $this->belongsTo(Provincia::class);
    }
}
