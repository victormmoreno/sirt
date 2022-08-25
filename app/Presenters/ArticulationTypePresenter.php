<?php

namespace App\Presenters;

use App\Models\ArticulationType;
use Illuminate\Support\Str;

class ArticulationTypePresenter extends Presenter
{
    protected $typeArticulation;

    public function __construct(ArticulationType $typeArticulation)
    {
        $this->typeArticulation = $typeArticulation;
    }

    public function nombre()
    {
        return  $this->typeArticulation->nombre ? : 'No Registra';
    }

    public function descripcion()
    {
        return  $this->typeArticulation->descripcion ? : 'No Registra';
    }

    public function descripcionLimit()
    {
        return  $this->typeArticulation->descripcion ? Str::limit($this->typeArticulation->descripcion, 40) : 'No Registra';
    }

    public function entidad()
    {
        return  $this->typeArticulation->entidad ? : 'No Registra';
    }

    public function estado()
    {
        return  $this->typeArticulation->estado ? : 'No Registra';
    }


}
