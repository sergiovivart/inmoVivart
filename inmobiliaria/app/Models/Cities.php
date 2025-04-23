<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{

    protected $table = 'cities'; // Especifica el nombre correcto de la tabla

    protected $fillable = ['nombre', 'provincia_id'];

    public function provincia()
    {
        return $this->belongsTo(Provincia::class);
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
