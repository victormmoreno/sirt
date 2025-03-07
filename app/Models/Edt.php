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
        'asesor_id',
        'nodo_id',
        'codigo_edt',
        'nombre',
        'fecha_inicio',
        'fecha_cierre',
        'objetivo_general',
        'conclusiones',
        'formulario_inicio',
        'cronograma',
        'seguimiento',
        'formulario_final',
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

    /**
     * Define an inverse one-to-one or many relationship between edts and users
     * @author devjul
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function asesor()
    {
        return $this->belongsTo(User::class, 'asesor_id', 'id');
    }

    /**
     * Define an inverse one-to-one or many relationship between edts and node
     * @author devjul
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nodo()
    {
        return $this->belongsTo(Nodo::class, 'nodo_id', 'id');
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
