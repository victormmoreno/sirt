<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoIdea extends Model
{
    protected $table = 'estadosideas';

    public $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'descripcion',
    ];
}
