<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
  protected $table = 'proyectos';

  protected $casts = [
  'fecha_inicio' => 'date:Y-m-d',
  'fecha_fin' => 'date:Y-m-d',
  'fecha_ejecucion' => 'date:Y-m-d',
  ];

  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
    'idea_id',// Llave foranea
    'sector_id', // Llave foranea
    'sublinea_id', // Llave foranea
    'areaconocimiento_id', // Llave foranea
    'estadoproyecto_id', // Llave foranea
    'gestor_id', // Llave foranea
    'entidad_id', // Llave foranea
    'nodo_id', // Llave foranea
    'tipoarticulacionproyecto_id', // Llave foranea
    'estadoprototipo_id', // Llave foranea
    'otro_estadoprototipo',
    'universidad_proyecto',
    'codigo_proyecto', // Unique
    'nombre',
    'impacto_proyecto',
    'economia_naranja',
    'resultado_proyecto',
    'fecha_inicio',
    'fecha_fin',
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
    'acta_inicio',
    'estado_arte',
    'actas_seguimiento',
    'video_tutorial',
    'fecha_caracterizacion',
    'acta_cierre',
    'lecciones_aprendidas',
    'encuesta'
  ];



}
