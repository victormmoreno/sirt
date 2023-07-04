<?php

namespace App\Http\Traits\AsesorieTrait;

use App\Presenters\AsesoriePresenter;

trait AsesorieTrait
{
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
