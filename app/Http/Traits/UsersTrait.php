<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Auth;

trait UsersTrait {
    
	
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

    public static function IsActive()
    {
        return self::IS_ACTIVE;
    }
    public static function IsInactive()
    {
        return self::IS_INACTIVE;
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
        $this->attributes['nombres'] = strtolower($nombres);
        $this->attributes['nombres'] = ucfirst($nombres);
    }


    public function setApellidosAttribute($apellidos)
    {
        $this->attributes['apellidos'] = strtolower($apellidos);
        $this->attributes['apellidos'] = ucfirst($apellidos);
    }

    public function getNombreCompletoAttribute()
    {
        return ucfirst(strtolower($this->nombres)) . ' ' . ucfirst(strtolower($this->apellidos));
    }

    
    /*=====  End of mutadores eloquent  ======*/
    


    /*================================================================
    =            metodo para generar contraseña aleatoria            =
    ================================================================*/
    public static function generatePasswordRamdom()
    {
        return str_random(9);
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
    

    

}