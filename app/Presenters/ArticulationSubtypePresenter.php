<?php

namespace App\Presenters;

use App\Models\ArticulationSubtype;
use Illuminate\Support\Str;

class ArticulationSubtypePresenter extends Presenter
{
    protected $articulationSubtype;

    public function __construct(ArticulationSubtype $articulationSubtype)
    {
        $this->articulationSubtype = $articulationSubtype;
    }

    public function name()
    {
        return  $this->articulationSubtype->name ? : 'No Registra';
    }

    public function description()
    {
        return  $this->articulationSubtype->description ? : 'No Registra';
    }

    public function descriptionLimit()
    {
        return  $this->articulationSubtype->description ? Str::limit($this->articulationSubtype->description, 40) : 'No Registra';
    }

    public function entities()
    {
        return  $this->articulationSubtype->entity ? collect($this->articulationSubtype->entity)->implode(', ') : 'No Registra';
    }

    public function status()
    {
        return  $this->articulationSubtype->state ? : 'No Registra';
    }
}
