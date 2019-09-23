<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    protected $table = 'mantenimientos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'laboratorio_id',
        'item',
        'precio',
        'vida_util',
        'anho_ultimo_mantenimiento',
        'horas_uso',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'laboratorio_id'            => 'integer',
        'item'                      => 'string',
        'precio'                    => 'string',
        'vida_util'                 => 'string',
        'anho_ultimo_mantenimiento' => 'string',
        'horas_uso'                 => 'string',
    ];
}
