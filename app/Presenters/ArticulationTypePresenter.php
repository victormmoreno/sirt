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

    public function name()
    {
        return  $this->typeArticulation->name ? : 'No Registra';
    }

    public function description()
    {
        return  $this->typeArticulation->description ? : 'No Registra';
    }

    public function descriptionLimit()
    {
        return  $this->typeArticulation->description ? Str::limit($this->typeArticulation->description, 40) : 'No Registra';
    }

    public function status()
    {
        return  $this->typeArticulation->state ? : 'No Registra';
    }


}
