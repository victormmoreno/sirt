<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchivoComite extends Model
{
  protected $table = 'archivoscomites';

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
