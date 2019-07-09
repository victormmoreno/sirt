<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreaConocimiento extends Model
{
    protected $table = 'areasconocimiento';

    protected $fillable = [
        'nombre'
    ];

    // Scope para consultar las áreas de conocmiento
    public function scopeConsultarAreasConocimiento($query)
    {
      return $query->select('id', 'nombre')
      ->orderBy('nombre', 'asc');
    }

}
