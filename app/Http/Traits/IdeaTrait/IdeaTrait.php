<?php

namespace App\Http\Traits\IdeaTrait;

use App\Models\EstadoIdea;
use App\Models\Nodo;
use App\Models\Proyecto;
use App\Models\RutaModel;
use App\Models\Comite;

trait IdeaTrait
{

  /*===============================================================
  =            metodos para conocer los tipos de ideas            =
  ===============================================================*/
  public static function IsEmprendedor()
  {
    return self::IS_EMPRENDEDOR;
  }

  public static function IsEmpresa()
  {
    return self::IS_EMPRESA;
  }

  public static function IsGrupoInvestigacion()
  {
    return self::IS_GRUPOINVESTIGACION;
  }

  /**
   * Relación a la tabla de proyectos
   */
  public function proyecto()
  {
    return $this->hasOne(Proyecto::class, 'idea_id', 'id');
  }

  public function estadoIdea()
  {
    return $this->belongsTo(EstadoIdea::class, 'estadoidea_id', 'id');
  }

  public function comites()
  {
    return $this->belongsToMany(Comite::class, 'comite_idea')
    ->withTimestamps()
    ->withPivot(['hora', 'admitido', 'asistencia', 'observaciones', 'direccion']);
  }

  public function nodo()
  {
    return $this->belongsTo(Nodo::class, 'nodo_id', 'id');
  }

  public function rutamodel()
  {
    return $this->morphOne(RutaModel::class, 'model');
  }

  public function getNombreCompletoAttribute()
  {
    return ucfirst($this->nombres_contacto) . ' ' . ucfirst($this->apellidos_contacto);
  }


  /*=========================================
  =            asesores eloquent            =
  =========================================*/

  public function getNombresContactoAttribute($nombres_contacto)
  {
    return ucfirst(trim($nombres_contacto));
  }

  public function getApellidosContactoAttribute($apellidos_contacto)
  {
    return ucfirst(trim($apellidos_contacto));
  }

  public function getCorreoContactoAttribute($correo_contacto)
  {
    return mb_strtolower(trim($correo_contacto), 'UTF-8');
  }

  public function getTelefonoContactoAttribute($telefono_contacto)
  {
    return trim($telefono_contacto);
  }

  public function getNombreProyectoAttribute($nombre_proyecto)
  {
    return ucfirst(trim($nombre_proyecto));
  }
  public function getDescripcionAttribute($descripcion)
  {
    return ucfirst(trim($descripcion));
  }
  public function getObjetivoAttribute($objetivo)
  {
    return ucfirst(trim($objetivo));
  }

  public function getAlcanceAttribute($alcance)
  {
    return ucfirst(trim($alcance));
  }

  /*=====  End of asesores eloquent  ======*/

  /*========================================
  =            mutador eloquent            =
  ========================================*/
  public function setNombresContactoAttribute($nombres_contacto)
  {
    $this->attributes['nombres_contacto'] = ucfirst(trim($nombres_contacto));
  }

  public function setApellidosContactoAttribute($apellidos_contacto)
  {
    $this->attributes['apellidos_contacto'] = ucfirst(trim($apellidos_contacto));
  }

  public function setCorreoContactoAttribute($correo_contacto)
  {
    $this->attributes['correo_contacto'] = mb_strtolower(trim($correo_contacto), 'UTF-8');
  }

  public function setTelefonoContactoAttribute($telefono_contacto)
  {
    $this->attributes['telefono_contacto'] = trim($telefono_contacto);
  }

  public function setNombreProyectoAttribute($nombre_proyecto)
  {
    $this->attributes['nombre_proyecto'] = ucfirst(trim($nombre_proyecto));
  }

  public function setDescripcionAttribute($descripcion)
  {
    $this->attributes['descripcion'] = ucfirst(trim($descripcion));
  }

  public function setObjtivoAttribute($objetivo)
  {
    $this->attributes['objetivo'] = ucfirst(trim($objetivo));
  }

  public function setAlcanceAttribute($alcance)
  {
    $this->attributes['alcance'] = ucfirst(trim($alcance));
  }
  /*=====  End of mutador eloquent  ======*/
}
