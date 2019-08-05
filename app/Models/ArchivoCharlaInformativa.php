<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchivoCharlaInformativa extends Model
{
  protected $table = 'archivoscharlasinformativas';

  protected $fillable = [
    'charlainformativa_id',
    'ruta',
  ];
}
