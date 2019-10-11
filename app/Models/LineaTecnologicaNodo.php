<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LineaTecnologicaNodo extends Model
{
    protected $table = 'lineastecnologicas_nodos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'linea_tecnologica_id',
        'nodo_id',
        'porcentaje_linea',
    ];

    public function lineatecnologica()
    {
        return $this->belongsTo(LineaTecnologica::class, 'linea_tecnologica_id', 'id');
    }

    public function nodo()
    {
        return $this->belongsTo(Nodo::class, 'nodo_id', 'id');
    }


    /**
     * asesor para el campo porcentaje_linea.
     * @param $porcentaje_linea
     */
    public function setPorcentajeLineaAttribute($porcentaje_linea)
    {
        $this->attributes['porcentaje_linea'] = trim($porcentaje_linea);
    }

    /**
     * mutador para el campo porcentaje_linea.
     * @param $porcentaje_linea
     */
    public function getPorcentajeLineaAttribute($porcentaje_linea)
    {
        return trim($porcentaje_linea);
    }

}
