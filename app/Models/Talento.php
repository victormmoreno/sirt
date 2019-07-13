<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Talento extends Model
{
    protected $table = 'talentos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'perfil_id',
        'entidad_id',
        'ciudad_id',
        'programa',
    ];

    // Relacion muchos a muchos con articulaciones
    public function articulaciones()
    {
        return $this->belongsToMany(Articulacion::class, 'articulacion_talento')
            ->withTimestamps()
            ->withPivot('talento_lider');
    }

    // Relacion muchos a muchos con articulaciones
    public function proyectos()
    {
      return $this->belongsToMany(Proyecto::class, 'proyecto_talento')
      ->withTimestamps()
      ->withPivot('talento_lider');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Métodos scope
    // Consulta los talentos de tecnoparque
    public function scopeConsultarTalentosDeTecnoparque($query)
    {
      return $query->select('users.documento', 'talentos.id')
      ->selectRaw('CONCAT(users.nombres, " ", users.apellidos) AS talento')
      ->join('users', 'users.id', '=', 'talentos.user_id');
    }

    // Consulta los talentos de tecnoparque
    public function scopeConsultarTalentoPorId($query, $id)
    {
      return $query->select('users.documento', 'talentos.id')
      ->selectRaw('CONCAT(users.nombres, " ", users.apellidos) AS talento')
      ->join('users', 'users.id', '=', 'talentos.user_id')
      ->where('talentos.id' ,$id);
    }
}
