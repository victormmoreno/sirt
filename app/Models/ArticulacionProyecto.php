<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticulacionProyecto extends Model
{


    public static function habilitarTalentos($articulacion_proyecto)
    {
        foreach ($articulacion_proyecto->talentos as $value) {
            $value->user()->withTrashed()->first()->restore();
            $value->user()->withTrashed()->first()->update(['estado' => 1]);
        }
    }

    protected $table = 'articulacion_proyecto';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entidad_id',
        'actividad_id',
        'aprobacion_dinamizador_ejecucion',
        'aprobacion_dinamizador_suspender',
        'acta_cierre'
    ];

    /**
     * Relación muchos a muchos con la tabla de talentos
     * @return Eloquent
     * @author dum
     */
    public function talentos()
    {
        return $this->belongsToMany(Talento::class, 'articulacion_proyecto_talento')
            ->withTimestamps()
            ->withPivot('talento_lider');
    }

    public function actividad()
    {
        return $this->belongsTo(Actividad::class, 'actividad_id', 'id');
    }

    public function proyecto()
    {
        return $this->hasOne(Proyecto::class, 'articulacion_proyecto_id', 'id');
    }

    public function entidad()
    {
        return $this->belongsTo(Entidad::class, 'entidad_id', 'id');
    }
}
