<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class Entrenamiento extends Model
{
  // use Notifiable;
  protected $table = 'entrenamientos';

  // protected $dates = [
  //     'fecha_sesion1',
  //     'fecha_sesion2',
  // ];
  protected $casts = [
    'fecha_sesion1'  => 'date:Y-m-d',
    'fecha_sesion2' => 'date:Y-m-d',
];
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'fecha_sesion1',
      'fecha_sesion2',
      'correos',
      'dir_correos',
      'fotos',
      'dir_fotos',
      'listado_asistencia',
      'dir_listado_asistencia',
  ];

}
