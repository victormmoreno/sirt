<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{

    protected $table = 'videos';

    protected $fillable = [
        'servidor_video_id',
        'ruta',
    ];

    public function servidorvideo()
    {
        return $this->belongsTo(ServidorVideo::class, 'servidor_video_id', 'id');
    }

    public function videoble()
    {
        return $this->morphTo();
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
