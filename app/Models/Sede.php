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

    public function proyectos()
    {
        return $this->morphToMany(Proyecto::class, 'propietario')->withTimestamps();
    }

    /**
     * The polymorfic relation much to much
     *
     * @return void
     */
    public function articulationables()
    {
        return $this->morphToMany(ArticulationStage::class, 'articulationable');
    }
}
