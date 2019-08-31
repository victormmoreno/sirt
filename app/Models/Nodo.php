<?php

namespace App\Models;

use App\Exceptions\Nodo\NodoDoesNotExist;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Nodo extends Model
{
    protected $table = 'nodos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'centro_id',
        'entidad_id',
        'direccion',
        'anho_inicio',
    ];

    /*===========================================
    =            relaciones eloquent            =
    ===========================================*/
    public function centro()
    {
        return $this->belongsTo(Centro::class, 'centro_id', 'id');
    }

    public function entidad()
    {
        return $this->belongsTo(Entidad::class, 'entidad_id', 'id');
    }

    public function infocenter()
    {
        return $this->hasMany(Infocenter::class, 'nodo_id', 'id');
    }

    public function dinamizadores()
    {
        return $this->hasMany(Dinamizador::class, 'nodo_id', 'id');
    }

    public function gestores()
    {
        return $this->hasMany(Gestor::class, 'nodo_id', 'id');
    }

    public function ideas()
    {
        return $this->hasMany(Idea::class, 'nodo_id', 'id');
    }

    public function ingresos()
    {
        return $this->hasMany(Ingreso::class, 'nodo_id', 'id');
    }

    public function laboratorios()
    {
        return $this->hasMany(Laboratorio::class, 'nodo_id', 'id');
    }

    /**
     * Devolver relacion entre actividades y nodo
     * @author julian londoño
     */
    public function actividades()
    {
      return $this->hasMany(Actividad::class, 'nodo_id', 'id');
    }

    //relacion muchos a muchos con lineas

    public function lineas()
    {
        return $this->belongsToMany(LineaTecnologica::class, 'lineastecnologicas_nodos')
            ->withTimestamps();

    }

    // Consulta los nodos de tecnoparque
    public function scopeNodoDeTecnoparque($query)
    {
        return $query->select('entidades.id AS id_entidad', 'entidades.nombre AS nombre_nodo', 'nodos.id', 'nodos.direccion', 'centros.codigo_centro')
            ->selectRaw('concat(centros.codigo_centro, " - ", e.nombre) AS centro')
            ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
            ->join('centros', 'centros.id', '=', 'nodos.centro_id')
            ->join('entidades AS e', 'e.id', '=', 'centros.entidad_id');
    }

    /*=====  End of relaciones eloquent  ======*/

    /*==============================================================
    =            scope para consultar la lista de nodos            =
    ==============================================================*/

    public function scopeSelectNodo($query)
    {
        return $query->select('nodos.id', DB::raw("CONCAT('Tecnoparque Nodo ',entidades.nombre) as nodos"))
            ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id');

    }

    /*=====  End of scope para consultar la lista de nodos  ======*/

    /*====================================================================================================
    =            scope para consultar el nodo del dinamizador - gestor - infocenter - ingreso            =
    ====================================================================================================*/

    public function scopeListNodos($query)
    {
        return $query->select(DB::raw('concat("Tecnoparque nodo ", nombre) AS nombre'), 'id')
            ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id');
    }

    public function scopeUserNodo($query, $nodo_id)
    {

        return $query->select('entidades.nombre')
            ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
            ->where('nodos.id', '=', $nodo_id);

    }

    /*=====  End of scope para consultar el nodo del dinamizador - gestor - infocenter - ingreso  ======*/

    /*==============================================================================
    =            scope para consultar todas las lineas por departamento            =
    ==============================================================================*/

    public function scopeAllLineasPorNodo($query, $nodo)
    {
        return $query->with('lineas')->find($nodo);
    }

    /*=====  End of scope para consultar todas las lineas por departamento  ======*/

    /*===========================================================================
    =            scope para retornar el nodo del usuario autenticada            =
    ===========================================================================*/

    public function scopeNodoUserAthenticated($query, $nodo)
    {
        return $query->select('nodos.id', DB::raw('concat("Tecnoparque nodo ", entidades.nombre) AS nombre'))
            ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
            ->where('nodos.id', '=', $nodo);

    }

    /*=====  End of scope para retornar el nodo del usuario autenticada  ======*/

    /**
     * buscar un nodo por el nombre.
     *
     * @param string $name
     * @param int $id
     *
     */
    public static function findByName(string $name, int $id)
    {

        $nodo = static::with([
            'entidad' => function ($query) use ($name) {
                $query->where('nombre', $name);
            },
        ])->where('id', $id)->get();

        if (!$nodo) {
            throw NodoDoesNotExist::named($name);
        }
        return $nodo;
    }

    public function getLaboratorioIds(): Collection
    {
        // return $this->laboratorios->modelKeys();
        return $this->laboratorios->pluck('id');
    }

    public function getLaboratorioNames(): Collection
    {
        return $this->laboratorios->pluck('nombres');
    }

    /**
     * buscar lineas por nodo y devolver id y nombre
     *
     * @param int $nodo
     * @return collection
     * @author julian londoño
     */

    public function scopeGetLineasForNodoIdsNames($query, $nodo): Collection
    {
        
        return $query->find($nodo)->lineas->pluck('nombre', 'id');
    }

    /**
     * consultar primer nodo en la base de datos.
     *
     * 
     * @return array
     * @author julian londoño
     */
    public function scopeNodoFirst($query)
    {
        
        return $query->first();
    }
}
