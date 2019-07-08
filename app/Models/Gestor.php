<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Gestor extends Model
{
    protected $table = 'gestores';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'nodo_id',
        'lineatecnologica_id',
        'honorarios',
    ];

    public function scopeConsultarGestoresPorNodo($query, $id)
    {
      return $query->select('gestores.id')
      ->selectRaw('CONCAT(users.documento, " - ", users.nombres, " ", users.apellidos) AS nombres_gestor')
      ->join('users', 'users.id', '=', 'gestores.user_id')
      ->join('nodos', 'nodos.id', '=', 'gestores.nodo_id')
      ->where('nodos.id', $id);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }

    public function nodo()
    {
        return $this->belongsTo(Nodo::class, 'nodo_id', 'id');
    }

    // Relación con la tabla de líneas tecnológicas
    public function lineatecnologica()
    {
        return $this->belongsTo(LineaTecnologica::class, 'lineatecnologica_id', 'id');
    }

    // Relación a la tabla de articulaciones
    public function articulaciones()
    {
      return $this->hasMany(Articulacion::class, 'gestor_id', 'id');
    }
}
