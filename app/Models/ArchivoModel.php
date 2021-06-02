<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchivoModel extends Model
{

    protected $table = 'archivo_model';

    protected $fillable = [
        'ruta',
        'fase_id'
    ];


    public function archivomodel()
    {
        return $this->morphTo();
    }

    public function fase()
    {
      return $this->belongsTo(Fase::class, 'fase_id', 'id');
    }

    /*=========================================
    =            asesores eloquent            =
    =========================================*/

    public function getDominoAttribute($ruta)
    {
        return mb_strtolower(trim($ruta), 'UTF-8');
    }   

    /*=====  End of asesores eloquent  ======*/

    /*========================================
    =            mutador eloquent            =
    ========================================*/
    public function setDominoAttribute($ruta)
    {
        $this->attributes['ruta'] = mb_strtolower(trim($ruta), 'UTF-8');
    }

    /*=====  End of mutador eloquent  ======*/
}

