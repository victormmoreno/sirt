<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Entrenamiento extends Model
{
    // use Notifiable;
    protected $table = 'entrenamientos';

    protected $casts = [
        'fecha_sesion1' => 'date:Y-m-d',
        'fecha_sesion2' => 'date:Y-m-d',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fecha_sesion1',
        'fecha_sesion2',
        'codigo_entrenamiento',
        'correos',
        'fotos',
        'listado_asistencia',
    ];

    public function rutamodel()
    {
        return $this->morphMany(RutaModel::class, 'model');
    }

    public function entrenamientosideas()
    {
        return $this->hasMany(EntrenamientoIdea::class, 'entrenamiento_id', 'id');
    }

    /*=========================================
  =            asesores eloquent            =
  =========================================*/

    public function getFechaSession1Attribute($fecha_sesion1)
    {
        return Carbon::parse($fecha_sesion1)->format('Y-m-d');
    }

    public function getFechaSession2Attribute($fecha_sesion2)
    {
        return Carbon::parse($fecha_sesion2)->format('Y-m-d');
    }
    /*=====  End of asesores eloquent  ======*/

    /*========================================
  =            mutador eloquent            =
  ========================================*/

    public function setFechaSession1Attribute($fecha_sesion1)
    {
        $this->attributes['fecha_sesion1'] = Carbon::parse($fecha_sesion1)->format('Y-m-d');
    }

    public function setFechaSession2Attribute($fecha_sesion2)
    {
        $this->attributes['fecha_sesion2'] = Carbon::parse($fecha_sesion2)->format('Y-m-d');
    }

    /*=====  End of mutador eloquent  ======*/
}
