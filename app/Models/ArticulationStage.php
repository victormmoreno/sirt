<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Presenters\ArticulationStagePresenter;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;


class ArticulationStage extends Model
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

    public function notifications()
    {
        return $this->morphMany(ControlNotificaciones::class, 'notificable');
    }


    /**
     * Define an inverse one to many relationship between accompanient and node
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function interlocutor()
    {
        return $this->belongsTo(\App\User::class, 'interlocutor_talent_id', 'id')->withTrashed();
    }

    /**
     * Define an inverse one to many relationship between accompanient and node
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(\App\User::class, 'created_by', 'id')->withTrashed();
    }

    public function file()
    {
        return $this->morphOne(ArchivoModel::class, 'model');
    }

    public function traceability()
    {
        return $this->morphMany(HistorialEntidad::class, 'model');
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
        return new ArticulationStagePresenter($this);
    }

    /**
     * Registra el control de una notificación
     *
     * @param int $receptor id del receptor de la notificacion
     * @param string $rol_receptor Nombre del rol que espera la notificación
     * @return ControlNotificacion
     */
    public function registerNotify($receptor, $rol_receptor, $fase = null)
    {
        return $this->notifications()->create([
            'fase_id' => null,
            'remitente_id' => auth()->user()->id,
            'rol_remitente_id' => Role::where('name', Session::get('login_role'))->first()->id,
            'receptor_id' => $receptor,
            'rol_receptor_id' => Role::where('name', $rol_receptor)->first()->id,
            'fecha_envio' => Carbon::now(),
            'fecha_aceptacion' => null
        ]);
    }

    public function createTraceability($movement, $comment, $description)
    {
        return $this->traceability()->create([
            'movimiento_id' => Movimiento::where('movimiento', $movement)->first()->id,
            'user_id' => auth()->user()->id,
            'role_id' =>  Role::where('name', Session::get('login_role'))->first()->id,
            'comentarios' => $comment,
            'descripcion' => $description
        ]);
    }


}
