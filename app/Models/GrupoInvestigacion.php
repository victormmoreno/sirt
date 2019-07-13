<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupoInvestigacion extends Model
{

    const IS_EXTERNO  = 0; //ES EXTERNO SI ES DE OTRA INSTITUCION
    const IS_INTERNO  = 1; //ES INTENERNO SI ES DEL SENA
    const IS_INACTIVE = 0; // ES INACTIVO EL GRUPO DE INVESTIGACIÓN
    const IS_ACTIVE   = 1; // ES ACTIVO EL GRUPO DE INVESTIGACIÓN

    protected $table = 'gruposinvestigacion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entidad_id',
        'clasificacioncolciencias_id',
        'codigo_grupo',
        'tipogrupo',
        'estado',
        'institucion',
        // 'nombres_contacto',
        // 'correo_contacto',
        // 'telefono_contacto',
    ];


    // Retorno de las constantes del mdoelo de grupos de investigacion
    public static function IsInterno()
    {
        return self::IS_INTERNO;
    }
    public static function IsExterno()
    {
        return self::IS_EXTERNO;
    }

    public static function IsActive()
    {
        return self::IS_ACTIVE;
    }
    public static function IsInactive()
    {
        return self::IS_INACTIVE;
    }

    // Consultas scope para la tabla de grupos de investigación
    public function scopeConsultarGruposDeInvestigaciónTecnoparque($query)
    {
      return $query->select(
        'codigo_grupo',
        'entidades.nombre',
        'institucion',
        'clasificacionescolciencias.nombre AS clasificacioncolciencias',
        'gruposinvestigacion.id',
        'entidades.id AS id_entidad'
        )
      ->selectRaw('CONCAT(ciudades.nombre, " - ", departamentos.nombre) AS ciudad')
      ->selectRaw('IF(tipogrupo = ' . $this->IsInterno() . ', "Interno", "Externo") AS tipo_grupo')
      ->join('entidades', 'entidades.id', '=', 'gruposinvestigacion.entidad_id')
      ->join('clasificacionescolciencias', 'clasificacionescolciencias.id', '=', 'gruposinvestigacion.clasificacioncolciencias_id')
      ->join('ciudades', 'ciudades.id', '=', 'entidades.ciudad_id')
      ->join('departamentos', 'departamentos.id', '=', 'ciudades.departamento_id')
      ->where('gruposinvestigacion.estado', $this->IsActive());
    }

    // Consultas scope para la tabla de grupos de investigación del sena
    public function scopeConsultarGruposDeInvestigaciónTecnoparqueSena($query)
    {
      return $query->select(
        'codigo_grupo',
        'entidades.nombre',
        'institucion',
        'clasificacionescolciencias.nombre AS clasificacioncolciencias',
        'gruposinvestigacion.id',
        'entidades.id AS id_entidad'
        )
      ->selectRaw('CONCAT(ciudades.nombre, " - ", departamentos.nombre) AS ciudad')
      ->selectRaw('IF(tipogrupo = ' . $this->IsInterno() . ', "Interno", "Externo") AS tipo_grupo')
      ->join('entidades', 'entidades.id', '=', 'gruposinvestigacion.entidad_id')
      ->join('clasificacionescolciencias', 'clasificacionescolciencias.id', '=', 'gruposinvestigacion.clasificacioncolciencias_id')
      ->join('ciudades', 'ciudades.id', '=', 'entidades.ciudad_id')
      ->join('departamentos', 'departamentos.id', '=', 'ciudades.departamento_id')
      ->where('gruposinvestigacion.estado', $this->IsActive())
      ->where('tipogrupo', $this->IsInterno());
    }

    // Consultas scope para la tabla de grupos de investigación externos al sena
    public function scopeConsultarGruposDeInvestigaciónTecnoparqueExterno($query)
    {
      return $query->select(
        'codigo_grupo',
        'entidades.nombre',
        'institucion',
        'clasificacionescolciencias.nombre AS clasificacioncolciencias',
        'gruposinvestigacion.id',
        'entidades.id AS id_entidad'
        )
      ->selectRaw('CONCAT(ciudades.nombre, " - ", departamentos.nombre) AS ciudad')
      ->selectRaw('IF(tipogrupo = ' . $this->IsInterno() . ', "Interno", "Externo") AS tipo_grupo')
      ->join('entidades', 'entidades.id', '=', 'gruposinvestigacion.entidad_id')
      ->join('clasificacionescolciencias', 'clasificacionescolciencias.id', '=', 'gruposinvestigacion.clasificacioncolciencias_id')
      ->join('ciudades', 'ciudades.id', '=', 'entidades.ciudad_id')
      ->join('departamentos', 'departamentos.id', '=', 'ciudades.departamento_id')
      ->where('gruposinvestigacion.estado', $this->IsActive())
      ->where('tipogrupo', $this->IsExterno());
    }

    // Relación con la tabla de entidades
    public function entidad()
    {
      return $this->belongsTo(Entidad::class, 'entidad_id', 'id');
    }

    //Relación con la tabla de clasificacionescolciencias
    public function clasificacioncolciencias()
    {
      return $this->belongsTo(ClasificacionColciencias::class, 'clasificacioncolciencias_id', 'id');
    }

}
