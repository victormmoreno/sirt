<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Eps extends Model
{

    const IS_ACTIVE   = 1;
    const IS_INACTIVE = 0;
    const OTRA_EPS    = 'Otra';

    protected $table = 'eps';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'codigo',
        'nombre',
        'estado',
    ];

    /*=================================================================
    =            metodos para conocer el estado de las eps            =
    =================================================================*/

    public static function IsActive()
    {
        return self::IS_ACTIVE;
    }
    public static function IsInactive()
    {
        return self::IS_INACTIVE;
    }

    /*=====  End of metodos para conocer el estado de las eps  ======*/

    /*===========================================================
    =            metodo para retornar las constantes            =
    ===========================================================*/
    
    public static function IsOtraEps()
    {
        return self::OTRA_EPS;
    }
    
    
    /*=====  End of metodo para retornar las constantes  ======*/

    /*=========================================
    =            asesores eloquent            =
    =========================================*/
    public function getCodigoAttribute($codigo)
    {
        return trim($codigo);
    }

    public function getNombreAttribute($nombre)
    {
        return ucwords(strtolower(trim($nombre)));
    }

    /*=====  End of asesores eloquent  ======*/

    /*========================================
    =            mutador eloquent            =
    ========================================*/
    public function setCodigoAttribute($codigo)
    {
        $this->attributes['codigo'] = trim($codigo);
    }

    public function setNombreAttribute($nombre)
    {
        $this->attributes['nombre'] = ucwords(mb_strtolower(trim($nombre),'UTF-8'));
    }

    /*=====  End of mutador eloquent  ======*/
    

    /*===========================================
    =            relaciones eloquent            =
    ===========================================*/
    public function users()
    {
        return $this->hasMany(User::class, 'eps_id', 'id');
    }

    /*=====  End of relaciones eloquent  ======*/

    /*=================================================================
    =            scope para consultar todas la eps segun el estado            =
    =================================================================*/

    public function scopeAllEps($query, $estado, $OrderBy)
    {

        return $query->selectRaw('eps.id,  eps.nombre')->where('estado', $estado)->orderby($OrderBy);

    }

    /*=====  End of scope para consultar todas la eps segun el estado  ======*/

}
