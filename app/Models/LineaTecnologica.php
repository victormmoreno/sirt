<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class LineaTecnologica extends Model
{
    protected $table = 'lineastecnologicas';

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'abreviatura',
        'nombre',
        'slug',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'abreviatura' => 'string',
        'nombre'      => 'string',
        'slug'        => 'string',
    ];

    public function sublineas()
    {
        return $this->hasMany(Sublinea::class, 'lineatecnologica_id', 'id');
    }

    public function nodos()
    {
        return $this->belongsToMany(Nodo::class, 'lineastecnologicas_nodos')
            ->withTimestamps();
    }

    public function expertos()
    {
        return $this->hasMany(UserNodo::class, 'linea_id', 'id')->where('role', User::IsExperto());
    }

    public function apoyostecnicos()
    {
        return $this->hasMany(UserNodo::class, 'linea_id', 'id')->where('role', User::IsApoyoTecnico());
    }

    public function equipos()
    {
        return $this->hasMany(Equipo::class, 'lineatecnologica_id', 'id');
    }

    public function materiales()
    {
        return $this->hasMany(Material::class, 'lineatecnologica_id', 'id');
    }

    public function setSlugAttribute($nombre)
    {
        $this->attributes['slug'] = str_slug($nombre, '-');
    }

    public function setAbreviaturaAttribute($abreviatura)
    {
        $this->attributes['abreviatura'] = strtoupper($abreviatura);
    }

    public function setNombreAttribute($nombre)
    {
        $this->attributes['nombre'] = ucwords(mb_strtolower(trim($nombre), 'UTF-8'));
    }

    public function setDescripcionAttribute($descripcion)
    {
        $this->attributes['descripcion'] = ucwords(mb_strtolower(trim($descripcion), 'UTF-8'));
    }

    public function scopeAllLineas($query)
    {
        return $query->paginate(7);
    }

    public function scopeAllLineasForNodo($query, $nodo)
    {
        return $query->with(['nodos'])->find($nodo);
    }

    /**
     * consultar primera linea tecnologica en la base de datos.
     *
     *
     * @return array
     * @author julian londoño
     */
    public function scopeLineaTecnologicaFirst($query)
    {
        return $query->first();
    }

    /**
     * Execute a query for a single record by ID.
     *
     * @param  string  $linea
     * @param  array  $columns
     * @return mixed|static
     */
    public function scopeFindLinea($query, $linea, $columns = ['*'])
    {
        return $query->where('slug', '=', $linea)->first($columns);
    }

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param  mixed  $linea
     * @param  array  $columns
     */
    public function scopeFindOrFailLinea($linea, $columns = ['*'])
    {
        $result = $this->scopeFindLinea($linea, $columns);

        if (is_array($linea)) {
            if (count($result) === count(array_unique($linea))) {
                return $result;
            }
        } elseif (!is_null($result)) {
            return $result;
        } else {
            abort('404');
        }

    }

    /**
     * Devuelve el consulta con relaciones de la tabla lineastecnologicas
     *
     * @author julian londoño
     * @return object
     */
    public static function scopeLineaTecnologicaWithRelations($query, array $relations)
    {
        return $query->with($relations);
    }

}
