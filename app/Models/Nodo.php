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

    public function ingresos()
    {
        return $this->hasMany(Ingreso::class, 'nodo_id', 'id');
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

}
