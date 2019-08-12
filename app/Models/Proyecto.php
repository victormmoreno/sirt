<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{

    protected $table = 'proyectos';

    protected $casts = [
        'fecha_ejecucion' => 'date:Y-m-d'
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

    /*=====  End of relaciones polimorficas  ======*/

    /*=====================================================================
    =            scope para consultar los proyectos por estado            =
    =====================================================================*/

    public function scopeProjectsForEstado($query, array $estado = [])
    {
        return $query->with([
            'estadoproyecto' => function ($query) {
                $query->select('id', 'nombre');
            },
        ])->select('id', 'nombre', 'codigo_proyecto', 'estadoproyecto_id')
            ->whereHas(
                'estadoproyecto', function ($query) use($estado){
                    $query->whereIn('nombre', $estado);
                }
        );

    }

    /*=====  End of scope para consultar los proyectos por estado  ======*/


}
