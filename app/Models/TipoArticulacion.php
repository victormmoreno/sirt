<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoArticulacion extends Model
{
    protected $table = 'tipo_articulaciones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
    ];

    

}
