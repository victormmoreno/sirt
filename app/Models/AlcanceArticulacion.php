<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlcanceArticulacion extends Model
{
    protected $table = 'alcance_articulaciones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'nombre'];
}
