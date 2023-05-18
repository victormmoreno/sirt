<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'departamentos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'nombre' => 'string',
    ];

    public $timestamps = false;

    public function ciudades()
    {
        return $this->hasMany(Ciudad::class, 'departamento_id', 'id');
    }

    public function scopeAllDepartamentos($query)
    {
        return $query->select('departamentos.id', 'departamentos.nombre');
    }
}
