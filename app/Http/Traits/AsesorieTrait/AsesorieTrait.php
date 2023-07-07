<?php

namespace App\Http\Traits\AsesorieTrait;

use App\Presenters\AsesoriePresenter;
use App\Models\UsoInfraestructura;

trait AsesorieTrait
{
    public static function IsProyecto()
    {
        return UsoInfraestructura::IS_PROYECTO;
    }

    public static function IsArticulacion()
    {
        return UsoInfraestructura::IS_ARTICULACION;
    }

    public static function IsIdea()
    {
        return UsoInfraestructura::IS_IDEA;
    }

    public function asesorable()
    {
        return $this->morphTo();
    }


    public function setDescripcionAttribute($descripcion)
    {
        $this->attributes['descripcion'] = ucwords(mb_strtolower(trim($descripcion), 'UTF-8'));
    }

    public function getDescripcionAttribute($descripcion)
    {
        return ucwords(strtolower(trim($descripcion)));
    }

    public function present()
    {
        return new AsesoriePresenter($this);
    }
}
