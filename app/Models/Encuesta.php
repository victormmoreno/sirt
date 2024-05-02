<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{
    /**
     * the table name
     * @var string
     */
    protected $table = 'encuestas';

    protected $fillable = [
        'titulo',
        'descripcion',
        'estado'
    ];

    public function encuestaToken()
    {
        return $this->hasOne(EncuestaToken::class);
    }
}
