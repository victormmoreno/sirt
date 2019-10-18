<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laboratorio extends Model
{

    const IS_ACTIVE   = 1;
    const IS_INACTIVE = 0;
    /**
     * The private column.
     *
     * @var array
     * @author julian londoño
     */
    protected $guarded = [];

    /**
     * The column format.
     *
     * @var array
     * @author julian londoño
     */
    protected $casts = [
        'id'                   => 'integer',
        'nodo_id'              => 'integer',
        'lineatecnologica_id'  => 'integer',
        'nombre'               => 'string',
        'participacion_costos' => 'integer',
        'estado'               => 'integer',
    ];

    /**
     * The name table.
     *
     * @var array
     * @author julian londoño
     */
    protected $table = 'laboratorios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     * @author julian londoño
     */
    protected $fillable = [
        'nodo_id',
        'lineatecnologica_id',
        'nombre',
        'participacion_costos',
        'estado',
    ];

    /**
     * Devolver el laboratorio que coincide con el id dado de la base de datos
     *
     * @param  int $id
     * @author julian londoño
     * @return laboratorio|null
     */
    public function findLaboratorioById($id = null)
    {
        if (!$id) {
            return;
        }

        return $this->where('id', $id)->first();
    }

    public function getNombreAttribute($nombre)
    {
        return ucwords($nombre);
    }

    public function setNombreAttribute($nombre)
    {
        $this->attributes['nombre'] = ucwords($nombre);
    }

    /**
     * Devolver el valor de la constante isActive
     *
     * @author julian londoño
     * @return int
     */
    public static function IsActive()
    {
        return self::IS_ACTIVE;
    }

    /**
     * Devuelve el valor de la constante isInactive
     *
     * @author julian londoño
     * @return int
     */
    public static function IsInactive()
    {
        return self::IS_INACTIVE;
    }

    /*===========================================
    =            relaciones eloquent            =
    ===========================================*/

    public function nodo()
    {
        return $this->belongsTo(Nodo::class, 'nodo_id', 'id');
    }

    public function lineatecnologica()
    {
        return $this->belongsTo(LineaTecnologica::class, 'lineatecnologica_id', 'id');
    }

    /*=====  End of relaciones eloquent  ======*/

    /**
     * Devuelve el consulta con relaciones de la tabla laboratorios
     *
     * @author julian londoño
     * @return int
     */
    public static function scopeLaboratorioWithRelations($query, array $relations)
    {
        return $query->with($relations);
    }

    public function usoinfraestructuras()
    {
        return $this->belongsToMany(UsoInfraestructura::class, 'uso_laboratorios', 'usoinfraestructura_id', 'laboratorio_id')
            ->withTimestamps()
            ->withPivot('tiempo');
    }

}
