<?php

namespace App\Models;

use App\Exceptions\Nodo\NodoDoesNotExist;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\User;

class Nodo extends Model
{
    /**
     * Constant for the expected nodo prueba
     * @var string
     * @author dum
     */
    const NODO_PRUEBA = 'Prueba';
    /**
     * the table name
     * @var string
     * @author devjul
     */
    protected $table = 'nodos';

    /**
     * The attributes that are mass assignable.
     * @var array
     * @author devjul
     */
    protected $fillable = [
        'centro_id',
        'entidad_id',
        'direccion',
        'telefono',
        'anho_inicio',
    ];

    /**
     * The attributes that should be cast to native types.
     * @var array
     * @author devjul
     */
    protected $casts = [
        'centro_id'   => 'integer',
        'entidad_id'  => 'integer',
        'direccion'   => 'string',
        'telefono'    => 'string',
        'anho_inicio' => 'year',
    ];
    public function articuladores()
    {
        return $this->hasMany(UserNodo::class, 'nodo_id', 'id')->where('role', User::IsArticulador());
    }

    public function apoyostecnicos()
    {
        return $this->hasMany(UserNodo::class, 'nodo_id', 'id')->where('role', User::IsApoyoTecnico());
    }

    public function dinamizador()
    {
        return $this->hasMany(Dinamizador::class, 'nodo_id', 'id');
    }

    public function gestores()
    {
        return $this->hasMany(Gestor::class, 'nodo_id', 'id');
    }

    public function infocenter()
    {
        return $this->hasMany(Infocenter::class, 'nodo_id', 'id');
    }

    public function ingresos()
    {
        return $this->hasMany(Ingreso::class, 'nodo_id', 'id');
    }

    public function centro()
    {
        return $this->belongsTo(Centro::class, 'centro_id', 'id');
    }

    public function entidad()
    {
        return $this->belongsTo(Entidad::class, 'entidad_id', 'id');
    }

    public function contratista()
    {
        return $this->hasMany(Contratista::class, 'nodo_id', 'id');
    }

    public function ideas()
    {
        return $this->hasMany(Idea::class, 'nodo_id', 'id');
    }

    public function equipos()
    {
        return $this->hasMany(Equipo::class, 'nodo_id', 'id');
    }

    public function materiales()
    {
        return $this->hasMany(Material::class, 'nodo_id', 'id');
    }


    /**
     * Devolver relacion entre proyectos y nodo
     * @author devjul
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proyectos()
    {
        return $this->hasMany(Proyecto::class, 'nodo_id', 'id');
    }

    /**
     * Devolver relacion entre edts y nodo
     * @author devjul
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function edts()
    {
        return $this->hasMany(Edt::class, 'nodo_id', 'id');
    }

    /**
     * Devolver devjul entre articulacion_pbt y nodo
     * @author devjil
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articulaciopbts()
    {
        return $this->hasMany(ArticulacionPbt::class, 'nodo_id', 'id');
    }

    /**
     * Devolver devjul entre articulaciones y nodo
     * @author devjil
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articulaciones()
    {
        return $this->hasMany(Articulacion::class, 'nodo_id', 'id');
    }

    public function lineas()
    {
        return $this->belongsToMany(LineaTecnologica::class, 'lineastecnologicas_nodos')
            ->withTimestamps();
    }

    public function contactosentidades()
    {
        return $this->hasMany(ContactoEntidad::class, 'nodo_id', 'id');
    }

    public function tiposarticulaciones()
    {
        return $this->belongsToMany(User::class, 'nodo_tipoarticulacion')
            ->withTimestamps();
    }

    public function scopeNodoDeTecnoparque($query)
    {
        return $query->select('entidades.id AS id_entidad', 'entidades.nombre AS nombre_nodo', 'nodos.id', 'nodos.direccion', 'centros.codigo_centro')
            ->selectRaw('concat(centros.codigo_centro, " - ", e.nombre) AS centro')
            ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
            ->join('centros', 'centros.id', '=', 'nodos.centro_id')
            ->join('entidades AS e', 'e.id', '=', 'centros.entidad_id');
    }

    public function scopeSelectNodo($query)
    {
        return $query->select('nodos.id', DB::raw("CONCAT('Tecnoparque Nodo ',entidades.nombre) as nodos"))
            ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
            ->orderBy('entidades.nombre');
    }
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

    public function scopeAllLineasPorNodo($query, $nodo)
    {
        return $query->with('lineas')->find($nodo);
    }

    public function scopeNodoUserAthenticated($query, $nodo)
    {
        return $query->select('nodos.id', DB::raw('concat("Tecnoparque nodo ", entidades.nombre) AS nombre'))
            ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
            ->where('nodos.id', '=', $nodo);
    }

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
     * @author devjul
     */
    public function scopeNodoFirst($query)
    {
        return $query->first();
    }

    /**
     * Execute a query for a single record by slug.
     *
     * @param  string  $nodo
     * @param  array  $columns
     * @return mixed|static
     */
    public function scopeFindNodo($query, $nodo, $columns = ['*'])
    {
        return $query->with('entidad')->whereHas('entidad', function ($query) use ($nodo) {
            $query->where('slug', '=', $nodo);
        })->first($columns);
    }

    /**
     * Find a model by its slug or throw an exception.
     *
     * @param  mixed  $nodo
     * @param  array  $columns
     */
    public function scopeFindOrFailNodo($nodo, $columns = ['*'])
    {
        $result = $this->scopeFindNodo($nodo, $columns);
        if (is_array($nodo)) {
            if (count($result) === count(array_unique($nodo))) {
                return $result;
            }
        } elseif (!is_null($result)) {
            return $result;
        } else {
            abort('404');
        }
    }
    public function costoadministrativonodo()
    {
        return $this->belongsToMany(CostoAdministrativo::class, 'nodo_costoadministrativo', 'nodo_id', 'costo_administrativo_id')
            ->withTimestamps()
            ->withPivot([
                'anho',
                'valor',
            ]);
    }

    /**
     * mostar equipo humano de tecnoparque.
     * @author devjul
     * @param array $relations
     * @return array
     */
    public function scopeTeamTecnoparque($query, array $relations)
    {
        if (isset($relations)) {
            return $query->with($relations);
        }
        return $query;
    }

    /**
     * Devolver cantidad de nodos
     * @author devjul
     */
    public function scopeCountNodos($query)
    {
        return $query->count();
    }
}
