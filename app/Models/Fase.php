<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fase extends Model
{
  protected $table = 'fases';
  public $timestamps = false;

  protected $fillable = [
    'nombre',
  ];


}
