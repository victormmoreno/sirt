<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class GrupoSanguineo extends Model
{
    protected $table = 'gruposanguineos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
    ];

    public $timestamps = false;

    public function users()
    {
      return $this->hasMany(User::class, 'gruposanguineo_id', 'id');
    }

    public function scopeAllGrupoSanguineos($query, $OrderBy)
    {

        return $query->select('gruposanguineos.id','gruposanguineos.nombre')->orderby($OrderBy);

    }
}
