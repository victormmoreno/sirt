<?php

namespace App\Http\Traits\UserTrait;

use App\Notifications\ResetPasswordNotification;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

trait UsersTrait
{

    public function getRouteKeyName()
    {
        return 'documento'; // db column name
    }

    public static function IsMasculino()
    {
        return self::IS_MASCULINO;
    }
    public static function IsFemenino()
    {
        return self::IS_FEMENINO;
    }

    public static function IsNoBinario()
    {
        return self:: IS_NO_BINARIO;
    }

    public static function IsActive()
    {
        return self::IS_ACTIVE;
    }
    public static function IsInactive()
    {
        return self::IS_INACTIVE;
    }

    public static function IsDesarrollador()
    {
        return self::IS_DESARROLLADOR;
    }

    public static function IsActivador()
    {
        return self::IS_ACTIVADOR;
    }

    public static function IsAdministrador()
    {
        return self::IS_ADMINISTRADOR;
    }

    public static function IsDinamizador()
    {
        return self::IS_DINAMIZADOR;
    }

    public static function IsGestor()
    {
        return self::IS_GESTOR;
    }

    public static function IsInfocenter()
    {
        return self::IS_INFOCENTER;
    }

    public static function IsTalento()
    {
        return self::IS_TALENTO;
    }

    public static function IsIngreso()
    {
        return self::IS_INGRESO;
    }

    public static function IsArticulador()
    {
        return self::IS_ARTICULADOR;
    }

    public static function IsApoyoTecnico()
    {
        return self::IS_APOYO_TECNICO;
    }

    public static function IsProveedor()
    {
        return self::IS_PROVEEDOR;
    }

    /*==========================================
    =            mutadores eloquent            =
    ==========================================*/

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
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

    public function setDocumentoAttribute($documento)
    {
        $this->attributes['documento'] = trim($documento);
    }

    public function getDocumentoAttribute($documento)
    {
        return trim($documento);
    }

    /*=====  End of mutadores eloquent  ======*/

    /*================================================================
    =            metodo para generar contraseña aleatoria            =
    ================================================================*/
    public static function generatePasswordRamdom()
    {
        return str_random(12);
    }

    /*=====  End of metodo para generar contraseña aleatoria  ======*/

    /*==================================================================
    =            metodo para generar token activacion users            =
    ==================================================================*/

    public function generateToken()
    {
        $this->token()->create([
            'token' => str_random(60),
        ]);

        return $this;

    }

    /*=====  End of metodo para generar token activacion users  ======*/
    /*=================================================================
    =            ejemplo para preguntar por fechas futuras            =
    =================================================================*/

    public function isUpdated()
    {
        return !is_null($this->updated_at) && $this->updated_at < today();
    }

    /*=====  End of ejemplo para preguntar por fechas futuras  ======*/

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /*=================================================================
    =            metodo para activar la cuenta del usuario            =
    =================================================================*/

    public function activate()
    {
        $this->update(['estado' => true]);

        Auth::login($this);

        $this->token->delete();
    }

    /*=====  End of metodo para activar la cuenta del usuario  ======*/

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /*===============================================================================
    =            metodo para retornar el nombre de todas las ocupaciones            =
    ===============================================================================*/

    public function getOcupacionesNames(): Collection
    {
        return $this->ocupaciones->pluck('nombre');
    }

    /*=====  End of metodo para retornar el nombre de todas las ocupaciones  ======*/

}
