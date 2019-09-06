<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreaConocimiento extends Model
{
  protected $table = 'areasconocimiento';

  protected $fillable = [
    'nombre',
  ];

  /*=========================================
  =            asesores eloquent            =
  =========================================*/

  public function getNombreAttribute($nombre)
  {
    return ucwords(strtolower(trim($nombre)));
  }

  /*=====  End of asesores eloquent  ======*/

  /*========================================
  =            mutador eloquent            =
  ========================================*/

  // public function setNombreAttribute($nombre)
  // {
  //     $this->attributes['nombre'] = ucwords(strtolower($nombre));
  // }

  /*=====  End of mutador eloquent  ======*/

  // Scope para consultar las áreas de conocmiento
  public function scopeConsultarAreasConocimiento($query)
  {
    return $query->select('id', 'nombre')
    ->orderBy('nombre', 'asc');
  }

  public function proyectos()
  {
    return $this->hasMany(Proyecto::class, 'areaconocimiento_id', 'id');
  }

}
