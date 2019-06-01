<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rols extends Model
{
    protected $table = 'rols';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
    ];

    public function users()
    {
      return $this->hasMany(User::class, 'rol_id', 'id');
    }

<<<<<<< HEAD
=======

>>>>>>> 6dd3e63e62a96183c85d29f48571d5e51212673e
}
