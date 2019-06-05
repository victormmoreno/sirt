<?php

namespace App\Models;

use App\User;
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
        'centro_id',
        'nombre',
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


    // public function centros()
    // {
    //   return $this->hasMany(Centro::class, 'centro_id', 'id');
    // }
  


    /*=====  End of relaciones eloquent  ======*/




    /*==============================================================
    =            scope para consultar la lista de nodos            =
    ==============================================================*/

    public function scopeSelectNodo($query)
    {

        return $query->select('nodos.id',DB::raw("CONCAT('Tecnoparque Nodo ',nodos.nombre) AS nodos"));

    }


    /*=====  End of scope para consultar la lista de nodos  ======*/

    public function scopeListNodos($query)
    {
      return $query->select(DB::raw('concat("Tecnoparque nodo ", nombre) AS nombre'), 'id');
    }





}
