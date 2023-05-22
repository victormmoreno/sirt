<?php

namespace App\Http\Traits\User;

use App\Notifications\ResetPasswordNotification;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\User;


trait UsersTrait
{
    public function getRouteKeyName()
    {
        return 'documento';
    }

    public static function IsMasculino()
    {
        return User::IS_MASCULINO;
    }
    public static function IsFemenino()
    {
        return User::IS_FEMENINO;
    }

    public static function IsNoBinario()
    {
        return User:: IS_NO_BINARIO;
    }

    public static function IsActive()
    {
        return User::IS_ACTIVE;
    }
    public static function IsInactive()
    {
        return User::IS_INACTIVE;
    }


    public function isAuthUser(): bool
    {
        return (bool) $this->documento == \Auth::user()->documento;
    }


    public static function generatePasswordRamdom()
    {
        return str_random(12);
    }

    public function generateToken()
    {
        $this->token()->create([
            'token' => str_random(60),
        ]);
        return $this;
    }

    public function isUpdated()
    {
        return !is_null($this->updated_at) && $this->updated_at < today();
    }

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

    public function activate()
    {
        $this->update(['estado' => true]);

        Auth::login($this);

        $this->token->delete();
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function getOcupacionesNames(): Collection
    {
        return $this->ocupaciones->pluck('nombre');
    }
}
