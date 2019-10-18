<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CostoAdministrativo extends Model
{

    const MAX_HORA_ANIO = 1600;
    const DIAS_AL_ANIO = 243;
    const DIAS_AL_MES = 26;
    const HORAS_AL_DIA = 8;
    const DEDICACION = 2;  //decicacion de a tareas administrativas y dedicacion a proyectos
    
    protected $table = 'costos_administrativos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'nombre' => 'string',
    ];

    public function setNombreAttribute($nombre)
    {
        $this->attributes['nombre'] = ucwords(mb_strtolower(trim($nombre), 'UTF-8'));
    }

    public function getNombreAttribute($nombre)
    {
        return ucwords(mb_strtolower(trim($nombre), 'UTF-8'));
    }

    public function nodocostosadministrativos()
    {
        return $this->belongsToMany(Nodo::class, 'nodo_costoadministrativo', 'nodo_id', 'costo_administrativo_id')
            ->withTimestamps()
            ->withPivot([
                'anho',
                'valor',
            ]);
    }

}
