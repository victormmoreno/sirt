<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Presenters\ArticulacionPbtPresenter;
use App\User;

class ArticulacionPbt extends Model
{
    protected $table = 'articulacion_pbts';

    const IS_PBT = 1;
    const IS_SENAINNOVA  = 2;
    const IS_COLINNOVA  = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipo_vinculacion',
        // 'actividad_id',
        'asesor_id',
        'nodo_id',
        // 'proyecto_id',
        // 'sede_id',
        'fase_id',
        'tipo_articulacion_id',
        'alcance_articulacion_id',
        'articulable_id',
        'articulable_type',
        'codigo',
        'nombre',
        'fecha_inicio',
        'fecha_cierre',
        'formulario_inicio',
        'seguimiento',
        'entidad',
        'nombre_contacto',
        'email_entidad',
        'nombre_convocatoria',
        'objetivo',
        'fecha_esperada_finalizacion',
        'lecciones_aprendidas',
        'aprobacion_dinamizador',
        'aprobacion_dinamizador_ejecucion',
        'aprobacion_dinamizador_suspender',
        'postulacion',
        'aprobacion',
        'justificacion',
        'informe_justificado',
        'informe_noaprobado',
        'recibira',
        'pdf_aprobacion',
        'pdf_noaprobacion',
        'informe',
        'documento_postulacion',
        'documento_convocatoria',
        'cuando'
    ];

    protected $dates = [
        'fecha_esperada_finalizacion',
        'cuando',
        'fecha_inicio',
        'fecha_cierre'
    ];

    public static function IsPbt()
    {
        return self::IS_PBT;
    }

    public static function IsSenaInnova()
    {
        return self::IS_SENAINNOVA;
    }

    public static function IsColinnova()
    {
        return self::IS_COLINNOVA;
    }

    /**
     * Define an inverse one-to-one or many relationship between articulacion_pbts and users
     * @author devjul
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function asesor()
    {
        return $this->belongsTo(User::class, 'asesor_id', 'id');
    }

    /**
     * Define an inverse one-to-one or many relationship between articulacion_pbts and node
     * @author devjul
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nodo()
    {
        return $this->belongsTo(Nodo::class, 'nodo_id', 'id');
    }

    /**
     * Define a polymorphic, inverse many-to-many relationship between articulacion_pbts and projects
     * @author dum
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function articulable()
    {
        return $this->MorphTo();
    }

    public function usoinfraestructura()
    {
        return $this->morphOne(UsoInfraestructura::class, 'asesorable');
    }

    // public function actividad()
    // {
    //     return $this->belongsTo(Actividad::class, 'actividad_id', 'id');
    // }

    // public function proyecto()
    // {
    //     return $this->belongsTo(Proyecto::class, 'proyecto_id', 'id');
    // }

    public function fase()
    {
        return $this->belongsTo(Fase::class, 'fase_id', 'id');
    }

    public function tipoarticulacion()
    {
        return $this->belongsTo(TipoArticulacion::class, 'tipo_articulacion_id', 'id');
    }

    public function alcancearticulacion()
    {
        return $this->belongsTo(AlcanceArticulacion::class, 'alcance_articulacion_id', 'id');
    }

    public function archivomodel()
    {
        return $this->morphOne(ArchivoModel::class, 'model');
    }

    // public function sede()
    // {
    //     return $this->belongsTo(Sede::class, 'sede_id', 'id');
    // }

    public function talentos()
    {
        return $this->belongsToMany(Talento::class, 'articulaciones_pbt_talento')
            ->withTimestamps()
            ->withPivot('talento_lider');
    }

    public function historial()
    {
        return $this->morphMany(HistorialEntidad::class, 'model');
    }

    public function scopeTipoArticulacion($query, $tipoArticulacion)
    {
        if (!empty($tipoArticulacion) && $tipoArticulacion != 'all' && $tipoArticulacion != null) {
            return $query->where('tipo_articulacion_id', $tipoArticulacion);
        }
        return $query;
    }

    public function scopeAlcanceArticulacion($query, $alcanceArticulacion)
    {
        if (!empty($alcanceArticulacion) && $alcanceArticulacion != 'all' && $alcanceArticulacion != null) {
            return $query->where('alcance_articulacion_id', $alcanceArticulacion);
        }
        return $query;
    }

    public function scopeNodo($query, $nodo)
    {
        if (!empty($nodo) && $nodo != null && $nodo != 'all') {
            return $query->where('nodo_id', $nodo);

        }
        return $query;
    }

    public function scopeStarEndDate($query, $year)
    {
        if (!empty($year) && $year != null && $year != 'all') {
            return $query->whereYear('fecha_inicio', $year)->orWhereYear('fecha_cierre', $year);

        }
        return $query;
    }

    public function scopeFase($query, $fase)
    {
        if (!empty($fase) && $fase != 'all' && $fase != null) {
            return $query->where('fase_id', $fase);
        }
        return $query;
    }

    public function scopeArticulacionesArticulador($query)
    {
        return $query
            ->where(function($subquery){
                $subquery->where('fase_id', Fase::IsInicio())
                ->orwhere('fase_id', Fase::IsPlaneacion())
                ->orwhere('fase_id', Fase::IsEjecucion());
            })->get()
            ->pluck('nombre','codigo' );

    }

    public function scopeTalents($query, $talent){
        if (!empty($talent) && $talent != 'all' && $talent != null) {
            return $query->whereHas('talentos', function($query) use($talent){
                $query->where('talento_id', $talent);
            });
        }
        return $query;
    }

    public function present()
    {
        return new ArticulacionPbtPresenter($this);
    }

    public function registerHistoryArticulacion($movimiento, $role, $comentario, $descripcion)
    {
        return $this->historial()->create([
            'movimiento_id' => Movimiento::where('movimiento', $movimiento)->first()->id,
            'user_id' => auth()->user()->id,
            'role_id' => Role::where('name', $role)->first()->id,
            'comentarios' => $comentario,
            'descripcion' => $descripcion
        ]);
    }

    public function scopeArticulacionesWithRelations($query, array $relations)
    {
        return $query->with($relations);
    }
}
