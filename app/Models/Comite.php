<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ArchivoComite;

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
    'correos',
    'listado_asistencia',
    'otros',
  ];

  public function archivos()
  {
    return $this->hasMany(ArchivoComite::class, 'comite_id', 'id');
  }
}
