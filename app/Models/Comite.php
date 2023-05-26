<?php

namespace App\Models;

use App\Models\ArchivoComite;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Comite extends Model
{

    protected $table = 'comites';

    protected $casts = [
        'fechacomite' => 'date:Y-m-d',
    ];

    /**
     * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'codigo',
        'fechacomite',
        'observaciones',
        'acta',
        'formato_evaluacion',
        'estado_comite_id'
    ];

    public function getCodigoAttribute($codigo)
    {
        return trim($codigo);
    }

    public function getObservacionesAttribute($observaciones)
    {
        return ucfirst(strtolower(trim($observaciones)));
    }

    public function historial()
    {
        return $this->morphMany(HistorialEntidad::class, 'model');
    }

    public function registrarHistorialComite($movimiento, $role, $comentario, $descripcion)
    {
        return $this->historial()->create([
            'movimiento_id' => Movimiento::where('movimiento', $movimiento)->first()->id,
            'user_id' => auth()->user()->id,
            'role_id' => Role::where('name', $role)->first()->id,
            'comentarios' => $comentario,
            'descripcion' => $descripcion
            ]);
    }

    public function setCodigoAttribute($codigo)
    {
        $this->attributes['codigo'] = trim($codigo);
    }

    public function estado()
    {
        return $this->belongsTo(EstadoComite::class, 'estado_comite_id', 'id');
    }

    public function setFechaComiteAttribute($fechacomite)
    {
        $this->attributes['fechacomite'] = Carbon::parse($fechacomite)->format('Y-m-d');
    }

    public function setObservacionesAttribute($observaciones)
    {
        $this->attributes['observaciones'] = ucfirst(strtolower(trim($observaciones)));
    }

    public function archivos()
    {
        return $this->hasMany(ArchivoComite::class, 'comite_id', 'id');
    }

    public function rutamodel()
    {
        return $this->morphMany(RutaModel::class, 'model');
    }

    public function ideas()
    {
        return $this->belongsToMany(Idea::class, 'comite_idea')
        ->withTimestamps()
        ->withPivot(['id', 'hora', 'admitido', 'asistencia', 'observaciones', 'direccion', 'notificado']);
    }

    public function evaluadores()
    {
        return $this->belongsToMany(User::class, 'comite_gestor', 'comite_id', 'evaluador_id')
        ->withTimestamps()
        ->withPivot(['hora_inicio', 'hora_fin']);
    }
}
