<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Presenters\AccompanimentPresenter;

class Accompaniment extends Model
{
    const CONFIDENCIALITY_FORMAT_YES = 1;
    const CONFIDENCIALITY_FORMAT_NO = 0;
    const  STATUS_OPEN = 1;
    const  STATUS_CLOSE = 0;

    /**
     * The attributes that guarded.
     *
     * @var array
     */
    protected $guarded = ['id', 'status'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_date'    => 'datetime',
        'end_date'    => 'datetime',
        'terms_verified_at'    => 'datetime',
    ];

    /**
     * The attributes that withCount.
     *
     * @var array
     */
    protected $withCount = ['articulations'];



    /**
     * The relation one to much
     *
     *
     */
    public function articulations(){
        return $this->hasMany(Articulation::class);
    }


    /**
     * The inverse polymorfic relation much to much
     *
     *
     */
    public function projects()
    {
        return $this->morphedByMany(Proyecto::class, 'accompanimentable');
    }

    /**
     * The inverse polymorfic relation much to much
     *
     * @return void
     */
    public function sedes(){
        return $this->morphedByMany(Sede::class, 'accompanimentable');
    }

    public function accompanimentable()
    {
        return $this->morphTo();
    }

    /**
     * Define an inverse one to many relationship between accompanient and node
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function node()
    {
        return $this->belongsTo(Nodo::class, 'node_id', 'id');
    }

    /**
     * Define an inverse one to many relationship between accompanient and node
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function interlocutor()
    {
        return $this->belongsTo(\App\User::class, 'interlocutor_talent_id', 'id');
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

    public function file()
    {
        return $this->morphOne(ArchivoModel::class, 'model');
    }


    /**
     * The query scope status
     *
     * @return void
     */
    public function scopestatus($query, $status)
    {
        if (isset($status) && $status != 'all' && $status != null) {
            return $query->orWhere('status', $status);
        }
        return $query;
    }

    /**
     * The query scope node
     *
     * @return void
     */
    public function scopeNode($query, $node)
    {
        if (!empty($node) && $node != null && $node != 'all') {
            return $query->where('node_id', $node);

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
            return $query->whereYear('end_date', $year)
                    ->orWhereYear('start_date', $year);

        }
        return $query;
    }

    /**
     * The query scope asesor
     *
     * @return void
     */
    public function scopeInterlocutorTalent($query, $talent)
    {
        if (!empty($talent) && $talent != null && $talent != 'all') {
            return $query->where('interlocutor_talent_id', $talent);

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
        return new AccompanimentPresenter($this);
    }
}
