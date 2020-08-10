<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Centro extends Model
{
    protected $table = 'centros';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'regional_id',
        'entidad_id',
        'ciudad_id',
        'codigo_centro',
    ];

    /*=========================================
    =            asesores eloquent            =
    =========================================*/

    public function getCodigoCentroAttribute($codigo_centro)
    {
        return trim($codigo_centro);
    }

    public function getDescripcionAttribute($descripcion)
    {
        return ucfirst(strtolower(trim($descripcion)));
    }

    /*=====  End of asesores eloquent  ======*/

    /*========================================
    =            mutador eloquent            =
    ========================================*/

    public function setCodigoCentroAttribute($codigo_centro)
    {
        $this->attributes['codigo_centro'] = trim($codigo_centro);
    }

    /*=====  End of mutador eloquent  ======*/

    public function regional()
    {
        return $this->belongsTo(Regional::class, 'regional_id', 'id');
    }
    public function entidad()
    {
        return $this->belongsTo(Entidad::class, 'entidad_id', 'id');
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id', 'id');
    }

    public function tecnoacademias()
    {
        return $this->hasMany(Tecnoacademia::class, 'centro_id', 'id');
    }

    public function nodos()
    {
        return $this->hasMany(Nodo::class, 'centro_id', 'id');
    }

    public function scopeCentroDeFormacionDeTecnoparque($query)
    {
      return $query->select('entidades.nombre', 'centros.codigo_centro', 'entidades.id AS id_entidad')
      ->join('entidades', 'entidades.id', '=', 'centros.entidad_id');
    }

    /*==================================================================
    =            scope para consultar todos los centros            =
    ==================================================================*/

    public function scopeAllCentros($query)
    {
        return $query->select(['entidades.id','entidades.nombre'])->with(['centro']);
    }

    /*=====  End of scope para consultar todos los centros  ======*/

     /*================================================================================
    =            metodo para consultar los centros por regional            =
    ================================================================================*/

    public function scopeAllCentrosRegional($query,$regional)
    {

        return $query->select(['centros.id','entidades.nombre'])
                ->join('entidades','entidades.id','=','centros.entidad_id')
                ->join('regionales','regionales.id', '=','centros.regional_id')
                ->where('centros.regional_id',$regional);

    }

    /*=====  End of metodo para consultar los centros por regional  ======*/
}
