<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rols extends Model
{

    const IS_ADMINISTRADOR = "Administrador";
    const IS_DINAMIZADOR = "Dinamizador";
    const IS_GESTOR = "Gestor";
    const IS_INFOCENTER = "Infocenter";
    const IS_TALENTO = "Talento";
    const IS_INGRESO = "Ingreso";
    const IS_PROVEEDOR = "Proveedor";

    protected $table = 'rols';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
    ];

    public static function IsAdministrador()
    {
        return self::IS_ADMINISTRADOR;
    }

    public static function IsDinamizador()
    {
        return self::IS_DINAMIZADOR;
    }

    public static function IsGestor()
    {
        return self::IS_GESTOR;
    }

    public static function IsInfocenter()
    {
        return self::IS_INFOCENTER;
    }

    public static function IsTalento()
    {
        return self::IS_TALENTO;
    }

    public static function IsIngreso()
    {
        return self::IS_INGRESO;
    }

    public static function IsProveedor()
    {
        return self::IS_PROVEEDOR;
    }

    public function users()
    {
      return $this->hasMany(User::class, 'rol_id', 'id');
    }

}
