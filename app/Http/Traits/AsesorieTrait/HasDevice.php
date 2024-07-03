<?php

namespace App\Http\Traits\AsesorieTrait;

use App\Models\Equipo;

trait HasDevice
{
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

    public function scopeGetUsoEquipos($query, $uso) {
        return $query->selectRaw("sum(equipo_uso.tiempo) as uso_equipos, sum(equipo_uso.costo_equipo) as costo_uso_equipos, 
        sum(costo_administrativo) AS costo_administrativo")
        ->leftJoin('equipo_uso', 'equipo_uso.usoinfraestructura_id', '=', 'usoinfraestructuras.id')
        ->where('usoinfraestructuras.id', $uso);
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
}
