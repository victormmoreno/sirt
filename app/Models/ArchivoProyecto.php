<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchivoProyecto extends Model
{
  protected $table = 'archivosproyecto';

  protected $fillable = [
      'fase_id',
      'proyecto_id',
      'ruta',
  ];

  // Relacion a la tabla de fases
  public function fase()
  {
      return $this->belongsTo(Fase::class, 'fase_id', 'id');
  }

  // Relacion a la tabla de proyectos
  public function proyecto()
  {
      return $this->belongsTo(Proyecto::class, 'proyecto_id', 'id');
  }
}
