<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupoSanguineo extends Model
{
    protected $table = 'gruposanguineos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'estado',
    ];

    public $timestamps = false;

    public function users()
    {
      return $this->hasMany(User::class, 'gruposanguineo_id', 'id');
    }
}
