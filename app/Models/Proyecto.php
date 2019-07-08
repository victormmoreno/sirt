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
    'idea_id',
    'sector_id',
    'sublinea_id',
    'areaconocimiento_id',
    'estadoproyecto_id',
    'gestor_id',
    'producto_id',
    'entidad_id',
    'nodo_id',
    'tipoarticulacionproyecto_id',
    'codigo_proyecto',
    'nombre',
    'impacto_proyecto',
    'economia_naranja',
    'resultado_proyecto',
    'fecha_inicio',
    'fecha_fin',
    'fecha_ejecucion',
    'estado_prototipo',
    'aporte_sena',
    'aporte_talento',
    'art_cti',
    'nom_act_cti',
    'diri_ar_emp',
    'reci_ar_emp',
    'dine_reg',
    'acc',
    'manual_uso_inf',
    'ava_empresa_grupo',
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
