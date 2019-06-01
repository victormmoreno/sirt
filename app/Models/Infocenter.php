<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Infocenter extends Model
{
  protected $table = 'infocenter';

  protected $fillable = [
      'nodo_id',
      'users_id',
  ];

  public function nodo()
  {
    return $this->belongsTo(Nodo::class, 'nodo_id', 'id');
  }

  public function users()
  {
    return $this->hasMany(User::class, 'users_id', 'id');
  }

}
