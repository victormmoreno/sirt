<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoArticulacion extends Model
{
  //Constantes del campo articulado_con
  // Este campo quiere decir que el tipo de articulación es con empresas/emprendedores ó grupos de investigación
  const IS_GRUPO = 0; //EL TIPO DE ARTICULACIÓN ES ÚNICAMENTE CON GRUPO DE INVESTIGACIÓN
  const IS_EMPRESAEMPRENDEDOR = 1; //EL TIPO DE ARTICULACIÓN ES ÚNICAMENTE CON EMPRESAS/EMPRENDEDORES
  const IS_AMBOS = 2; //EL TIPO DE ARTICULACIÓN ES CON AMBOS (GRUPO DE INVESTIGACIÓN Y EMPRESAS/EMPRENDEDORES)

  // Retorno para el campo de articulado_con
  public static function IsGrupo() {
    return self::IS_GRUPO;
  }

  public static function IsEmpresaEmprendedor() {
    return self::IS_EMPRESAEMPRENDEDOR;
  }

  public static function IsAmbos() {
    return self::IS_AMBOS;
  }

  protected $table = 'tiposarticulaciones';

  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
    'nombre',
    'articulado_con',
  ];
}
