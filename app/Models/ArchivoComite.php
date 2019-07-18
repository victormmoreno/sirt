<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchivoComite extends Model
{
    protected $table = 'archivoscomites';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comite_id',
        'ruta',
    ];

    /*=========================================
    =            asesores eloquent            =
    =========================================*/

    public function getRutaAttribute($ruta)
    {
        return strtolower(trim($ruta));
    }

    /*=====  End of asesores eloquent  ======*/

    /*========================================
    =            mutador eloquent            =
    ========================================*/

    public function setRutaAttribute($ruta)
    {
        $this->attributes['ruta'] = mb_strtolower(trim($ruta),'UTF-8');
    }

    /*=====  End of mutador eloquent  ======*/
}
