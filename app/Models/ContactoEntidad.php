<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactoEntidad extends Model
{
  protected $table = 'contactosentidades';

  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
    'nodo_id',
    'entidad_id',
    'nombres_contacto',
    'correo_contacto',
    'telefono_contacto',
  ];
}
