<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultadoEncuesta extends Model
{
    /**
     * the table name
     * @var string
     */
    protected $table = 'resultados_encuesta';

    protected $fillable = [
        'proyecto_id', 'user_id', 'resultados', 'fecha_envio', 'fecha_respuesta'
    ];

    protected $casts = [
        'resultados' => 'array',
    ];

    public function encuestaToken()
    {
        return $this->hasOne(EncuestaToken::class);
    }

    public function proyecto()
    {
        return $this->hasOne(Proyecto::class, 'proyecto_id', 'id');
    }
}
