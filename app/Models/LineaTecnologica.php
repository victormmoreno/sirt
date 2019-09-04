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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'abreviatura' => 'string',
        'nombre'      => 'string',
        'descripcion' => 'string',

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

    public function laboratorios()
    {
        return $this->hasMany(Laboratorio::class, 'lineatecnologica_id', 'id');
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
        $this->attributes['nombre'] = ucwords(mb_strtolower(trim($nombre), 'UTF-8'));
    }

    /*=====  End of mutador para tranformar el nombre a minusculas y la primera letra mayusculas  ======*/

    /*====================================================================================================
    =            mutador para tranformar la descripcion a minusculas y la primera letra a myuscaulas            =
    ====================================================================================================*/

    public function setDescripcionAttribute($descripcion)
    {
        $this->attributes['descripcion'] = ucwords(mb_strtolower(trim($descripcion), 'UTF-8'));
    }

    /*=====  End of mutador para tranformar la descripcion a minusculas y la primera letra a myuscaulas  ======*/

    /*===============================================================
    =            scope para seleccionar todas las lineas            =
    ===============================================================*/

    public function scopeAllLineas($query)
    {
        return $query->paginate(7);
    }

    /*=====  End of scope para seleccionar todas las lineas  ======*/

    /*================================================================
    =            scope para consultar las lineas por nodo            =
    ================================================================*/

    public function scopeAllLineasForNodo($query, $nodo)
    {
        return $query->with(['nodos'])->find($nodo);
    }

    /*=====  End of scope para consultar las lineas por nodo  ======*/

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

}
