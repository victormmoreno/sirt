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
        return isset($this->articulation->scope) ? $this->articulation->scope : 'No registra';
    }

    public function articulationStatus()
    {
        return $this->articulation->status == Accompaniment::STATUS_OPEN ? __('Open') : __('Close');
    }

    public function articulationStartDate()
    {
        return optional($this->articulation->start_date)->isoFormat('DD/MM/YYYY');
    }

    public function articulationEndDate()
    {
        return optional($this->articulation->end_date)->isoFormat('DD/MM/YYYY');
    }

    public function articulationNode()
    {
        return $this->articulation->has('node.entidad') ? $this->articulation->node->entidad->nombre : 'No Registra';
    }

    public function articulationInterlocutorTalent()
    {
        return $this->articulation->has('interlocutor') ? $this->articulation->interlocutor->present()->userFullName() : 'No Registra';
    }

    public function articulationConfidentialityFormat()
    {
        return $this->articulation->confidentiality_format ? : 'No Registra';
    }

    public function articulationTermsVerifiedAt()
    {
        return optional($this->articulation->terms_verified_at)->isoFormat('DD/MM/YYYY');
    }
}
