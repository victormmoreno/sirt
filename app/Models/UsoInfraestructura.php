<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsoInfraestructura extends Model
{
    protected $table = 'usoinfraestructuras';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'actividad_id',
        'fecha',
        'asesoria_directa',
        'asesoria_indirecta',
        'descripcion',
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
        'actividad_id'       => 'integer',
        'fecha'              => 'date:Y-m-d',
        'asesoria_directa'   => 'string',
        'asesoria_indirecta' => 'string',
        'descripcion'        => 'string',
        'estado'             => 'boolean',
    ];

    public function actividad()
    {
        return $this->belongsTo(Actividad::class, 'actividad_id', 'id');
    }

    public function usolaboratorios()
    {
        return $this->belongsToMany(Laboratorio::class, 'uso_laboratorios', 'usoinfraestructura_id','laboratorio_id')
        ->withTimestamps()
        ->withPivot('tiempo');
    }

    public function usotalentos()
    {
        return $this->belongsToMany(Talento::class, 'uso_talentos', 'usoinfraestructura_id','talento_id')
            ->withTimestamps();
    }

}
