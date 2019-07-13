<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoArticulacionProyecto extends Model
{
  protected $table = 'tiposarticulacionesproyectos';

  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
    'nombre',
  ];
}
