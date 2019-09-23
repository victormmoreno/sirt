<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
  protected $table = 'sectores';

  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
    'nombre',
  ];

  public function scopeSelectAllSectors($query)
  {
    return $query->select('id', 'nombre');
  }

  public function empresas()
  {
    return $this->hasMany(Empresa::class, 'sector_id', 'id');
  }

  /**
   * Relacion a la tabla de proyectos
   */
  public function proyectos()
  {
    return $this->hasMany(Proyecto::class, 'sector_id', 'id');
  }
}
