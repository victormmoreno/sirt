<?php

namespace App\Http\Traits\OcupacionTrait;

trait OcupacionTrait
{
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
        return self::IS_OTRA_OCUPACION;
    }
}
