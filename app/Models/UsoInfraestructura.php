<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsoInfraestructura extends Model
{
    protected $table = 'usoinfraestructuras';

    const IS_PROYECTO     = 0;
    const IS_ARTICULACION = 1;
    const IS_EDT          = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'actividad_id',
        'tipo_usoinfraestructura',
        'fecha',
        'descripcion',
        'estado',
    ];

    protected $dates = [
        'fecha',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'actividad_id'            => 'integer',
        'tipo_usoinfraestructura' => 'integer',
        'fecha'                   => 'date:Y-m-d',
        'descripcion'             => 'string',
        'estado'                  => 'boolean',
    ];

    public static function IsProyecto()
    {
        return self::IS_PROYECTO;
    }

    public static function IsArticulacion()
    {
        return self::IS_ARTICULACION;
    }

    public static function IsEdt()
    {
        return self::IS_EDT;
    }

    /**
     * Elimina los datos de material_uso
     *
     * @param Collection $actividad
     * @return void
     */
    public static function deleteUsoMateriales($actividad)
    {
      foreach ($actividad->usoinfraestructuras as $key => $value) {
        $value->usomateriales()->sync([]);
      }
    }

    /**
     * Elimina los datos de uso_talento
     *
     * @param Collection $actividad
     * @return void
     */
    public static function deleteUsoTalentos($actividad)
    {
      foreach ($actividad->usoinfraestructuras as $key => $value) {
        $value->usotalentos()->sync([]);
      }
    }

    /**
     * Elimina los datos de equipo_uso
     *
     * @param Collection $actividad
     * @return void
     */
    public static function deleteUsoEquipos($actividad)
    {
      foreach ($actividad->usoinfraestructuras as $key => $value) {
        $value->usoequipos()->sync([]);
      }
    }

    /**
     * Elimina los datos de gestor_uso
     *
     * @param Collection $actividad
     * @return void
     */
    public static function deleteUsoGestores($actividad)
    {
      foreach ($actividad->usoinfraestructuras as $key => $value) {
        $value->usogestores()->sync([]);
      }
    }

    public function actividad()
    {
        return $this->belongsTo(Actividad::class, 'actividad_id', 'id');
    }

    public function usolaboratorios()
    {
        return $this->belongsToMany(Laboratorio::class, 'uso_laboratorios', 'usoinfraestructura_id', 'laboratorio_id')
            ->withTimestamps()
            ->withPivot('tiempo');
    }

    public function usoequipos()
    {
        return $this->belongsToMany(Equipo::class, 'equipo_uso', 'usoinfraestructura_id','equipo_id')
            ->withTimestamps()
            ->withPivot([
                'tiempo',
                'costo_equipo',
                'costo_administrativo',
            ]);
    }

    public function usomateriales()
    {
        return $this->belongsToMany(Material::class, 'material_uso', 'usoinfraestructura_id','material_id')
            ->withTimestamps()
            ->withPivot([
                'costo_material',
                'unidad',
            ]);
    }

    public function usotalentos()
    {
        return $this->belongsToMany(Talento::class, 'uso_talentos', 'usoinfraestructura_id', 'talento_id')
            ->withTimestamps();
    }


    public function usogestores()
    {
        return $this->belongsToMany(Gestor::class, 'gestor_uso', 'usoinfraestructura_id','gestor_id')
            ->withTimestamps()
            ->withPivot([
                'asesoria_directa',
                'asesoria_indirecta',
                'costo_asesoria',
            ]);
    }

    public function setDescripcionAttribute($descripcion)
    {
        $this->attributes['descripcion'] = ucwords(mb_strtolower(trim($descripcion), 'UTF-8'));
    }

    public function getDescripcionAttribute($descripcion)
    {
        return ucwords(strtolower(trim($descripcion)));
    }

    public function scopeUsoInfraestructuraWithRelations($query, array $relations)
    {
        return $query->with($relations);
    }

    public static function TipoUsoInfraestructura($tipo_usoinfraestructura)
    {
        if ($tipo_usoinfraestructura == self::IsProyecto()) {
            return 'Proyecto ';
        } else if ($tipo_usoinfraestructura == self::IsArticulacion()) {
            return 'Articulacion ';
        } else if ($tipo_usoinfraestructura == self::IsEdt()) {
            return 'EDT ';
        } else {
            return 'No registra';
        }
    }
}
