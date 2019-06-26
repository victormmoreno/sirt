<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
  protected $table = 'empresas';

  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
    'entidad_id',
    'sector_id',
    'nit',
    'direccion',
    'nombre_contacto',
    'correo_contacto',
    'telefono_contacto',
  ];

  // Relación a la tabla entidades
  public function entidad()
  {
    return $this->belongsTo(Entidad::class,'entidad_id', 'id');
  }

  // Relación a la tabla de sectores
  public function sector()
  {
    return $this->belongsTo(Sector::class, 'sector_id', 'id');
  }
}
