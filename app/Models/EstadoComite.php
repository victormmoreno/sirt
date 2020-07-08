<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoComite extends Model
{

    const IS_AGENDAMIENTO = 'Agendamiento';

    protected $table = 'estados_comite';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
    ];

    public $timestamps = false;

    public function comites()
    {
        return $this->hasMany(Comite::class, 'estado_comite_id', 'id');
    }

}
