<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comite extends Model
{
  protected $table = 'comites';

  protected $casts = [
    'fechacomite' => 'date:Y-m-d',
  ];

  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
    'codigo',
    'fechacomite',
    'observaciones',
  ];
}
