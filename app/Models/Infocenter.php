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

  public function user()
  {
    return $this->hasOne(User::class, 'user_id', 'user_id');
  }

}
