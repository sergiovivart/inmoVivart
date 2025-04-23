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

    // Define any model-specific logic or properties here
    // public function ciudades()
    // {
    //     return $this->hasMany(Ciudad::class);
    // }

    public function cities()
    {
        return $this->hasMany(Cities::class);
    }
}
