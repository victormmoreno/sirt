<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{
    /**
     * the table name
     * @var string
     * @author dum
     */
    protected $table = 'encuestas';

    protected $fillable = [
        'titulo',
        'descripcion',
        'estado'
    ];
}
