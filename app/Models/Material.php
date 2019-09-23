<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'materiales';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipomaterial_id',
        'laboratorio_id',
        'cantidad',
        'item',
        'anho_compra',
        'horas_uso',
        'precio_unitario',
        'estado',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'tipomaterial_id' => 'integer',
        'laboratorio_id'  => 'integer',
        'cantidad'        => 'string',
        'item'            => 'string',
        'anho_compra'     => 'string',
        'horas_uso'       => 'string',
        'precio_unitario' => 'string',
        'estado'          => 'boolean',
    ];

}
