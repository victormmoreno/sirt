<?php

namespace App\Http\Traits\AsesorieTrait;

use App\User;

trait HasUser
{
    public function participantes()
    {
        return $this->belongsToMany(User::class, 'uso_talentos', 'usoinfraestructura_id', 'user_id')
            ->withTimestamps();
    }

    public function asesores()
    {
        return $this->belongsToMany(User::class, 'gestor_uso', 'usoinfraestructura_id', 'asesor_id')->withTimestamps()
        ->withPivot([
            'asesoria_directa',
            'asesoria_indirecta',
            'costo_asesoria',
        ])->withTrashed();
    }

    /**
     * Elimina los datos de gestor_uso
     *
     * @param Collection $data
     * @return void
     */
    public static function deleteAsesores($data)
    {
        foreach ($data->usoinfraestructuras as $key => $value) {
            $value->asesores()->sync([]);
        }
    }

    public static function deleteParticipantes($data)
    {
        foreach ($data->usoinfraestructuras as $key => $value) {
            $value->participantes()->sync([]);
        }
    }
}
