<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipoMantenimiento extends Model
{
    /**
     * define el nombre de la tabla.
     * @var string
     */
    protected $table = 'equipo_mantenimiento';

    /**
     * valor permitidos a ingresar. proteccion asignacion masiva de datos
     * @var array
     */
    protected $fillable = [
        'equipo_id',
        'ultimo_anio_mantenimiento',
        'vida_util_mantenimiento',
        'horas_uso_anio',
        'valor_mantenimiento',
    ];

    /**
     * The attributes that should be cast to native types.
     * @var array
     */
    protected $casts = [
        'equipo_id'                 => 'integer',
        'ultimo_anio_mantenimiento' => 'year',
        'vida_util_mantenimiento'   => 'integer',
        'horas_uso_anio'            => 'string',
        'valor_mantenimiento'       => 'string',
    ];

    /**
     * asesor para el campo valor.
     * @param $valor
     */
    public function setValorAttribute($valor)
    {
        $this->attributes['valor'] = trim($valor);
    }

    /**
     * mutador para el campo valor.
     * @param $valor
     */
    public function getValorAttribute($valor)
    {
        return trim($valor);
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'equipo_id', 'id');
    }

}
