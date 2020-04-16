<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Honorario extends Model
{
    protected $table = 'honorarios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'gestor_id',
        'anio',
        'valor'
    ];

    public function gestor()
    {
        return $this->belongsTo(Gestor::class, 'gestor_id', 'id');
    }
}
