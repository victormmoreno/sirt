<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Articulacion extends Model
{

  //Constantes del campo tipo_articulacion
  const IS_GRUPO = 0; //ES UNA ARTICULACION CON GRUPO DE INVESTIGACIÓN
  const IS_EMPRESA = 1; //ES UNA ARTICULACIÓN CON EMPRESA
  const IS_EMPRENDEDOR = 2; // ES UNA ARTICULACIÓN CON EMPRENDEDOR

  //Constantes de campo estado
  const IS_INICIO = 0; // EL ESTADO DE LA ARTICULACIÓN ES INICIO
  const IS_EJECUCION = 1; // EL ESTADO DE LA ARTICULACIÓN ES EJECUCICIÓM Ó CO-EJECUCICIÓM
  const IS_CIERRE = 2; // EL ESTADO DE LA ARTICULACIÓN ES CIERRE

  //Constatens del campo revisado_final
  const IS_POREVALUAR = 0;
  const IS_APROBADO = 1;
  const IS_NOAPROBADO = 2;

  // Retorno para las constantes del campo revisado_final
  public static function IsPorEvaluar() {
    return self::IS_POREVALUAR;
  }

  public static function IsAprobado() {
    return self::IS_APROBADO;
  }

  public static function IsNoAprobado() {
    return self::IS_NOAPROBADO;
  }

  // Retorno para las constantes del campo estado
  public static function IsInicio(){
    return self::IS_INICIO;
  }

  public static function IsEjecucion(){
    return self::IS_EJECUCION;
  }

  public static function IsCierre(){
    return self::IS_CIERRE;
  }

  // Retorno de la constantes para el campo de tipo_articulacion
  public static function IsGrupo() {
    return self::IS_GRUPO;
  }

  public static function IsEmpresa() {
    return self::IS_EMPRESA;
  }

  public static function IsEmprendedor() {
    return self::IS_EMPRENDEDOR;
  }

  protected $table = 'articulaciones';

  protected $casts = [
  'fecha_inicio' => 'date:Y-m-d',
  'fecha_ejecucion' => 'date:Y-m-d',
  'fecha_cierre' => 'date:Y-m-d',
  ];

  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
  'entidad_id',
  'tipoarticulacion_id',
  'gestor_id',
  'tipogrupo',
  'codigo_articulacion',
  'nombre',
  'revisado_final',
  'tipo_articulacion',
  'fecha_inicio',
  'fecha_ejecucion',
  'fecha_cierre',
  'observaciones',
  'estado',
  'acta_inicio',
  'acc',
  'actas_seguimiento',
  'acta_cierre',
  'informe_final',
  'pantallazo',
  'otros',
  ];

  // Relación a la tabla de tipos de articulación
  public function tipoarticulacion()
  {
    return $this->belongsTo(TipoArticulacion::class, 'tipoarticulacion_id', 'id');
  }

  // Relación a la tabla de gestor
  public function gestor()
  {
    return $this->belongsTo(Gestor::class, 'gestor_id', 'id');
  }

  // Relación a la tabla de entidad
  public function entidad()
  {
    return $this->belongsTo(Entidad::class, 'entidad_id', 'id');
  }

  // Relación a la tabla de archivosarticulaciones
  public function archivosarticulaciones()
  {
    return $this->hasMany(ArchivoArticulacion::class, 'articulacion_id', 'id');
  }

}
