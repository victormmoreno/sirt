<?php

namespace App\Http\Traits\User;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

trait HasAcessorsMutators
{
    public function setDocumentoAttribute($documento)
    {
        $this->attributes['documento'] = trim($documento);
    }

    public function setNombresAttribute($nombres)
    {
        $this->attributes['nombres'] = ucwords(mb_strtolower(trim($nombres), 'UTF-8'));
    }

    public function setApellidosAttribute($apellidos)
    {
        $this->attributes['apellidos'] = ucwords(mb_strtolower(trim($apellidos), 'UTF-8'));
    }

    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = mb_strtolower(trim($email), 'UTF-8');
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function setBarrioAttribute($barrio)
    {
        $this->attributes['barrio'] = ucwords(mb_strtolower(trim($barrio), 'UTF-8'));
    }

    public function setDireccionAttribute($direccion)
    {
        $this->attributes['direccion'] = ucwords(mb_strtolower(trim($direccion), 'UTF-8'));
    }

    public function setCelularAttribute($celular)
    {
        $this->attributes['celular'] = trim($celular);
    }

    public function setTelefonoAttribute($telefono)
    {
        $this->attributes['telefono'] = trim($telefono);
    }

    public function setFechaNacimientoAttribute($fechanacimiento)
    {
        $this->attributes['fechanacimiento'] = Carbon::parse($fechanacimiento)->format('Y-m-d');
    }

    public function setOtraEpsAttribute($otra_eps)
    {
        $this->attributes['otra_eps'] = ucwords(mb_strtolower(trim($otra_eps), 'UTF-8'));
    }

    public function setInstitucionAttribute($institucion)
    {
        $this->attributes['institucion'] = ucwords(mb_strtolower(trim($institucion), 'UTF-8'));
    }

    public function setTituloObtenidoAttribute($titulo_obtenido)
    {
        $this->attributes['titulo_obtenido'] = ucwords(mb_strtolower(trim($titulo_obtenido), 'UTF-8'));
    }

    public function setFechaTerminacionAttribute($fecha_terminacion)
    {
        $this->attributes['fecha_terminacion'] = Carbon::parse($fecha_terminacion)->format('Y-m-d');
    }

    public function setOtraOcupacionAttribute($otra_ocupacion)
    {
        $this->attributes['otra_ocupacion'] = ucwords(mb_strtolower(trim($otra_ocupacion), 'UTF-8'));
    }

    public function getNombreCompletoAttribute()
    {
        return ucwords(mb_strtolower($this->nombres), 'UTF-8') . ' ' . ucwords(mb_strtolower($this->apellidos), 'UTF-8');
    }

    public function getDocumentoAttribute($documento)
    {
        return trim($documento);
    }
}
