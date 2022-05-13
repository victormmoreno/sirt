<?php

namespace App\Presenters;

use App\Models\Accompaniment;

class AccompanimentPresenter extends Presenter
{
    protected $accompaniment;

    public function __construct(Accompaniment $accompaniment)
    {
        $this->accompaniment = $accompaniment;
    }

    public function accompanimentCode()
    {
        return isset($this->accompaniment->code) ? $this->accompaniment->code : 'No registra';
    }

    public function accompanimentName()
    {
        return isset($this->accompaniment->name) ? $this->accompaniment->name : 'No registra';
    }

    public function accompanimentDescription()
    {
        return isset($this->accompaniment->description) ? $this->accompaniment->description : 'No registra';
    }

    public function accompanimentScope()
    {
        return isset($this->accompaniment->scope) ? $this->accompaniment->scope : 'No registra';
    }

    public function accompanimentBy()
    {
        return isset($this->accompaniment->createdBy) ? $this->accompaniment->createdBy->present()->userFullName() : 'No registra';
    }

    public function accompanimentStatus()
    {
        return $this->accompaniment->status == Accompaniment::STATUS_OPEN ? __('Open') : __('Close');
    }

    public function accompanimentStartDate()
    {
        return optional($this->accompaniment->start_date)->isoFormat('DD/MM/YYYY');
    }

    public function accompanimentEndDate()
    {
        return optional($this->accompaniment->end_date)->isoFormat('DD/MM/YYYY');
    }

    public function accompanimentNode()
    {
        return $this->accompaniment->has('node.entidad') ? $this->accompaniment->node->entidad->nombre : 'No Registra';
    }

    public function accompanimentInterlocutorTalent()
    {
        return $this->accompaniment->has('interlocutor') ? $this->accompaniment->interlocutor->present()->userFullName() : 'No Registra';
    }

    public function accompanimentConfidentialityFormat()
    {
        return $this->accompaniment->confidentiality_format ? : 'No Registra';
    }

    public function accompanimentTermsVerifiedAt()
    {
        return optional($this->accompaniment->terms_verified_at)->isoFormat('DD/MM/YYYY');
    }
}
