<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoComite extends Model
{

    const IS_PROGRAMADO = 'Programado';
    const IS_REALIZADO = 'Realizado';
    const IS_ASIGNADO = 'Proyectos asignados';

    protected $table = 'estados_comite';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
    ];

    public $timestamps = false;

    public function comites()
    {
        return $this->hasMany(Comite::class, 'estado_comite_id', 'id');
    }

    public static function IsProgramado()
    {
        return self::IS_PROGRAMADO;
    }

    public static function IsRealizado()
    {
        return self::IS_REALIZADO;
    }

    public static function IsAsignado()
    {
        return self::IS_ASIGNADO;
    }

}
