<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchivoComite extends Model
{
  protected $table = 'archivoscomite';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'comite_id',
      'ruta',
  ];
}
