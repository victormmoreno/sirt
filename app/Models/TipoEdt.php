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

}
