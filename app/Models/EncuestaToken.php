<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EncuestaToken extends Model
{
    const ENVIAR_ENCUESTA = 'enviar.encuesta';

    protected $table = 'encuesta_tokens';

    public $timestamps = false;

    protected $fillable = [
        'email', 'token', 'created_at'
    ];
    
    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function encuestable()
    {
        return $this->morphTo();
    }
}
