<?php

namespace App\Models;

use App\Http\Traits\EdtTrait\EdtTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Edt extends Model
{
    use EdtTrait;

    protected $table = 'edts';

    /**
     * Constante para el estado de la edt (Activo/Inactivo)
     * @var int
     */
    const IS_INACTIVE = 0;
    const IS_ACTIVE   = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'actividad_id',
        'areaconocimiento_id',
        'tipoedt_id',
        'observaciones',
        'empleados',
        'instructores',
        'aprendices',
        'publico',
        'estado',
        'fotografias',
        'listado_asistencia',
        'informe_final',
    ];

    public function actividad()
    {
        return $this->belongsTo(Actividad::class, 'actividad_id', 'id');
    }

    public function entidades()
    {
        return $this->belongsToMany(Entidad::class, 'edt_entidad')->withTimestamps();
    }

    public function rutamodel()
    {
        return $this->morphMany(RutaModel::class, 'model');
    }

    public function areaconocimiento()
    {
        return $this->belongsTo(AreaConocimiento::class, 'areaconocimiento_id', 'id');
    }

    public function tipoedt()
    {
        return $this->belongsTo(TipoEdt::class, 'tipoedt_id', 'id');
    }

    /**
     * Retorna consulta informacion edt con relaciones
     * @return collection
     */
    public function scopeInfoEdt($query, array $relations = [])
    {
        return $query->with($relations);
    }

}
