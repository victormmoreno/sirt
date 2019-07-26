<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchivoEdt extends Model
{
  protected $table = 'archivosedt';

  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
    'edt_id',
    'ruta',
  ];
}
