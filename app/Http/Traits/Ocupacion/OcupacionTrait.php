<?php

namespace App\Http\Traits\Ocupacion;

use App\Models\Ocupacion;

trait OcupacionTrait
{
    public function users()
    {
        return $this->belongsToMany(User::class, 'ocupaciones_users')
            ->withTimestamps();
    }

    public function scopeAllOcupaciones($query)
    {
        return $query->with('users')->orderby('nombre');
    }

    public function getNombreAttribute($nombre)
    {
        return ucwords(mb_strtolower(trim($nombre), 'UTF-8'));
    }

    public function setNombreAttribute($nombre)
    {
        $this->attributes['nombre'] = ucwords(mb_strtolower(trim($nombre), 'UTF-8'));
    }

    public static function IsOtraOcupacion()
    {
        return Ocupacion::IS_OTRA_OCUPACION;
    }
}
