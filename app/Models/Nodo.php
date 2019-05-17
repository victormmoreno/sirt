<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
        'nombre',
        'direccion',
        'anho_inicio',
        'centroformacion_id',
    ];

    public function centroFormacion()
    {
        return $this->belongsTo(CentroFormacion::class, 'centroformacion_id', 'id');
    }

    public function ideas()
    {
        return $this->hasMany(Ideas::class, 'nodo_id', 'id');
    }

    /*==============================================================
    =            scope para consultar la lista de nodos            =
    ==============================================================*/
      
    public function scopeSelectNodo($query)
    {

        return $query->select('nodos.id',DB::raw("CONCAT('Tecnoparque Nodo ',nodos.nombre) as nodos"));
    
    }
    
    
    /*=====  End of scope para consultar la lista de nodos  ======*/
    
 

  


}
