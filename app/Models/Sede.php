<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    protected $table = 'sedes';

    /**
     * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'empresa_id',
        'ciudad_id',
        'nombre_sede',
        'direccion'
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id', 'id');
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id', 'id');
    }

    public function ideas()
    {
        return $this->hasMany(Idea::class, 'sede_id', 'id');
    }

    // public function articulaciones()
    // {
    //     return $this->hasMany(ArticulacionPbt::class, 'sede_id', 'id');
    // }

    public function proyectos()
    {
        return $this->morphToMany(Proyecto::class, 'propietario')->withTimestamps();
    }

    /**
     * Define a polymorphic, inverse many-to-many relationship between sede and articulacion_pbt
     * @author dum
     * @return \Illuminate\Database\Eloquent\Relations\morphOne
     */
    public function articulacion()
    {
        return $this->morphOne(ArticulacionPbt::class,'articulable');
    }

}
