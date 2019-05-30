<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradoEscolaridad extends Model
{
    protected $table = 'gradosescolaridad';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
    ];
}
