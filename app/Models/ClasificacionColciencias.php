<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClasificacionColciencias extends Model
{
    protected $table = 'clasificacionescolciencias';

    protected $fillable = [
        'nombre',
        'estado',
    ];
}
