<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{

    protected $table = 'actividades';

    protected $casts = [
        'fecha_inicio' => 'date:Y-m-d',
        'fecha_cierre' => 'date:Y-m-d',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'gestor_id',
        'nodo_id',
        'codigo_actividad',
        'nombre',
        'fecha_inicio',
        'fecha_cierre',
    ];

    public function articulacion_proyecto()
    {
        return $this->hasOne(ArticulacionProyecto::class, 'actividad_id', 'id');
    }

    public function edt()
    {
        return $this->hasOne(Edt::class, 'actividad_id', 'id');
    }

    public function gestor()
    {
        return $this->belongsTo(Gestor::class, 'gestor_id', 'id');
    }

    /**
     * Devolver relacion entre actividades y nodo
     * @author julian londoño
     */
    public function nodo()
    {
        return $this->belongsTo(Nodo::class, 'nodo_id', 'id');
    }

}
