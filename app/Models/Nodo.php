<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nodo extends Model
{
    protected $table = 'nodos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'direccion',
        'anho_inicio',
        'centroformacion_id',
    ];

    public function centroFormacion()
    {
        return $this->belongsTo(CentroFormacion::class, 'centroformacion_id', 'id');
    }
}
