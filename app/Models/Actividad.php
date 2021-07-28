<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Presenters\ActividadPresenter;

class Actividad extends Model
{

    protected $table = 'actividades';

    /**
     * The attributes that should be cast to native types.
     * @var array
     */
    protected $casts = [
        'codigo_actividad' => 'string',
        'nombre'           => 'string',
        'fecha_inicio'     => 'date:Y-m-d',
        'fecha_cierre'     => 'date:Y-m-d',
    ];

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        // 'gestor_id',
        // 'nodo_id',
        'codigo_actividad',
        'nombre',
        'fecha_inicio',
        'fecha_cierre',
        'objetivo_general',
        'conclusiones',
        'aprobacion_dinamizador',
        'formulario_inicio',
        'cronograma',
        'seguimiento',
        'evidencia_final',
        'formulario_final'
    ];

    /**
     * Consulta el historico de una actividad
     * @param int $id Id de la activdad
     * @return Builder
     * @author dum
     */
    public static function consultarHistoricoActividad($id) {
        return DB::table('movimientos_actividades_users_roles')->select('movimiento', 'fases.nombre AS fase', 'roles.name AS rol', 'comentarios', 'movimientos_actividades_users_roles.created_at')
        ->selectRaw('concat(nombres, " ", apellidos) AS usuario')
        ->where('actividad_id', $id)
        ->join('movimientos', 'movimientos.id', 'movimientos_actividades_users_roles.movimiento_id')
        ->join('fases', 'fases.id', '=', 'movimientos_actividades_users_roles.fase_id')
        ->join('users', 'users.id', '=', 'movimientos_actividades_users_roles.user_id')
        ->join('roles', 'roles.id', '=', 'movimientos_actividades_users_roles.role_id')
        ->orderBy('movimientos_actividades_users_roles.created_at');
    }

    /**
    * Consulta las actividades
    * @param Collection $query Propia de los scopes de laravel
    * @return Builder
    */
    public function scopeConsultarActividades($query)
    {
        return $query->select('id')
        ->selectRaw('CONCAT(codigo_actividad, " / ", nombre) AS proyecto');
    }

    public function articulacion_proyecto()
    {
        return $this->hasOne(ArticulacionProyecto::class, 'actividad_id', 'id');
    }

    public function movimientos()
    {
        return $this->belongsToMany(Movimiento::class, 'movimientos_actividades_users_roles')
        ->withTimestamps();
    }

    public function users_movimientos()
    {
        return $this->belongsToMany(User::class, 'movimientos_actividades_users_roles')
        ->withTimestamps();
    }

    public function roles_movimientos()
    {
        return $this->belongsToMany(Role::class, 'movimientos_actividades_users_roles')
        ->withTimestamps();
    }

    public function fases_movimientos()
    {
        return $this->belongsToMany(Fase::class, 'movimientos_actividades_users_roles')
        ->withTimestamps();
    }

    public function edt()
    {
        return $this->hasOne(Edt::class, 'actividad_id', 'id');
    }

    // public function gestor()
    // {
    //     return $this->belongsTo(Gestor::class, 'gestor_id', 'id');
    // }

    // public function articulacionpbt()
    // {
    //     return $this->hasOne(ArticulacionPbt::class, 'actividad_id', 'id');
    // }

    // public function nodo()
    // {
    //     return $this->belongsTo(Nodo::class, 'nodo_id', 'id');
    // }

    public function usoinfraestructuras()
    {
        return $this->hasMany(UsoInfraestructura::class, 'actividad_id', 'id');
    }

    public function objetivos_especificos()
    {
        return $this->hasMany(ObjetivoEspecifico::class, 'actividad_id', 'id');
    }

    public function present()
    {
        return new ActividadPresenter($this);
    }
}
