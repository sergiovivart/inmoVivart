<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    //
    protected $table = 'provincias'; // 👈 Solución al problema

    protected $fillable = [
        'nombre'
    ];

    // Relación: una provincia tiene muchas ciudades
    public function cities()
    {
        return $this->hasMany(Ciudad::class);
    }
}
