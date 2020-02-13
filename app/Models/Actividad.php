<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{

    protected $table = 'actividades';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'gestor_id'        => 'integer',
        'nodo_id'          => 'integer',
        'codigo_actividad' => 'string',
        'nombre'           => 'string',
        'fecha_inicio'     => 'date:Y-m-d',
        'fecha_cierre'     => 'date:Y-m-d',

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
        'objetivo_general',
        'conclusiones',
        'aprobacion_dinamizador',
        'formulario_inicio',
        'cronograma',
        'seguimiento',
        'evidencia_final',
        'formulario_final'

    ];

    /**
    * Consulta las actividades
    * @param Collection $query Propia de los scopes de laravel
    * @return Builder
    */
    public function scopeConsultarActividades($query)
    {
      return $query->select('id')
      ->selectRaw('CONCAT(codigo_actividad, " / ", nombre) AS proyecto');
    }

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

    public function usoinfraestructuras()
    {
        return $this->hasMany(UsoInfraestructura::class, 'actividad_id', 'id');
    }

    public function objetivos_especificos()
    {
      return $this->hasMany(ObjetivoEspecifico::class, 'actividad_id', 'id');
    }

}
