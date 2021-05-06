<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticulacionPbt extends Model
{
    protected $table = 'articulacion_pbts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'actividad_id',
        'proyecto_id',
        'fase_id',
        'tipo_articulacion_id',
        'alcance_articulacion_id',
        'entidad',
        'nombre_contacto',
        'email_entidad',
        'nombre_convocatoria',
        'objetivo',
        'lecciones_aprendidas'
    ];

    public function actividad()
    {
      return $this->belongsTo(Actividad::class, 'actividad_id', 'id');
    }

    public function proyecto()
    {
      return $this->belongsTo(Proyecto::class, 'proyecto_id', 'id');
    }

    public function fase()
    {
      return $this->belongsTo(Fase::class, 'fase_id', 'id');
    }

    public function tipoarticulacion()
    {
      return $this->belongsTo(TipoArticulacion::class, 'tipo_articulacion_id', 'id');
    }

    public function alcancearticulacion()
    {
      return $this->belongsTo(AlcanceArticulacion::class, 'alcance_articulacion_id', 'id');
    }

    public function scopeTipoArticulacion($query, $tipoArticulacion)
    {
        if (!empty($tipoArticulacion) && $tipoArticulacion != 'all' && $tipoArticulacion != null) {
            return $query->where('tipo_articulacion_id', $tipoArticulacion);
        }
        return $query;
    }

    public function scopeAlcanceArticulacion($query, $alcanceArticulacion)
    {
        if (!empty($alcanceArticulacion) && $alcanceArticulacion != 'all' && $alcanceArticulacion != null) {
            return $query->where('alcance_articulacion_id', $alcanceArticulacion);
        }
        return $query;
    }

    public function scopeNodo($query, $nodo)
    {
        if (!empty($nodo) && $nodo != null && $nodo != 'all') {
            return $query->whereHas('actividad', function ($subQuery) use ($nodo) {
                $subQuery->where('nodo_id', $nodo);
            });
        }
        return $query;
    }

    public function scopeStarEndDate($query, $year)
    {
      if (!empty($year) && $year != null && $year != 'all') {
          return $query->whereHas('actividad', function ($subQuery) use ($year) {
              $subQuery->whereYear('fecha_inicio', $year)->orWhereYear('fecha_cierre', $year);
          });
      }
      return $query;
    }
}
