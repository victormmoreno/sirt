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
