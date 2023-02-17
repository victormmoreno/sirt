<?php

namespace App\Presenters;

use App\Models\Articulation;

class ArticulationPresenter extends Presenter
{
    protected $articulation;

    public function __construct(Articulation $articulation)
    {
        $this->articulation = $articulation;
    }

    public function articulationCode()
    {
        return isset($this->articulation->code) ? $this->articulation->code : 'No registra';
    }

    public function articulationName()
    {
        return isset($this->articulation->name) ? $this->articulation->name : 'No registra';
    }

    public function articulationDescription()
    {
        return isset($this->articulation->description) ? $this->articulation->description : 'No registra';
    }

    public function articulationScope()
    {
        return isset($this->articulation->scope) ? $this->articulation->scope->name : 'No registra';
    }

    public function articulationObjetive()
    {
        return isset($this->articulation) ? $this->articulation->objective : 'No registra';
    }


    public function articulationStartDate()
    {
        return optional($this->articulation->start_date)->isoFormat('DD/MM/YYYY');
    }

    public function articulationEndDate()
    {
        return optional($this->articulation->end_date)->isoFormat('DD/MM/YYYY');
    }

    public function articulationExpectedEndDate()
    {
        return optional($this->articulation->expected_end_date)->isoFormat('DD/MM/YYYY');
    }

    public function articulationEntity()
    {
        return isset($this->articulation->entity) ? $this->articulation->entity : 'No registra';
    }

    public function articulationSubtype()
    {
        return isset($this->articulation->articulationsubtype) ? $this->articulation->articulationsubtype->articulationtype->name .' / '. $this->articulation->articulationsubtype->name : 'No registra';
    }

    public function articulationContactName()
    {
        return isset($this->articulation->contact_name) ? $this->articulation->contact_name : 'No registra';
    }

    public function articulationEmailEntity()
    {
        return isset($this->articulation->email_entity) ? $this->articulation->email_entity : 'No registra';
    }

    public function articulationSummonName()
    {
        return isset($this->articulation->summon_name) ? $this->articulation->summon_name : 'No registra';
    }

    public function articulationPhase()
    {
        return isset($this->articulation->phase) ? $this->articulation->phase->nombre : 'No registra';
    }

    public function articulationBy()
    {
        return isset($this->articulation->createdBy) ? $this->articulation->createdBy->present()->userFullName() : 'No registra';
    }
}
