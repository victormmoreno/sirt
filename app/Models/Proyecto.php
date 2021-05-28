<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\ArticulacionPbt;

class Proyecto extends Model
{

  protected $table = 'proyectos';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'articulacion_proyecto_id', // Llave foranea
    'idea_id', // Llave foranea
    'sublinea_id', // Llave foranea
    'areaconocimiento_id', // Llave foranea
    'economia_naranja',
    'art_cti',
    'nom_act_cti',
    'diri_ar_emp',
    'reci_ar_emp',
    'acc',
    'manual_uso_inf',
    'estado_arte',
    'alcance_proyecto',
    'tipo_economianaranja',
    'dirigido_discapacitados',
    'tipo_discapacitados',
    'otro_areaconocimiento',
    'trl_esperado',
    'trl_obtenido',
    'fase_id',
    'fabrica_productividad',
    'doc_titular',
    'trl_prototipo',
    'trl_pruebas',
    'trl_modelo',
    'trl_normatividad',
    'evidencia_trl'
  ];

  /**
   * Constante para el campo trl_esperado
   */
  // Estado que indica que el trl esperado es 6
  const IS_TRL6_ESPERADO = 0;
  // Estado que indica que el trl esperado es 7 u 8
  const IS_TRL7_8_ESPERADO = 1;

  // Retorna para las constantes del campo trl_esperado
  public static function IsTrl6Esperado()
  {
    return self::IS_TRL6_ESPERADO;
  }

  public static function IsTrl78Esperado()
  {
    return self::IS_TRL7_8_ESPERADO;
  }

  /*===============================================
  =            relaciones polimorficas            =
  ===============================================*/

  // Relación a la tabla de archivosproyecto
  // public function archivosproyecto()
  // {
  //     return $this->hasMany(ArchivoProyecto::class, 'proyecto_id', 'id');
  // }

  public function empresas()
  {
    return $this->morphedByMany(Empresa::class, 'propietario')->withTimestamps();
  }

  public function gruposinvestigacion()
  {
    return $this->morphedByMany(GrupoInvestigacion::class, 'propietario')->withTimestamps();
  }

  public function users_propietarios()
  {
    return $this->morphedByMany(User::class, 'propietario')->withTimestamps()->withTrashed();
  }

  public function areaconocimiento()
  {
    return $this->belongsTo(AreaConocimiento::class, 'areaconocimiento_id', 'id');
  }

  public function fase()
  {
    return $this->belongsTo(Fase::class, 'fase_id', 'id');
  }

  public function sublinea()
  {
    return $this->belongsTo(Sublinea::class, 'sublinea_id', 'id');
  }

  /**
   * Relación con la tabla de ideas
   */
  public function idea()
  {
    return $this->belongsTo(Idea::class, 'idea_id', 'id');
  }

  public function articulacion_proyecto()
  {
    return $this->belongsTo(ArticulacionProyecto::class, 'articulacion_proyecto_id', 'id');
  }

  public function articulacionpbt()
  {
      return $this->hasOne(ArticulacionPbt::class, 'proyecto_id', 'id');
  }

  /*=====  End of relaciones polimorficas  ======*/

  /*======================================================================================
=            scope para consultar el nombre y el id del proyecto por estado            =
======================================================================================*/

  /*=====  End of scope para consultar el nombre y el id del proyecto por estado  ======*/

  /*===================================================================
    =            scope para consultar por estado de proyecto            =
    ===================================================================*/

  public function scopeEstadoOfProjects($query, array $relations, array $estado = [])
  {
    return $query->with($relations)->whereHas(
      'estadoproyecto',
      function ($query) use ($estado) {
        $query->whereIn('nombre', $estado);
      }
    );
  }

  /*=====  End of scope para consultar por estado de proyecto  ======*/

  public function scopeNodo($query, $nodo)
    {
        if (!empty($nodo) && $nodo != null && $nodo != 'all') {
            return $query->whereHas('articulacion_proyecto.actividad', function ($subQuery) use ($nodo) {
                $subQuery->where('nodo_id', $nodo);
            });
        }
        return $query;
    }

    public function scopeStarEndDate($query, $year)
    {
        if (!empty($year) && $year != null && $year != 'all') {
            return $query->whereHas('articulacion_proyecto.actividad', function ($subQuery) use ($year) {
                $subQuery->whereYear('fecha_inicio', $year)->orWhereYear('fecha_cierre', $year);
            });
        }
        return $query;
    }

    public function scopeFase($query, $fase)
    {
        if (!empty($fase) && $fase != 'all' && $fase != null) {
            return $query->where('fase_id', $fase);
        }
        return $query;
    }
}
