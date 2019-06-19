<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entidad extends Model
{
    protected $table = 'entidades';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ciudad_id',
        'nombre',
        'contacto',
    ];

    public function centros()
    {
        return $this->hasMany(Centro::class, 'entidad_id', 'id');
    }

    public function tecnoacademias()
    {
        return $this->hasMany(Tecnoacademia::class, 'entidad_id', 'id');
    }

}
