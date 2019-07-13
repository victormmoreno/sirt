<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sublinea extends Model
{
    protected $table = 'sublineas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lineatecnologica_id',
        'nombre',
    ];


     /*================================================
    =            mutador para el nombre            =
    ================================================*/

    public function setNombreAttribute($nombre)
    {
        $this->attributes['nombre'] = strtolower($nombre);
        $this->attributes['nombre'] = ucfirst($nombre);
    }


    /*=====  End of mutador para el nombre  ======*/


    /*===========================================
    =            relaciones eloquent            =
    ===========================================*/
    public function linea()
    {
        return $this->belongsTo(LineaTecnologica::class, 'lineatecnologica_id', 'id');
    }


    /*=====  End of relaciones eloquent  ======*/

    /*===========================================
    =            scope para consultar todas las lineass            =
    ===========================================*/
    public function scopeAllSublineas($query)
    {
        return $query;
    }

    /*=====  End of scope para consultar todas las lineass  ======*/

    public function scopeSubLineasDeUnaLinea($query, $id)
    {
      return $query->select('sublineas.id')
      ->selectRaw('concat(lineastecnologicas.abreviatura, " - ", sublineas.nombre) AS nombre')
      ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'sublineas.lineatecnologica_id')
      ->where('lineastecnologicas.id', $id);
    }
}
