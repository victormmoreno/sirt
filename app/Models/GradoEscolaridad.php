<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradoEscolaridad extends Model
{
    protected $table = 'gradosescolaridad';

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
        return $this->hasMany(User::class, 'gradoescolaridad_id', 'id');
    }

    public function scopeAllGradosEscolaridad($query)
    {

        return $query->select('gradosescolaridad.id', 'gradosescolaridad.nombre');

    }

    public function getNombreAttribute($nombre)
    {
        return ucwords(strtolower(trim($nombre)));
    }
}
