<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Linea extends Model
{
    protected $table = 'lineas';

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
    

    

}
