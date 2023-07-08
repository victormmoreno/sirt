<?php

namespace App\Http\Traits\User;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Notifications\ResetPasswordNotification;
use App\Presenters\UserPresenter;
use App\Models\{
    ActivationToken,
    Ciudad,
    Eps,
    Etnia,
    GradoEscolaridad,
    GrupoSanguineo,
    Ocupacion,
    Proyecto,
    Role,
    Movimiento,
    TipoDocumento,
    ControlNotificaciones
};
use App\User;

trait UsersTrait
{
    /**
     *  return genero.
     * @return int
     */
    public static function IsMasculino()
    {
        return User::IS_MASCULINO;
    }

    /**
     *  return genero.
     * @return int
     */
    public static function IsFemenino()
    {
        return User::IS_FEMENINO;
    }

    /**
     *  return genero.
     * @return int
     */
    public static function IsNoBinario()
    {
        return User:: IS_NO_BINARIO;
    }

    /**
     *  return state in system.
     * @return bool
     */
    public static function IsActive()
    {
        return User::IS_ACTIVE;
    }

    /**
     *  return state in system.
     * @return bool
     */
    public static function IsInactive()
    {
        return User::IS_INACTIVE;
    }

    /**
     * Define a one-to-many relationship between users and proyectos.
     * @return HasMany
     */
    public function asesoredts(): HasMany
    {
        return $this->hasMany(Edt::class, 'asesor_id', 'id');
    }

    /**
     * Define a one-to-many relationship between users and articulaciones.
     * @return HasMany
     */
    public function asesor_articulations(): HasMany
    {
        return $this->hasMany(\App\Models\ArticulationStage::class, 'created_by', 'id');
    }

    public function actividades_movimientos()
    {
        return $this->belongsToMany(Actividad::class, 'movimientos_actividades_users_roles')
            ->withTimestamps();
    }

    /**
     * Define an inverse one-to-one or many relationship between users and ciudad for ciudad_id.
     * @return BelongsTo
     */
    public function ciudad(): BelongsTo
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id', 'id');
    }

    /**
     * Define an inverse one-to-one or many relationship between users and ciudad for ciudad_expedicion_id.
     * @return BelongsTo
     */
    public function ciudadexpedicion(): BelongsTo
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_expedicion_id', 'id');
    }

    /**
     * Define an inverse one-to-one or many relationship between users and etnias.
     * @return BelongsTo
     */
    public function etnia(): BelongsTo
    {
        return $this->belongsTo(Etnia::class, 'etnia_id', 'id');
    }

    /**
     * Define an inverse one-to-one or many relationship between users and eps.
     * @return BelongsTo
     */
    public function eps(): BelongsTo
    {
        return $this->belongsTo(Eps::class, 'eps_id', 'id');
    }

    public function fases_movimientos()
    {
        return $this->belongsToMany(Fase::class, 'movimientos_actividades_users_roles')
            ->withTimestamps();
    }

    /**
     * Define an inverse one-to-one or many relationship between users and gradoEscolaridad.
     * @return BelongsTo
     */
    public function gradoEscolaridad(): BelongsTo
    {
        return $this->belongsTo(GradoEscolaridad::class, 'gradoescolaridad_id', 'id');
    }

    public function grupoSanguineo()
    {
        return $this->belongsTo(GrupoSanguineo::class, 'gruposanguineo_id', 'id');
    }

    /**
     * Define a many-to-many relationship between users and movimientos.
     * @return BelongsToMany
     */
    public function movimientos()
    {
        return $this->belongsToMany(Movimiento::class, 'movimientos_actividades_users_roles')
            ->withTimestamps();
    }

    /**
     * Define a one-to-many relationship between users and control_notificaciones for notificaciones_remitidas.
     * @return HasMany
     */
    public function notificaciones_remitidas(): HasMany
    {
        return $this->hasMany(ControlNotificaciones::class, 'remitente_id', 'id');
    }

    /**
     * Define a one-to-many relationship between users and control_notificaciones for notificaciones_recibidas.
     * @return HasMany
     */
    public function notificaciones_recibidas(): HasMany
    {
        return $this->hasMany(ControlNotificaciones::class, 'receptor_id', 'id');
    }

    public function ocupaciones()
    {
        return $this->belongsToMany(Ocupacion::class, 'ocupaciones_users')
            ->withTimestamps();
    }

    /**
     * Define a polymorphic many-to-many relationship between users and projects.
     * @return MorphToMany
     */
    public function proyectos(): MorphToMany
    {
        return $this->morphToMany(Proyecto::class, 'propietario')->withTimestamps();
    }

    /**
     * Define a many-to-many relationship between users and proyectos.
     * @return BelongsToMany
     */
    public function proyecto_talento() : BelongsToMany
    {
        return $this->belongsToMany(Proyecto::class, 'proyecto_talento')
            ->withTimestamps()
            ->withPivot('talento_lider');
    }

    /**
     * Define a many-to-many relationship between users and roles and movimientos.
     * @return BelongsToMany
     */
    public function roles_movimientos(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'movimientos_actividades_users_roles')
            ->withTimestamps();
    }

    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipodocumento_id', 'id');
    }

    public function usoinfraestructuras()
    {
            return $this->morphToMany(UsoInfraestructura::class, 'asesorable', 'gestor_uso', 'usoinfraestructura_id')->withTimestamps()
            ->withPivot([
                'asesoria_directa',
                'asesoria_indirecta',
                'costo_asesoria',
            ]);
    }

    public function usoinfraestructura_talento()
    {
        return $this->belongsToMany(UsoInfraestructura::class, 'uso_talentos')
            ->withTimestamps();
    }

    public function scopeStateDeletedAt($query, $state)
    {
        if (!empty($state) && $state != null && $state != 'all') {
            if ($state == 'si') {
                $state = User::IsActive();
                return $query->where('users.estado', $state);
            } else {
                $state = User::IsInactive();
                return $query->where('users.estado', $state)->onlyTrashed();
            }
        }
        return $query->withTrashed();
    }

    /**
     * Get quantity projects by user.
     *
     * @return int
     */
    public function getQuantityProjects()
    {
        return $this->proyecto_talento->count();
    }

    /**
     * Get quantity articulations by user.
     *
     * @return int
     */
    public function getQuantityArticulations()
    {
        return $this->asesor_articulations->count();
    }


    public function token()
    {
        return $this->hasOne(ActivationToken::class);
    }

    public function getRouteKeyName()
    {
        return 'documento';
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

    public function present()
    {
        return new UserPresenter($this);
    }
}
