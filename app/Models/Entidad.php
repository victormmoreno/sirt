<?php

namespace App\Models;

use App\Models\Empresa;
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

    public function empresa()
    {
        return $this->hasOne(Empresa::class, 'entidad_id', 'id');
    }

}
