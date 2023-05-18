<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\User;

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
        'tipo_talento_id',
        'entidad_id',
        'universidad',
        'programa_formacion',
        'carrera_universitaria',
        'empresa',
        'tipo_formacion_id',
        'tipo_estudio_id',
        'dependencia',
    ];

    // Relacion muchos a muchos con articulaciones
    public function articulacionproyecto()
    {
        return $this->belongsToMany(ArticulacionProyecto::class, 'articulacion_proyecto_talento')
            ->withTimestamps()
            ->withPivot('talento_lider');
    }

    // Relacion muchos a muchos con uso de infraestructura


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withTrashed();
    }

    public function idea()
    {
        return $this->belongsTo(Idea::class, 'talento_id', 'id');
    }

    public function tipoformacion()
    {
        return $this->belongsTo(TipoFormacion::class, 'tipo_formacion_id', 'id');
    }

    public function entidad()
    {
        return $this->belongsTo(Entidad::class, 'entidad_id', 'id');
    }

    public function tipoestudio()
    {
        return $this->belongsTo(TipoEstudio::class, 'tipo_estudio_id', 'id');
    }

    public function tipotalento()
    {
        return $this->belongsTo(TipoTalento::class, 'tipo_talento_id', 'id');
    }

    public function scopeConsultarTalentosDeTecnoparque($query)
    {
        return $query->select('users.documento', 'talentos.id', 'users.id AS user_id')
            ->selectRaw('CONCAT(users.nombres, " ", users.apellidos) AS talento')
            ->join('users', 'users.id', '=', 'talentos.user_id');
    }

    // Consulta los talentos de tecnoparque
    public function scopeConsultarTalentoPorId($query, $id)
    {
        return $query->select('users.documento', 'talentos.id', 'users.id AS user_id')
            ->selectRaw('CONCAT(users.nombres, " ", users.apellidos) AS talento')
            ->join('users', 'users.id', '=', 'talentos.user_id')
            ->where('talentos.id', $id);
    }

    public function setUniversidadAttribute($universidad)
    {
        $this->attributes['universidad'] = ucwords(mb_strtolower(trim($universidad), 'UTF-8'));
    }

    public function setProgramaFormacionAttribute($programa_formacion)
    {
        $this->attributes['programa_formacion'] = ucwords(mb_strtolower(trim($programa_formacion), 'UTF-8'));
    }

    public function setCarreraUniversitariaAttribute($carrera_universitaria)
    {
        $this->attributes['carrera_universitaria'] = ucwords(mb_strtolower(trim($carrera_universitaria), 'UTF-8'));
    }

    public function setEmpresaAttribute($empresa)
    {
        $this->attributes['empresa'] = ucwords(mb_strtolower(trim($empresa), 'UTF-8'));
    }
}

