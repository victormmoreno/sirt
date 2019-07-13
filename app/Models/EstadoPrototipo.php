<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoPrototipo extends Model
{
    protected $table = 'estadosprototipos';

    protected $fillable = [
        'nombre',
    ];
}
