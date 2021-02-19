<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Gestor extends Model
{
    protected $table = 'gestores';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'nodo_id',
        'lineatecnologica_id',
        'honorarios',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'honorarios' => 'float',
    ];

    public function scopeConsultarGestoresPorNodo($query, $id)
    {
        return $query->select('gestores.id')
            ->selectRaw('CONCAT(users.documento, " - ", users.nombres, " ", users.apellidos) AS nombres_gestor')
            ->selectRaw('CONCAT(users.nombres, " ", users.apellidos) AS nombres')
            ->join('users', 'users.id', '=', 'gestores.user_id')
            ->join('nodos', 'nodos.id', '=', 'gestores.nodo_id')
            ->where('nodos.id', $id)
            ->where('users.deleted_at', null)
            ->orderBy('users.nombres');
    }

    public function comites()
    {
        return $this->belongsToMany(Comite::class, 'comite_gestor')
            ->withTimestamps()
            ->withPivot(['hora_inicio', 'hora_fin']);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withTrashed();
    }

    public function ideas()
    {
        return $this->hasMany(Idea::class, 'gestor_id', 'id');
    }

    public function nodo()
    {
        return $this->belongsTo(Nodo::class, 'nodo_id', 'id');
    }

    // Relación con la tabla de líneas tecnológicas
    public function lineatecnologica()
    {
        return $this->belongsTo(LineaTecnologica::class, 'lineatecnologica_id', 'id');
    }


    public function actividades()
    {
        return $this->hasMany(Actividad::class, 'gestor_id', 'id');
    }


    public function usoinfraestructuras()
    {
        return $this->belongsToMany(UsoInfraestructura::class, 'gestor_uso', 'usoinfraestructura_id', 'gestor_id')
            ->withTimestamps()
            ->withPivot([
                'asesoria_directa',
                'asesoria_indirecta',
                'costo_asesoria',
            ]);
    }

    /*=========================================
    =            asesores eloquent            =
    =========================================*/
    public function getHonorariosAttribute($honorarios)
    {
        return trim($honorarios);
    }

    /*=====  End of asesores eloquent  ======*/

    /*========================================
    =            mutador eloquent            =
    ========================================*/
    public function setHonorariosAttribute($honorarios)
    {
        $this->attributes['honorarios'] = trim($honorarios);
    }

    /*=====  End of mutador eloquent  ======*/

    /**
     * Devolver cantidad de gestores
     * @author julian londoño
     */
    public function scopeCountGestores($query)
    {
        return $query->with('user')->count();
    }

    public function scopeGestoresNodo($query, array $relations)
    {
        if (isset($relations)) {
            return $query->with($relations);
        }
        return $query;
    }
}
