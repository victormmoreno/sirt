<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreaConocimiento extends Model
{
    protected $table = 'areasconocimiento';

    protected $fillable = ['nombre'];


    public function getNombreAttribute($nombre)
    {
        return ucwords(strtolower(trim($nombre)));
    }

    public function edts()
    {
        return $this->hasMany(Edt::class, 'areaconocimiento_id', 'id');
    }

    public function scopeConsultarAreasConocimiento($query)
    {
        return $query->select('id', 'nombre')
            ->orderBy('nombre', 'asc');
    }

    public function proyectos()
    {
        return $this->hasMany(Proyecto::class, 'areaconocimiento_id', 'id');
    }

}
