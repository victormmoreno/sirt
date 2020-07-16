<?php

namespace App\Models;

use App\Models\ArchivoComite;
use Carbon\Carbon;
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
    'estado_comite_id'
  ];

  /*=========================================
  =            asesores eloquent            =
  =========================================*/

  public function getCodigoAttribute($codigo)
  {
    return trim($codigo);
  }


  public function getObservacionesAttribute($observaciones)
  {
    return ucfirst(strtolower(trim($observaciones)));
  }

  /*=====  End of asesores eloquent  ======*/

  /*========================================
  =            mutador eloquent            =
  ========================================*/

  public function setCodigoAttribute($codigo)
  {
    $this->attributes['codigo'] = trim($codigo);
  }

  public function estado()
  {
    return $this->belongsTo(EstadoComite::class, 'estado_comite_id', 'id');
  }

  public function setFechaComiteAttribute($fechacomite)
  {
    $this->attributes['fechacomite'] = Carbon::parse($fechacomite)->format('Y-m-d');
  }

  public function setObservacionesAttribute($observaciones)
  {
    $this->attributes['observaciones'] = ucfirst(strtolower(trim($observaciones)));
  }

  /*=====  End of mutador eloquent  ======*/

  /*===========================================
  =            relaciones eloquent            =
  ===========================================*/

  public function archivos()
  {
    return $this->hasMany(ArchivoComite::class, 'comite_id', 'id');
  }

  public function rutamodel()
  {
    return $this->morphMany(RutaModel::class, 'model');
  }

  public function ideas()
  {
    return $this->belongsToMany(Idea::class, 'comite_idea')
    ->withTimestamps()
    ->withPivot(['hora', 'admitido', 'asistencia', 'observaciones', 'direccion']);
  }

  /*=====  End of relaciones eloquent  ======*/


}
