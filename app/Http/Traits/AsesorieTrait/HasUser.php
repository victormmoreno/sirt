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

    public function scopeGetAsesoresProyecto($query) {
        return $query->selectRaw("concat(ua.nombres, ' ', ua.apellidos) AS asesor, sum(gestor_uso.asesoria_directa) as asesoria_directa, 
        sum(gestor_uso.asesoria_indirecta) as asesoria_indirecta, sum(costo_asesoria) AS costo_asesoria, 
        sum(asesoria_directa)+sum(asesoria_indirecta) AS total_horas_asesoria")
        ->leftJoin('gestor_uso', 'gestor_uso.usoinfraestructura_id', '=', 'usoinfraestructuras.id')
        ->join('users AS ua', 'ua.id', '=', 'gestor_uso.asesor_id')
        ->groupBy('ua.id');
    }

    public function scopeGetHorasAsesoria($query, $uso) {
        return $query->selectRaw("sum(gestor_uso.asesoria_directa) as asesoria_directa, sum(gestor_uso.asesoria_indirecta) as asesoria_indirecta, 
        sum(costo_asesoria) AS costo_asesoria, sum(asesoria_directa)+sum(asesoria_indirecta) AS total_horas_asesoria")
        ->leftJoin('gestor_uso', 'gestor_uso.usoinfraestructura_id', '=', 'usoinfraestructuras.id')
        ->groupBy('usoinfraestructuras.id')
        ->where('usoinfraestructuras.id', $uso);
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
