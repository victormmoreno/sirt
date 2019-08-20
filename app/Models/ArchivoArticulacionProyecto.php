<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchivoArticulacionProyecto extends Model
{
  protected $table = 'archivos_articulacion_proyecto';

  protected $fillable = [
      'fase_id',
      'articulacion_proyecto_id',
      'ruta',
  ];

  // Relacion a la tabla de fases
  public function fase()
  {
      return $this->belongsTo(Fase::class, 'fase_id', 'id');
  }

  // Relacion a la tabla de articulacion_proyecto
  public function articulacion_proyecto()
  {
      return $this->belongsTo(ArticulacionProyecto::class, 'articulacion_proyecto_id', 'id');
  }
}
