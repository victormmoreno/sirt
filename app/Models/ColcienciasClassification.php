<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ColcienciasClassification extends Model
{
    protected $table = 'clasificacioncolciencias';

    public $primaryKey = 'idclasificacioncolciencias';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'descripcion',
    ];
}
