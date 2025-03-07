<?php

namespace App\Presenters;

use App\Models\ArticulationStage;

class ArticulationStagePresenter extends Presenter
{
    protected $articulationStage;

    public function __construct(ArticulationStage $articulationStage)
    {
        $this->articulationStage = $articulationStage;
    }

    public function articulationStageCode()
    {
        return isset($this->articulationStage->code) ? $this->articulationStage->code : 'No registra';
    }

    public function articulationStageName()
    {
        return isset($this->articulationStage->name) ? $this->articulationStage->name : 'No registra';
    }

    public function articulationStageDescription()
    {
        return isset($this->articulationStage->description) ? $this->articulationStage->description : 'No registra';
    }

    public function articulationStageExpectedResults()
    {
        return isset($this->articulationStage->expected_results) ? $this->articulationStage->expected_results : 'No registra';
    }

    public function articulationStageScope()
    {
        return isset($this->articulationStage->scope) ? $this->articulationStage->scope : 'No registra';
    }

    public function articulationStageBy()
    {
        return isset($this->articulationStage->createdBy) ? $this->articulationStage->createdBy->present()->userDocumento() . ' - '. $this->articulationStage->createdBy->present()->userFullName() : 'No registra';
    }

    public function articulationStageStatus()
    {
        return $this->articulationStage->status == ArticulationStage::STATUS_OPEN ? __('Open') : __('Close');
    }

    public function articulationStageStatusStartEnd()
    {
        return $this->articulationStage->status == ArticulationStage::STATUS_OPEN ? 'inicio' : 'cierre';
    }

    public function articulationStageStatusStartEndInverse()
    {
        return $this->articulationStage->status == ArticulationStage::STATUS_OPEN ? 'cierre' : 'inicio';
    }

    public function articulationStageEndorsement()
    {
        return $this->articulationStage->endorsement == ArticulationStage::ENDORSEMENT_YES ? 'abrir' : 'Cerrar';
    }
    public function articulationStageEndorsementApproval()
    {
        return $this->articulationStage->endorsement == ArticulationStage::ENDORSEMENT_YES ? 'cerrar' : 'abrir';
    }
    public function articulationStageStatusColor()
    {
        return $this->articulationStage->status == ArticulationStage::STATUS_OPEN ? 'green' : 'red';
    }

    public function articulationStageCreatedDate()
    {
        return optional($this->articulationStage->created_at)->isoFormat('YYYY/MM/DD');
    }


    public function articulationStageStartDate()
    {
        return optional($this->articulationStage->start_date)->isoFormat('YYYY/MM/DD');
    }

    public function articulationStageEndDate()
    {
        if($this->articulationStage->status == ArticulationStage::STATUS_OPEN && isset($this->articulationStage->end_date)){
            return optional($this->articulationStage->end_date)->isoFormat('YYYY/MM/DD');
        }
        return "No aplica";

    }

    public function articulationStageNode()
    {
        return isset($this->articulationStage->node->entidad) ? $this->articulationStage->node->entidad->nombre : 'No Registra';
    }

    public function articulationStageInterlocutorTalent()
    {
        return $this->articulationStage->has('interlocutor') ? $this->articulationStage->interlocutor->present()->userDocumento() . ' - '. $this->articulationStage->interlocutor->present()->userFullName() : 'No Registra';
    }


    public function articulationStageTermsVerifiedAt()
    {
        return optional($this->articulationStage->terms_verified_at)->isoFormat('DD/MM/YYYY');
    }

    public function articulationStageables()
    {
        if( $this->articulationStage->projects->count() > 0 &&
            $this->articulationStage->whereHasMorph(
                'articulationable',
                [\App\Models\Proyecto::class]
            )
        ){
            return $this->articulationStage->projects->map(function ($item) {
                if(isset($item)){
                    return $item->codigo_proyecto . ' - '.  $item->nombre;
                }
                return "No registra";
            })->implode(',');
        }
    }



    public function articulationStageableLink()
    {
        if( $this->articulationStage->projects->count() > 0 &&
            $this->articulationStage->whereHasMorph(
                'articulationable',
                [\App\Models\Proyecto::class]
            )
        ){
            return $this->articulationStage->projects->map(function ($item) {
                if(isset($item)){
                    return '<a class="primary-text" target="_blank"  href="'.route('proyecto.detalle', $this->articulationStageableId()).'">'.$this->articulationStageables().'</a>';
                }
            })->implode(',');
        }
    }

    public function articulationStageableId()
    {
        if( $this->articulationStage->projects->count() > 0 &&
            $this->articulationStage->whereHasMorph(
                'articulationable',
                [\App\Models\Proyecto::class]
            )
        ){
            return $this->articulationStage->projects->map(function ($item) {
                if(isset($item)){
                    return $item->id;
                }
            })->implode(',');
        }
    }

    public function articulationStageableObjetive()
    {
        if( $this->articulationStage->projects->count() > 0 &&
            $this->articulationStage->whereHasMorph(
                'articulationable',
                [\App\Models\Proyecto::class]
            )
        ){
            return $this->articulationStage->projects->map(function ($item) {
                if(isset($item)){
                    return $item->objetivo_general;
                }
            })->implode(',');
        }
    }

    public function articulationStageableEndDate()
    {
        if( $this->articulationStage->projects->count() > 0 &&
            $this->articulationStage->whereHasMorph(
                'articulationable',
                [\App\Models\Proyecto::class]
            )
        ){
            return $this->articulationStage->projects->map(function ($item) {
                if(isset($item)){
                    return optional($item->fecha_cierre)->isoFormat('DD/MM/YYYY');
                }
            })->implode(',');
        }
    }

    public function articulationStageableType()
    {
        if( $this->articulationStage->projects->count() > 0 &&
            $this->articulationStage->whereHasMorph(
                'articulationable',
                [\App\Models\Proyecto::class]
            )
        ){
            return "Proyecto";
        }
        else{
            return "No registra";
        }
    }

    public function articulationStageArticulation()
    {
        return $this->articulationStage->articulations->map(function ($item) {
            if(isset($item)){
                return "{$item->code}";
            }
        })->implode(', ');
    }

    public function articulationStageCountArticulations()
    {
        if (isset($this->articulationStage)) {
            return "{$this->articulationStage->articulations_count}";
        }
        return 0;
    }
}
