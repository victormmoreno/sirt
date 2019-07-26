<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoVisitante extends Model
{
  protected $table = 'tiposvisitante';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'nombre',
  ];

  public function visitantes()
  {
    return $this->hasMany(Visitante::class, 'tipovisitante_id', 'id');
  }
}
