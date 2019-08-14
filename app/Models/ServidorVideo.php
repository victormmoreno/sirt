<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServidorVideo extends Model
{

	protected $table = 'servidor_videos';

    protected $fillable = [
        'nombre',
        'dominio',
    ];

    /*=========================================
    =            asesores eloquent            =
    =========================================*/

    public function getNombreAttribute($nombre)
    {
        return ucwords(mb_strtolower(trim($nombre),'UTF-8'));
    }

    public function getDominoAttribute($dominio)
    {
        return mb_strtolower(trim($dominio),'UTF-8');
    }

    /*=====  End of asesores eloquent  ======*/

    /*========================================
    =            mutador eloquent            =
    ========================================*/
    public function setDominoAttribute($dominio)
    {
        $this->attributes['dominio'] = mb_strtolower(trim($dominio),'UTF-8');
    }

    public function setNombreAttribute($nombre)
    {
        $this->attributes['nombre'] = ucwords(mb_strtolower(trim($nombre),'UTF-8'));
    }

    /*=====  End of mutador eloquent  ======*/

    public function videos()
    {
        return $this->hasMany(Video::class, 'servidor_video_id', 'id');
    }
}
