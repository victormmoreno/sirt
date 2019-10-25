<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticulacionEmprendedor extends Model
{

  protected $table = 'articulacion_emprendedor';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
   protected $fillable = [
     'articulacion_id',
     'documento',
     'nombres',
     'email',
     'contacto',
   ];

  /**
  * Relación con la tabla de articulaciones
  * @return Eloquent
  * @author dum
  */
  public function articulacion()
  {
    return $this->hasMany(Articulacion::class, 'articulacion_id');
  }

}
