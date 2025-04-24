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

    public function city()
    {
        return $this->hasMany(Cities::class);
    }
}
