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

    public static function IsActive()
    {
        return self::IS_ACTIVE;
    }
    public static function IsInactive()
    {
        return self::IS_INACTIVE;
    }

    public static function IsOtraEps()
    {
        return self::OTRA_EPS;
    }

    public function getCodigoAttribute($codigo)
    {
        return trim($codigo);
    }

    public function getNombreAttribute($nombre)
    {
        return ucwords(strtolower(trim($nombre)));
    }

    public function setCodigoAttribute($codigo)
    {
        $this->attributes['codigo'] = trim($codigo);
    }

    public function setNombreAttribute($nombre)
    {
        $this->attributes['nombre'] = ucwords(mb_strtolower(trim($nombre),'UTF-8'));
    }

    public function users()
    {
        return $this->hasMany(User::class, 'eps_id', 'id');
    }

    public function scopeAllEps($query, $estado, $orderBy)
    {
        return $query->selectRaw('eps.id,  eps.nombre')->where('estado', $estado)->orderby($orderBy);
    }
}
