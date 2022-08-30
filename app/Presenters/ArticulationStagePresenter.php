<?php

namespace App\Presenters;

use App\Models\ArticulationStage;

class ArticulationStagePresenter extends Presenter
{
    protected $accompaniment;

    public function __construct(ArticulationStage $accompaniment)
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
        return $this->accompaniment->status == ArticulationStage::STATUS_OPEN ? __('Open') : __('Close');
    }

    public function accompanimentCreatedDate()
    {
        return optional($this->accompaniment->created_at)->isoFormat('DD/MM/YYYY');
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
        return $this->accompaniment->confidentiality_format ? ($this->accompaniment->confidentiality_format == 1 ? 'Aceptado' : 'No aceptado') : 'No registra';
    }

    public function accompanimentTermsVerifiedAt()
    {
        return optional($this->accompaniment->terms_verified_at)->isoFormat('DD/MM/YYYY');
    }

    public function accompanimentables()
    {
        if( $this->accompaniment->projects->count() > 0 &&
            $this->accompaniment->whereHasMorph(
                'articulationable',
                [\App\Models\Proyecto::class]
            )
        ){
            return $this->accompaniment->projects->map(function ($item) {
                if(isset($item)){
                    return $item->articulacion_proyecto->actividad->codigo_actividad . ' - '.  $item->articulacion_proyecto->actividad->nombre;
                }
                return "No registra";
            })->implode(',');
        }
    }



    public function accompanimentableLink()
    {
        if( $this->accompaniment->projects->count() > 0 &&
            $this->accompaniment->whereHasMorph(
                'articulationable',
                [\App\Models\Proyecto::class]
            )
        ){
            return $this->accompaniment->projects->map(function ($item) {
                if(isset($item)){
                    return '<a class="orange-text text-darken-1" target="_blank"  href="'.route('proyecto.detalle', $this->accompanimentableId()).'">'.$this->accompanimentables().'</a>';
                }
            })->implode(',');
        }
    }

    public function accompanimentableId()
    {
        if( $this->accompaniment->projects->count() > 0 &&
            $this->accompaniment->whereHasMorph(
                'articulationable',
                [\App\Models\Proyecto::class]
            )
        ){
            return $this->accompaniment->projects->map(function ($item) {
                if(isset($item)){
                    return $item->id;
                }
            })->implode(',');
        }
    }

    public function accompanimentableObjetive()
    {
        if( $this->accompaniment->projects->count() > 0 &&
            $this->accompaniment->whereHasMorph(
                'articulationable',
                [\App\Models\Proyecto::class]
            )
        ){
            return $this->accompaniment->projects->map(function ($item) {
                if(isset($item)){
                    return $item->articulacion_proyecto->actividad->objetivo_general;
                }
            })->implode(',');
        }
    }

    public function accompanimentableEndDate()
    {
        if( $this->accompaniment->projects->count() > 0 &&
            $this->accompaniment->whereHasMorph(
                'articulationable',
                [\App\Models\Proyecto::class]
            )
        ){
            return $this->accompaniment->projects->map(function ($item) {
                if(isset($item)){
                    return optional($item->articulacion_proyecto->actividad->fecha_cierre)->isoFormat('DD/MM/YYYY');
                }
            })->implode(',');
        }
    }

    public function accompanimentableType()
    {
        if( $this->accompaniment->projects->count() > 0 &&
            $this->accompaniment->whereHasMorph(
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

    public function accompanimentArticulation()
    {
        return $this->accompaniment->articulations->map(function ($item) {
            if(isset($item)){
                return "{$item->code}";
            }
        })->implode(', ');
    }

    public function accompanimentNameConfidentialityFormat()
    {

        if(isset($this->accompaniment->file)){
            if(auth()->user()->can('update', $this->accompaniment)){
                return '<li class="collection-item avatar">
                    <i class="material-icons circle">insert_drive_file</i>
                    <span class="title">'.__('Confidentiality Format').'</span>
                    <p>'.basename( url($this->accompaniment->file->ruta) ).'<br>
                        <a class="orange-text" target="_blank" href='.route('articulation-stage.download', $this->accompaniment).'>Descargar</a>
                    </p><form method="POST" action="'.route('articulation-stage.file.destroy', $this->accompaniment->file).'">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                        <button class="secondary-content red-text">
                            <i class="material-icons">delete_forever</i>
                        </button>
                    </form>
                </li>';
            }else{
                return '<li class="collection-item avatar">
                    <i class="material-icons circle">insert_drive_file</i>
                    <span class="title">'.__('Confidentiality Format').'</span>
                    <p>'.basename( url($this->accompaniment->file->ruta) ).'<br>
                        <a class="orange-text" target="_blank" href='.route('accompaniments.download', $this->accompaniment).'>Descargar</a>
                    </p>
                </li>';
            }

        }

        // return $this->articulations->file ? basename( url($this->articulations->file->ruta) ) : '';
    }
}
