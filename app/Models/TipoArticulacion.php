<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoArticulacion extends Model
{
    protected $table = 'tiposarticulaciones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
    ];
}
