<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{

    protected $table = 'proyectos';

    protected $casts = [
        'fecha_ejecucion' => 'date:Y-m-d',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'articulacion_proyecto_id', // Llave foranea
        'idea_id', // Llave foranea
        'sector_id', // Llave foranea
        'sublinea_id', // Llave foranea
        'areaconocimiento_id', // Llave foranea
        'estadoproyecto_id', // Llave foranea
        'tipoarticulacionproyecto_id', // Llave foranea
        'estadoprototipo_id', // Llave foranea
        'tipo_ideaproyecto',
        'otro_tipoarticulacion',
        'otro_estadoprototipo',
        'universidad_proyecto',
        'observaciones_proyecto',
        'impacto_proyecto',
        'economia_naranja',
        'resultado_proyecto',
        'fecha_ejecucion',
        'aporte_sena',
        'aporte_talento',
        'art_cti',
        'nom_act_cti',
        'diri_ar_emp',
        'reci_ar_emp',
        'dine_reg',
        'acc',
        'manual_uso_inf',
        'aval_empresa_grupo',
        'estado_arte',
        'video_tutorial',
        'url_videotutorial',
        'ficha_caracterizacion',
        'lecciones_aprendidas',
        'encuesta',
    ];

    /*===============================================
    =            relaciones polimorficas            =
    ===============================================*/

    /**
     * Devolver relacion entre sublinea y proyecto
     * @author julian londoño
     */
    public function sublinea()
    {
        return $this->belongsTo(Sublinea::class, 'sublinea_id', 'id');
    }

    // Relación a la tabla de archivosproyecto
    // public function archivosproyecto()
    // {
    //     return $this->hasMany(ArchivoProyecto::class, 'proyecto_id', 'id');
    // }

    /* relacion a la tabla estadosproyecto */
    public function estadoproyecto()
    {
        return $this->belongsTo(EstadoProyecto::class, 'estadoproyecto_id', 'id');
    }

    public function articulacion_proyecto()
    {
        return $this->belongsTo(ArticulacionProyecto::class, 'articulacion_proyecto_id', 'id');
    }

    /*=====  End of relaciones polimorficas  ======*/

    /*=====================================================================
    =            scope para consultar los proyectos por estado            =
    =====================================================================*/

    public function scopeInfoProjects($query, array $relations = [], array $estado = [])
    {
        if (empty($relations)) {
            return $query;
        }

        return $query->with($relations)->select('id', 'estadoproyecto_id', 'articulacion_proyecto_id');

    }

    /*=====  End of scope para consultar los proyectos por estado  ======*/

/*======================================================================================
=            scope para consultar el nombre y el id del proyecto por estado            =
======================================================================================*/

    public function scopePluckNameProjects($query, array $estado = [])
    {
        return $query->with([
            'estadoproyecto'                  => function ($query) {
                $query->select('id', 'nombre');
            },
            'articulacion_proyecto'           => function ($query) {
                $query->select('id', 'actividad_id');
            },
            'articulacion_proyecto.actividad' => function ($query) {
                $query->select('id', 'codigo_actividad', 'nombre');
            },
        ])->select('id', 'estadoproyecto_id', 'articulacion_proyecto_id');

    }

/*=====  End of scope para consultar el nombre y el id del proyecto por estado  ======*/

/*===================================================================
=            scope para consultar por estado de proyecto            =
===================================================================*/

    public function scopeEstadoOfProjects($query, array $estado = [])
    {

        if ($this->estadoproyecto()->exists()) {
            return $query->whereHas(
                'estadoproyecto', function ($query) use ($estado) {
                    $query->whereIn('nombre', $estado);
                }
            );
        }
        return $query;
    }

/*=====  End of scope para consultar por estado de proyecto  ======*/

}
