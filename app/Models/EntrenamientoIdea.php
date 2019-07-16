<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntrenamientoIdea extends Model
{
    protected $table = 'entrenamiento_idea';

    protected $fillable = [
        'idea_id',
        'entrenamiento_id',
        'confirmacion',
        'canvas',
        'asistencia1',
        'asistencia2',
        'convocado_csibt',
    ];

    /*========================================
    =            mutador eloquent            =
    ========================================*/

    public function setConfirmacionAttribute($confirmacion)
    {
        $this->attributes['confirmacion'] = trim($confirmacion);
    }

    public function setCanvasAttribute($canvas)
    {
        $this->attributes['canvas'] = trim($canvas);
    }

    public function setAsistencia1Attribute($asistencia1)
    {
        $this->attributes['asistencia1'] = trim($asistencia1);
    }

    public function setAsistencia2Attribute($asistencia2)
    {
        $this->attributes['asistencia2'] = trim($asistencia2);
    }

    public function setConvocadoCsibtAttribute($convocado_csibt)
    {
        $this->attributes['convocado_csibt'] = trim($convocado_csibt);
    }

    /*=====  End of mutador eloquent  ======*/

}
