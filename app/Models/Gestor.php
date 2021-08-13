<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Gestor extends Model
{
    /**
     * the table name
     * @var string
     * @author devjul
     */
    protected $table = 'gestores';

    /**
     * The attributes that are mass assignable.
     * @var array
     * @author devjul
     */
    protected $fillable = [
        'user_id',
        'nodo_id',
        'lineatecnologica_id',
        'honorarios',
    ];

    /**
     * The attributes that should be cast to native types.
     * @var array
     * @author devjul
     */
    protected $casts = [
        'honorarios' => 'float',
    ];

    /**
     * Define an inverse one-to-one or many relationship between gestores and users.
     * @author devjul
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Define a one-to-many relationship between gestores and proyectos.
     * @author devjul
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proyectos()
    {
        return $this->hasMany(Proyecto::class, 'asesor_id', 'id');
    }

    /**
     * Define a one-to-many relationship between gestores and ideas.
     * @author devjul
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ideas()
    {
        return $this->hasMany(Idea::class, 'gestor_id', 'id');
    }

    /**
     * Define an inverse one-to-one or many relationship between gestores and nodes.
     * @author devjul
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nodo()
    {
        return $this->belongsTo(Nodo::class, 'nodo_id', 'id');
    }

    /**
     * Define an inverse one-to-one or many relationship between gestores and linia tecnologica.
     * @author devjul
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lineatecnologica()
    {
        return $this->belongsTo(LineaTecnologica::class, 'lineatecnologica_id', 'id');
    }

    /**
     * Define a one-to-many relationship between gestores and actividades.
     * @author devjul
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actividades()
    {
        return $this->hasMany(Actividad::class, 'gestor_id', 'id');
    }

    /**
     * Define a many-to-many relationship gestores and comites.
     * @author dum
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function comites()
    {
        return $this->belongsToMany(Comite::class, 'comite_gestor')
            ->withTimestamps()
            ->withPivot(['hora_inicio', 'hora_fin']);
    }

    public function getHonorariosAttribute($honorarios)
    {
        return trim($honorarios);
    }

    /**
     * Define a many-to-many relationship gestores and usos de infraestructura.
     * @author devjul
     * @return void
     */
    public function setHonorariosAttribute($honorarios)
    {
        $this->attributes['honorarios'] = trim($honorarios);
    }

    /**
     * Devolver cantidad de gestores
     * @author julian londoño
     * @return int
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
    //eliminar despues de la migracion
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
}
