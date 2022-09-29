<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Presenters\ArticulationPresenter;

class Articulation extends Model
{

    const START_PHASE = "Inicio";
    const EXECUTION_PHASE = "Ejecución";
    const CLOSING_PHASE = "Cierre";
    const SUSPENDED_PHASE = "Suspendido";
    const FINISHED_PHASE = "Finalizado";

    /**
     * The attributes that guarded.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_date'    => 'datetime',
        'end_date'    => 'datetime',
        'expected_end_date'    => 'datetime',
    ];

    /**
     * The attributes that withCount.
     *
     * @var array
     */
    protected $withCount = ['users'];

    /**
     * The inverse relation one to much
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function articulationstage(){
        return $this->belongsTo(ArticulationStage::class, 'articulation_stage_id');
    }

    /**
     * The inverse relation one to much
     *
     * @return void
     */
    public function articulationsubtype(){
        return $this->belongsTo(ArticulationSubtype::class, 'articulation_subtype_id');
    }

    public function archivomodel()
    {
        return $this->morphOne(ArchivoModel::class, 'model');
    }


    public function users()
    {
        return $this->belongsToMany(\App\User::class, 'articulation_user', 'articulation_id', 'user_id');
    }

    /**
     * The relation one to much scope
     *
     * @return void
     */
    public function scope(){
        return $this->belongsTo(AlcanceArticulacion::class, 'scope_id');
    }

    /**
     * The relation one to much phase
     *
     * @return void
     */
    public function phase(){
        return $this->belongsTo(Fase::class, 'phase_id');
    }

    /**
     * Define an inverse one to many relationship between accompanient and node
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(\App\User::class, 'created_by', 'id');
    }


    /**
     * asesor
     */
    public function getProgressAttribute(): int
    {
        $progress = 0;
        isset($this->phase) && $this->phase->nombre == Self::START_PHASE ? $progress = round((100/4)*1, 1) :
        (
            $this->phase->nombre == Self::EXECUTION_PHASE ? $progress = round((100/4)*2, 1) :
            (
                $this->phase->nombre == Self::CLOSING_PHASE ? $progress = round((100/4)*3, 1) :
                (
                    $this->phase->nombre == Self::FINISHED_PHASE ? $progress = round((100/4)*4, 1) : $progress = 0
                )
            )
        );
        return $progress;
    }

    /**
     * The query scope status
     *
     * @return void
     */
    public function scopeArticulationStageStatus($query, $status)
    {
        if (isset($status) && $status != 'all' && $status != null) {
            return $query->whereHas('articulationstage', function ($subquery) use ($status) {
                $subquery->where('status', $status);
            });
        }
        return $query;
    }

    /**
     * The query scope node
     *
     * @return void
     */
    public function scopeArticulationStageYear($query, $year)
    {
        if (!empty($year) && $year != null && $year != 'all') {
            return $query
                ->WhereHas('articulationstage', function ($subquery) use ($year) {
                $subquery->whereYear('articulation_stages.start_date', $year)
                    ->orWhereYear('articulation_stages.end_date', $year);
            });
        }
        return $query;
    }

    /**
     * The query scope node
     *
     * @return void
     */
    public function scopeYear($query, $year)
    {
        if (!empty($year) && $year != null && $year != 'all') {
            return $query->orWhereYear('articulations.start_date', $year)
                    ->orWhereYear('articulations.end_date', $year);
        }
        return $query;
    }

    /**
     * The query scope node
     *
     * @return void
     */
    public function scopeArticulationStageNode($query, $node)
    {
        if (!empty($node) && $node != null && $node != 'all') {
            return $query->whereHas('articulationstage', function ($subquery) use ($node) {
                $subquery->where('node_id', $node);
            });
        }
        return $query;
    }
    /**
     * The query scope node
     *
     * @return void
     */
    public function scopeArticulationStageInterlocutorTalent($query, $talent)
    {
        if (!empty($talent) && $talent != null && $talent != 'all') {
            return $query->whereHas('articulationstage', function ($query) use($talent) {
                    return $query->where('interlocutor_talent_id', $talent);
                })->orWhereHas('users', function ($query) use($talent) {
                    return $query->where('users.id', $talent);
                });
        }
        return $query;
    }



        /**
     * The presenter
     *
     * @return void
     */
    public function present()
    {
        return new ArticulationPresenter($this);
    }
}
