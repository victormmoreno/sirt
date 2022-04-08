<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetaNodo extends Model
{
    protected $table = 'metas_nodo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nodo_id',
        'anho',
        'articulaciones',
        'trl6',
        'trl7_trl8'
    ];

    public function nodo()
    {
        return $this->belongsTo(Nodo::class, 'nodo_id', 'id');
    }

    public function scopeProyectosFinalizadosTrl6($query, $year)
    {
        return $query->whereHas('nodo.proyectos.fase', function($query) {
            $query->where('nombre', Proyecto::IsFinalizado());
        })->whereHas('nodo.proyectos.articulacion_proyecto.actividad', function($query) use ($year) {
            $query->whereYear('fecha_cierre', $year);
        })->whereHas('nodo.proyectos', function($query) {
            $query->where('trl_obtenido', Proyecto::IsTrl6Obtenido());
        });
    }

}
