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
        $this->attributes['nombres'] = ucwords(mb_strtolower(trim($nombres)));
    }

    public function setApellidosAttribute($apellidos)
    {
        $this->attributes['apellidos'] = ucwords(mb_strtolower(trim($apellidos)));
    }

    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = mb_strtolower(trim($email));
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function setBarrioAttribute($barrio)
    {
        $this->attributes['barrio'] = ucwords(mb_strtolower(trim($barrio)));
    }

    public function setDireccionAttribute($direccion)
    {
        $this->attributes['direccion'] = ucwords(mb_strtolower(trim($direccion)));
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
        $this->attributes['otra_eps'] = ucwords(mb_strtolower(trim($otra_eps)));
    }

    public function setInstitucionAttribute($institucion)
    {
        $this->attributes['institucion'] = ucwords(mb_strtolower(trim($institucion)));
    }

    public function setTituloObtenidoAttribute($titulo_obtenido)
    {
        $this->attributes['titulo_obtenido'] = ucwords(mb_strtolower(trim($titulo_obtenido)));
    }

    public function setFechaTerminacionAttribute($fecha_terminacion)
    {
        $this->attributes['fecha_terminacion'] = Carbon::parse($fecha_terminacion)->format('Y-m-d');
    }

    public function setOtraOcupacionAttribute($otra_ocupacion)
    {
        $this->attributes['otra_ocupacion'] = ucwords(mb_strtolower(trim($otra_ocupacion)));
    }

    public function getNombreCompletoAttribute()
    {
        return ucwords(mb_strtolower($this->nombres)) . ' ' . ucwords(mb_strtolower($this->apellidos));
    }

    public function getDocumentoAttribute($documento)
    {
        return trim($documento);
    }
}
