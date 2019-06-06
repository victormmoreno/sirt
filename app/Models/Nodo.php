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

    public function infocenter()
    {
        return $this->hasMany(Infocenter::class, 'nodo_id', 'id');
    }

    /*=====  End of relaciones eloquent  ======*/

    /*==============================================================
    =            scope para consultar la lista de nodos            =
    ==============================================================*/

    public function scopeSelectNodo($query)
    {

        return $query->select('nodos.id', DB::raw("CONCAT('Tecnoparque Nodo ',nodos.nombre) as nodos"));

    }

    /*=====  End of scope para consultar la lista de nodos  ======*/

    /*====================================================================================================
    =            scope para consultar el nodo del dinamizador - gestor - infocenter - ingreso            =
    ====================================================================================================*/
    public function scopeUserNodo($query, $nodo_id)
    {

        return $query->where('id', '=', $nodo_id);

    }

    /*=====  End of scope para consultar el nodo del dinamizador - gestor - infocenter - ingreso  ======*/

}
