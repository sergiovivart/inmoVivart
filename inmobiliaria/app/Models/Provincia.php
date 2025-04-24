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

    public function cities()
    {
        return $this->hasMany(Cities::class);
    }
}
