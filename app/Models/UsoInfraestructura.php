<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Presenters\UsoInfraestructuraPresenter;
use Illuminate\Database\Eloquent\Builder;

class UsoInfraestructura extends Model
{
    protected $table = 'usoinfraestructuras';

    const IS_PROYECTO     = 0;
    const IS_ARTICULACION = 1;
    const IS_EDT          = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'asesorable_id',
        'asesorable_type',
        'tipo_usoinfraestructura',
        'fecha',
        'descripcion',
        'compromisos',
        'estado',
    ];

    protected $dates = [
        'fecha',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [

        'tipo_usoinfraestructura' => 'integer',
        'fecha'                   => 'date:Y-m-d',
        'descripcion'             => 'string',
        'compromisos'             => 'string',
        'estado'                  => 'boolean',
    ];

    public static function IsProyecto()
    {
        return self::IS_PROYECTO;
    }

    public static function IsArticulacion()
    {
        return self::IS_ARTICULACION;
    }

    public static function IsEdt()
    {
        return self::IS_EDT;
    }

    public function asesorable()
    {
        return $this->morphTo();
    }


    // public function actividad()
    // {
    //     return $this->belongsTo(Actividad::class, 'actividad_id', 'id');
    // }

    public function usoequipos()
    {
        return $this->belongsToMany(Equipo::class, 'equipo_uso', 'usoinfraestructura_id', 'equipo_id')
            ->withTimestamps()
            ->withPivot([
                'tiempo',
                'costo_equipo',
                'costo_administrativo',
            ]);
    }

    public function usomateriales()
    {
        return $this->belongsToMany(Material::class, 'material_uso', 'usoinfraestructura_id', 'material_id')
            ->withTimestamps()
            ->withPivot([
                'costo_material',
                'unidad',
            ]);
    }

    public function usotalentos()
    {
        return $this->belongsToMany(Talento::class, 'uso_talentos', 'usoinfraestructura_id', 'talento_id')
            ->withTimestamps();
    }


    public function usogestores()
    {
        // return $this->belongsToMany(Gestor::class, 'gestor_uso', 'usoinfraestructura_id', 'gestor_id')
        //     ->withTimestamps()
        //     ->withPivot([
        //         'asesoria_directa',
        //         'asesoria_indirecta',
        //         'costo_asesoria',
        //     ]);

        return $this->morphedByMany(User::class, 'asesorable', 'gestor_uso', 'usoinfraestructura_id')->withTimestamps()
        ->withPivot([
            'asesoria_directa',
            'asesoria_indirecta',
            'costo_asesoria',
        ])->withTrashed();
    }

    public function setDescripcionAttribute($descripcion)
    {
        $this->attributes['descripcion'] = ucwords(mb_strtolower(trim($descripcion), 'UTF-8'));
    }

    public function getDescripcionAttribute($descripcion)
    {
        return ucwords(strtolower(trim($descripcion)));
    }

    /**
     * Elimina los datos de material_uso
     *
     * @param Collection $data
     * @return void
     */
    public static function deleteUsoMateriales($data)
    {
        foreach ($data->usoinfraestructuras as $key => $value) {
            $value->usomateriales()->sync([]);
        }
    }


    /**
     * Elimina los datos de uso_talento
     *
     * @param Collection $data
     * @return void
     */
    public static function deleteUsoTalentos($data)
    {
        foreach ($data->usoinfraestructuras as $key => $value) {
            $value->usotalentos()->sync([]);
        }
    }

    /**
     * Elimina los datos de equipo_uso
     *
     * @param Collection $data
     * @return void
     */
    public static function deleteUsoEquipos($data)
    {
        foreach ($data->usoinfraestructuras as $key => $value) {
            $value->usoequipos()->sync([]);
        }
    }

    /**
     * Elimina los datos de gestor_uso
     *
     * @param Collection $data
     * @return void
     */
    public static function deleteUsoGestores($data)
    {
        foreach ($data->usoinfraestructuras as $key => $value) {
            $value->usogestores()->sync([]);
        }
    }

    public static function TipoUsoInfraestructura($tipo_usoinfraestructura)
    {
        if ($tipo_usoinfraestructura == self::IsProyecto()) {
            return 'Proyecto ';
        } else if ($tipo_usoinfraestructura == self::IsArticulacion()) {
            return 'Articulación ';
        } else {
            return 'No registra';
        }
    }

    public function scopeUsoInfraestructuraWithRelations($query, array $relations)
    {
        return $query->with($relations);
    }

    public function scopeNodoAsesoria($query, $nodo)
    {
        if (isset($nodo) && $nodo != null && $nodo != 'all') {
            $query->whereHasMorph(
                'asesorable',
                [ \App\Models\Proyecto::class, \App\Models\ArticulacionPbt::class],
                function (Builder $subquery) use($nodo) {
                    $subquery->where('nodo_id', $nodo);
                }
            );
        }
        return $query;
    }

    public function scopeAsesoria($query, $actividad, $user)
    {   if ((session()->has('login_role') && session()->get('login_role') == User::IsArticulador()) && (!empty($user) && $user != null && $user != 'all')) {
            if ((!empty($actividad) && $actividad != null && $actividad != 'all')) {
                $query->whereHasMorph(
                    'asesorable',
                    \App\Models\ArticulacionPbt::class,
                    function (Builder $subquery) use($actividad, $user) {
                        return $subquery->where('id', $actividad)
                        ->orWhereHas('asesor', function ($subquery) use ($user) {
                            $subquery->where('id', $user);
                        });
                    }
                )->whereHasMorph('asesorable', \App\Models\Proyecto::class);
            } elseif ((!empty($actividad) && $actividad != null && $actividad == 'all')) {
                $query->whereHasMorph(
                    'asesorable.asesor',
                    \App\Models\ArticulacionPbt::class,
                    function (Builder $subquery) use( $user) {
                        return $subquery->where('id', $user);
                    }
                )->whereHasMorph('asesorable', \App\Models\Proyecto::class);
            }
        }
        else if ((session()->has('login_role') && session()->get('login_role') == User::IsGestor()) && (!empty($user) && $user != null && $user != 'all')) {
            if ((!empty($actividad) && $actividad != null && $actividad != 'all')) {
                $query->whereHasMorph(
                    'asesorable',
                    [ \App\Models\Proyecto::class],
                    function (Builder $subquery) use($actividad, $user) {
                        return $subquery->whereHas('articulacion_proyecto.actividad', function($q) use($actividad){
                            $q->where('id', $actividad);
                        })
                        ->orWhereHas('asesor.user', function ($subquery) use ($user) {
                            $subquery->where('id', $user);
                        });
                    }
                )->whereHasMorph('asesorable', \App\Models\Proyecto::class);
            } elseif ((!empty($actividad) && $actividad != null && $actividad == 'all')) {
                $query->whereHasMorph(
                    'asesorable',
                    [ \App\Models\Proyecto::class],
                    function (Builder $subquery) use( $user) {
                        return $subquery->whereHas('asesor.user', function ($subquery) use ($user) {
                            $subquery->where('id', $user);
                        });
                    }
                )->whereHasMorph('asesorable', \App\Models\Proyecto::class);
            }
        } else if ((session()->has('login_role') && session()->get('login_role') == User::IsTalento()) && (!empty($user) && $user != null && $user != 'all')) {
            if ((!empty($actividad) && $actividad != null && $actividad != 'all')) {
                return $query->whereHas(
                    'usotalentos.user',
                    function (Builder $query) use($user) {
                        return $query->where('id', $user);
                    }
                );
            } elseif ((!empty($actividad) && $actividad != null && $actividad == 'all')) {
                return $query->whereHas('usotalentos.user',  function ($subquery) use ($user) {
                    $subquery->where('id', $user);
                });
            } elseif ((!empty($actividad) && $actividad == null && $actividad != 'all')) {
                return $query->whereHas('usotalentos.user',  function ($subquery) use ($user) {
                    $subquery->where('id', $user);
                });
            }
        }
        return $query;
    }

    public function scopeAsesor($query, $asesor = null)
    {
        if (!empty($asesor) && $asesor != null && $asesor == 'all') {
            return $query->whereHasMorph(
                'asesorable',
                [ \App\Models\Proyecto::class, \App\Models\ArticulacionPbt::class]
            );
        }

        if ((!empty($asesor) && $asesor != null && $asesor != 'all')) {

            if((session()->has('login_role') && session()->get('login_role') == User::IsArticulador())){
                return $query->whereHas(
                    'usogestores',
                    function (Builder $query) use($asesor) {
                        return $query->where('users.id', $asesor);

                    }
                )->whereHasMorph('asesorable', \App\Models\ArticulacionPbt::class);
            }
            if((session()->has('login_role') && (session()->get('login_role') == User::IsApoyoTecnico() || session()->get('login_role') == User::IsGestor()))){
                return $query->whereHas(
                    'usogestores',
                    function (Builder $query) use($asesor) {
                        return $query->where('users.id', $asesor);
                    }
                )->whereHasMorph('asesorable', \App\Models\Proyecto::class);
            }
            return $query->whereHas(
                'usogestores',
                function (Builder $query) use($asesor) {
                    return $query->where('users.id', $asesor);
                }
            );
            // return $query->whereHasMorph(
            //     'asesorable',
            //     [ \App\Models\Proyecto::class],
            //     function (Builder $subquery) use($asesor) {
            //         return $subquery->wherehas('asesor.user', function ($query) use ($asesor) {
            //             $query->where(function ($subquery) use ($asesor) {
            //                 $subquery->where('id', $asesor);
            //             });
            //         });

            //     }
            // )->orWhereHasMorph(
            //     'asesorable',
            //     [\App\Models\ArticulacionPbt::class],
            //     function (Builder $subquery) use($asesor) {
            //         return $subquery->whereHas('asesor',function ($query) use ($asesor) {
            //             $query->where(function ($subquery) use ($asesor) {
            //                 $subquery->where('id', $asesor);
            //             });
            //         });
            //     }
            // );
        }
        return $query;
    }

    public function scopeYearAsesoria($query, $year)
    {
        if (!empty($year) && $year != null && $year == 'all') {
            return $query->whereHasMorph(
                'asesorable',
                [ \App\Models\Proyecto::class, \App\Models\ArticulacionPbt::class]
            );
        }

        if ((!empty($year) && $year != null && $year != 'all')) {
            $query->whereHasMorph(
                'asesorable',
                [ \App\Models\Proyecto::class, \App\Models\ArticulacionPbt::class],
                function (Builder $subquery) use($year) {
                    return $subquery->whereYear('fecha', $year)->orWhereYear('created_at', $year);
                }
            );
        }
        return $query;
    }

    public function present()
    {
        return new UsoInfraestructuraPresenter($this);
    }
}
