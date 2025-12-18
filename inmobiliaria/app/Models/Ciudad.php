<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    protected $table = 'cities'; // mantiene el nombre de la tabla en plural

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
