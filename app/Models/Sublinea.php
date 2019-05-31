<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sublinea extends Model
{
    protected $table = 'sublineas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lineatecnologica_id',
        'nombre',
    ];
}
