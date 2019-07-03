<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Gestor extends Model
{
    protected $table = 'gestores';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'nodo_id',
        'lineatecnologica_id',
        'honorarios',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }

    public function nodo()
    {
        return $this->belongsTo(Nodo::class, 'nodo_id', 'id');
    }

    // Relación a la tabla de articulaciones
    public function articulaciones()
    {
      return $this->hasMany(Articulacion::class, 'gestor_id', 'id');
    }
}
