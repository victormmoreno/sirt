<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tecnoacademia extends Model
{
    protected $table = 'tecnoacademias';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'regional_id',
        'entidad_id',
        'centro_id',
    ];


    // Scope para las tecnoacademias
    public function scopeConsultarTecnoAcademias($query)
    {
        return $query->select('entidades.nombre', 'entidades.id AS id_entidad', 'centros.codigo_centro')
            ->selectRaw('concat(centros.codigo_centro, " - ", entidades_centro.nombre) AS codigo')
            ->join('entidades', 'entidades.id', '=', 'tecnoacademias.entidad_id')
            ->join('centros', 'centros.id', '=', 'tecnoacademias.centro_id')
            ->join('entidades AS entidades_centro', 'entidades_centro.id', '=', 'centros.entidad_id');
    }


    // Relaciones de la tabla de tecnoacademias
    public function regional()
    {
        return $this->belongsTo(Regional::class, 'regional_id', 'id');
    }

    public function entidad()
    {
        return $this->belongsTo(Entidad::class, 'entidad_id', 'id');
    }


    public function centro()
    {
        return $this->belongsTo(Centro::class, 'centro_id', 'id');
    }
}
