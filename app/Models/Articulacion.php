<?php

namespace App\Models;

use App\Http\Traits\ArticulacionTrait\ArticulacionTrait;
use Illuminate\Database\Eloquent\Model;

class Articulacion extends Model
{

  use ArticulacionTrait;

    // Constante para la entidad de no aplica
    const IS_NOAPLICA = 1;

    //Constantes del campo tipo_articulacion
    const IS_GRUPO       = 0; //ES UNA ARTICULACION CON GRUPO DE INVESTIGACIÓN
    const IS_EMPRESA     = 1; //ES UNA ARTICULACIÓN CON EMPRESA
    const IS_EMPRENDEDOR = 2; // ES UNA ARTICULACIÓN CON EMPRENDEDOR

    //Constantes de campo estado
    const IS_INICIO    = 0; // EL ESTADO DE LA ARTICULACIÓN ES INICIO
    const IS_EJECUCION = 1; // EL ESTADO DE LA ARTICULACIÓN ES EJECUCICIÓM Ó CO-EJECUCICIÓM
    const IS_CIERRE    = 2; // EL ESTADO DE LA ARTICULACIÓN ES CIERRE

    protected $table = 'articulaciones';

    protected $casts = [
        'fecha_inicio'    => 'date:Y-m-d',
        'fecha_ejecucion' => 'date:Y-m-d',
        'fecha_cierre'    => 'date:Y-m-d',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'articulacion_proyecto_id',
        'tipoarticulacion_id',
        'tipo_articulacion',
        'fecha_ejecucion',
        'observaciones',
        'estado',
        'acc',
        'informe_final',
        'pantallazo',
        'otros',
        'acuerdos',
        'alcance_articulacion',
        'siguientes_investigaciones',
        'fase_id'
    ];

    public function productos()
    {
      return $this->belongsToMany(Producto::class, 'articulaciones_productos')
      ->withTimestamps()
      ->withPivot('logrado');
    }

    public function fase()
    {
      return $this->belongsTo(Fase::class, 'fase_id', 'id');
    }

    /**
    * Relación con la tabla de articulacion_emprendedor
    * @return Eloquent
    * @author dum
    */
    public function emprendedores()
    {
      return $this->hasMany(ArticulacionEmprendedor::class, 'articulacion_id');
    }

    // Relacion muchos a muchos con talentos
    public function talentos()
    {
        return $this->belongsToMany(Talento::class, 'articulacion_talento')
            ->withTimestamps()
            ->withPivot('talento_lider');
    }

    // Relación a la tabla de tipos de articulación
    public function tipoarticulacion()
    {
        return $this->belongsTo(TipoArticulacion::class, 'tipoarticulacion_id', 'id');
    }

    public function articulacion_proyecto()
    {
        return $this->belongsTo(ArticulacionProyecto::class, 'articulacion_proyecto_id', 'id');
    }

    /*==========================================================================
    =            scope para consultar las articulaciones por estado            =
    ==========================================================================*/

    public function scopeArticulacionesForEstado($query, int $estado)
    {
        $query->with([
            'articulacion_proyecto' => function ($query) {
                $query->select('id','actividad_id');
            },
            'articulacion_proyecto.actividad' => function ($query) {
                $query->select('id','codigo_actividad','nombre')->orderBy('nombre');
            },
            'tipoarticulacion' => function ($query) {
                $query->select('id', 'nombre');
            },

        ])->select('id', 'articulacion_proyecto_id','tipoarticulacion_id','estado')
          ->where('estado',$estado);
    }

    /*=====  End of scope para consultar las articulaciones por estado  ======*/

    /*====================================================================================
    =            scope para consultar articulaciones por tipo de articulacion            =
    ====================================================================================*/

    public function scopeArticulacionesForTipoArticulacion($query, int $tipoArticulacion)
    {
        $query->where('tipo_articulacion',$tipoArticulacion);
    }

    /*=====  End of scope para consultar articulaciones por tipo de articulacion  ======*/


    /*=========================================================================
    =            scope para consultar por estado de articulaciones            =
    =========================================================================*/

    public function scopeEstadoOfArticulaciones($query, array $estado = [])
    {
        return $query->whereIn('estado',$estado);
    }

    /*=====  End of scope para consultar por estado de articulaciones  ======*/


    /*===================================================================
    =            scope para consultar articulaciones           =
    ===================================================================*/

    public function scopeArticulacionesWithRelations($query, array $relations)
    {
        return $query->with($relations);
    }

    /*=====  End of scope para consultar por estado de proyecto  ======*/

}
