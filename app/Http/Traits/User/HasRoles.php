<?php

namespace App\Http\Traits\User;

use Spatie\Permission\Traits\HasRoles as HasRolesPackage;
use App\Models\UserNodo;
use App\User;

trait HasRoles
{
    use HasRolesPackage;

    public function dinamizador()
    {
        return $this->hasOne(UserNodo::class, 'user_id', 'id')->where('role', User::IsDinamizador());
    }

    public function experto()
    {
        return $this->hasOne(UserNodo::class, 'user_id', 'id')->where('role', self::IsExperto());
    }

    public function articulador()
    {
        return $this->hasOne(UserNodo::class, 'user_id', 'id')->where('role', User::IsArticulador());
    }

    public function infocenter()
    {
        return $this->hasOne(UserNodo::class, 'user_id', 'id')->where('role', User::IsInfocenter());
    }

    public function apoyotecnico()
    {
        return $this->hasOne(UserNodo::class, 'user_id', 'id')->where('role', User::IsApoyoTecnico());
    }

    public function ingreso()
    {
        return $this->hasOne(UserNodo::class, 'user_id', 'id')->where('role', User::IsIngreso());
    }

    public function activador()
    {
        return $this->hasOne(UserNodo::class, 'user_id', 'id')->where('role', User::IsActivador());
    }

    public static function IsAdministrador()
    {
        return User::IS_ADMINISTRADOR;
    }

    public static function IsActivador()
    {
        return User::IS_ACTIVADOR;
    }

    public static function IsDesarrollador()
    {
        return User::IS_DESARROLLADOR;
    }

    public static function IsDinamizador()
    {
        return User::IS_DINAMIZADOR;
    }

    public static function IsExperto()
    {
        return User::IS_EXPERTO;
    }

    public static function IsArticulador()
    {
        return User::IS_ARTICULADOR;
    }

    public static function IsInfocenter()
    {
        return User::IS_INFOCENTER;
    }

    public static function IsApoyoTecnico()
    {
        return User::IS_APOYO_TECNICO;
    }

    public static function IsTalento()
    {
        return User::IS_TALENTO;
    }

    public static function IsIngreso()
    {
        return User::IS_INGRESO;
    }

    public static function IsUsuario()
    {
        return User::IS_USUARIO;
    }

    public function isUserAdministrador(): bool
    {
        return (bool) $this->hasRole(self::IsAdministrador());
    }

    public function isUserActivador(): bool
    {
        return (bool) $this->hasRole(self::IsActivador());
    }

    public function isUserDinamizador(): bool
    {
        return (bool) $this->hasRole(self::IsDinamizador()) && $this->dinamizador() != null;
    }

    public function isUserExperto(): bool
    {
        return (bool) $this->hasRole(self::IsExperto()) && $this->experto() != null;
    }

    public function isUserArticulador(): bool
    {
        return (bool) $this->hasRole(self::IsArticulador()) && $this->articulador() != null;
    }

    public function isUserApoyoTecnico(): bool
    {
        return (bool) $this->hasRole(self::IsApoyoTecnico()) && $this->apoyotecnico() != null;
    }

    public function isUserIngreso(): bool
    {
        return (bool) $this->hasRole(self::IsIngreso()) && $this->ingreso() != null;
    }
    public function isUserInfocenter(): bool
    {
        return (bool) $this->hasRole(self::IsInfocenter()) && $this->infocenter() != null;
    }

    public function isUserTalento(): bool
    {
        return (bool) $this->hasRole(self::IsTalento());
    }

    public function isUserFuncionario(): bool
    {
        return (bool) $this->hasAnyRole([
            self::IsActivador(), self::IsDinamizador(), self::IsExperto(),
            self::IsArticulador(), self::IsApoyoTecnico(), self::IsInfocenter(),
            self::IsIngreso()
        ]);
    }

    public function isUserConvencional(): bool
    {
        return (bool) $this->hasRole(self::IsUsuario());
    }

    public function scopeRole($query, $role)
    {
        if (!empty($role) && $role != null && $role != 'all') {
            return $query->where('roles.name', $role);
        }
        return $query;
    }

    public function scopeRoleFuncionario($query, $role)
    {
        if(!empty($role) && $role != null && $role != 'all' && is_array($role)){
            return $query->whereIn('roles.name', $role)->whereIn('user_nodo.role', $role);
        }
        else if (!empty($role) && $role != null && $role != 'all') {
            return $query->where('roles.name', $role)->where('user_nodo.role', $role);
        }
        return $query;
    }

    public function scopeInfoUserRole($query, array $role = [], array $relations = [])
    {
        return $query->with($relations)
            ->role($role);
    }

    public function scopeRoleQuery($query, $roles)
    {
        if (isset($roles) && (!collect($roles)->contains('all'))) {
            return $query->roleIn($roles);
        }
        return $query;
    }

    public function scopeRoleIn($query, $role)
    {
        if (!empty($role) && $role != null && $role != 'all') {
            return $query->whereHas('roles', function ($subQuery) use ($role) {
                $subQuery->whereIn('name', $role);
            });
        }
        return $query;
    }

    public function changeOneRoleToAnother(string $role)
    {
        if(isset($role) && !is_null($this) && $this->IsUsuario())
        {
            $this->syncRoles($role);
        }
    }
}
