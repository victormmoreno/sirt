<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prototipo extends Model
{
    protected $table = 'prototipos';

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
