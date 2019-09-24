<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoEdt extends Model
{
  protected $table = 'tiposedt';
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'nombre',
      'observaciones'
  ];

  /**
  * The attributes that should be cast to native types.
  *
  * @var array
  */
  protected $casts = [
    'nombre'        => 'string',
    'observaciones' => 'string',
  ];

  public function edts()
  {
    return $this->hasMany(Edt::class, 'tipoedt_id', 'id');
  }

}
