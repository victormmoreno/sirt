<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LineaTecnologica extends Model
{
    protected $table = 'lineastecnologicas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'abreviatura',
        'nombre',
        'descripcion',
    ];

    /*===========================================================================
    =            relaciones elquent            =
    ===========================================================================*/

    public function sublineas()
    {
        return $this->hasMany(Sublinea::class, 'lineatecnologica_id', 'id');
    }

    //relacion muchos a muchos con nodos
    //

    public function nodos()
    {
        return $this->belongsToMany(Nodo::class, 'lineastecnologicas_nodos')
           ->withTimestamps();
    }

    public function gestores()
    {
      return $this->hasMany(Gestor::class, 'lineatecnologica_id', 'id');
    }

    /*=====  End of relaciones elquent  ======*/


    /*===========================================================================
    =            mutador para tranformar la abreviatura a mayusculas            =
    ===========================================================================*/

    public function setAbreviaturaAttribute($abreviatura)
    {
        $this->attributes['abreviatura'] = strtoupper($abreviatura);
    }

    /*=====  End of mutador para tranformar la abreviatura a mayusculas  ======*/

    /*====================================================================================================
    =            mutador para tranformar el nombre a minusculas y la primera letra mayusculas            =
    ====================================================================================================*/

    public function setNombreAttribute($nombre)
    {
        $this->attributes['nombre'] = strtolower($nombre);
        $this->attributes['nombre'] = ucfirst($nombre);
    }

    /*=====  End of mutador para tranformar el nombre a minusculas y la primera letra mayusculas  ======*/


    /*====================================================================================================
    =            mutador para tranformar la descripcion a minusculas y la primera letra a myuscaulas            =
    ====================================================================================================*/

    public function setDescripcionAttribute($descripcion)
    {
        $this->attributes['descripcion'] = strtolower($descripcion);
        $this->attributes['descripcion'] = ucfirst($descripcion);
    }

    /*=====  End of mutador para tranformar la descripcion a minusculas y la primera letra a myuscaulas  ======*/

    /*===============================================================
    =            scope para seleccionar todas las lineas            =
    ===============================================================*/

    public function scopeAllLineas($query)
    {
        return $query->paginate(7);
        // return $query->select(['lineastecnologicas.id','lineastecnologicas.abreviatura','lineastecnologicas.nombre','lineastecnologicas.descripcion','lineastecnologicas.created_at','lineastecnologicas.updated_at'])
        //     ->orderby('lineastecnologicas.nombre');
    }

    /*=====  End of scope para seleccionar todas las lineas  ======*/





}
