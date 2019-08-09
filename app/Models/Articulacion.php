<?php

namespace App\Models;

use App\Http\Traits\ArticulacionTrait\ArticulacionTrait;
use Illuminate\Database\Eloquent\Model;

class Articulacion extends Model
{

  use ArticulacionTrait;

    // Constante para la entidad de no aplica
    const IS_NOAPLICA = 1;

    //Constantes del campo tipo_articulacion
    const IS_GRUPO       = 0; //ES UNA ARTICULACION CON GRUPO DE INVESTIGACIÓN
    const IS_EMPRESA     = 1; //ES UNA ARTICULACIÓN CON EMPRESA
    const IS_EMPRENDEDOR = 2; // ES UNA ARTICULACIÓN CON EMPRENDEDOR

    //Constantes de campo estado
    const IS_INICIO    = 0; // EL ESTADO DE LA ARTICULACIÓN ES INICIO
    const IS_EJECUCION = 1; // EL ESTADO DE LA ARTICULACIÓN ES EJECUCICIÓM Ó CO-EJECUCICIÓM
    const IS_CIERRE    = 2; // EL ESTADO DE LA ARTICULACIÓN ES CIERRE

    //Constatens del campo revisado_final
    const IS_POREVALUAR = 0;
    const IS_APROBADO   = 1;
    const IS_NOAPROBADO = 2;

    

    protected $table = 'articulaciones';

    protected $casts = [
        'fecha_inicio'    => 'date:Y-m-d',
        'fecha_ejecucion' => 'date:Y-m-d',
        'fecha_cierre'    => 'date:Y-m-d',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entidad_id',
        'tipoarticulacion_id',
        'gestor_id',
        // 'tipogrupo',
        'codigo_articulacion',
        'nombre',
        'revisado_final',
        'tipo_articulacion',
        'fecha_inicio',
        'fecha_ejecucion',
        'fecha_cierre',
        'observaciones',
        'estado',
        'acta_inicio',
        'acc',
        'actas_seguimiento',
        'acta_cierre',
        'informe_final',
        'pantallazo',
        'otros',
    ];

    // Relacion muchos a muchos con talentos
    public function talentos()
    {
        return $this->belongsToMany(Talento::class, 'articulacion_talento')
            ->withTimestamps()
            ->withPivot('talento_lider');
    }

    // Relación a la tabla de tipos de articulación
    public function tipoarticulacion()
    {
        return $this->belongsTo(TipoArticulacion::class, 'tipoarticulacion_id', 'id');
    }

    // Relación a la tabla de gestor
    public function gestor()
    {
        return $this->belongsTo(Gestor::class, 'gestor_id', 'id');
    }

    // Relación a la tabla de entidad
    public function entidad()
    {
        return $this->belongsTo(Entidad::class, 'entidad_id', 'id');
    }

    // Relación a la tabla de archivosarticulaciones
    public function archivosarticulaciones()
    {
        return $this->hasMany(ArchivoArticulacion::class, 'articulacion_id', 'id');
    }

    /*==========================================================================
    =            scope para consultar las articulaciones por estado            =
    ==========================================================================*/
    
    public function scopeArticulacionesForEstado($query, int $estado)
    {
        $query->with([
            'tipoarticulacion' => function ($query) {
                $query->select('id', 'nombre');
            },
            'entidad'=> function ($query) {
                $query->select('id', 'nombre');
            },
            'gestor'=> function ($query) {
                $query->select('id', 'user_id','honorarios');
            },
            'gestor.user' => function ($query) {
                $query->select('id', 'nombres', 'apellidos', 'documento');
            },
        ])->select('id', 'nombre', 'codigo_articulacion', 'tipoarticulacion_id','entidad_id','gestor_id')
          ->where('estado',$estado);
    }
    
    /*=====  End of scope para consultar las articulaciones por estado  ======*/

    /*====================================================================================
    =            scope para consultar articulaciones por tipo de articulacion            =
    ====================================================================================*/
    
    public function scopeArticulacionesForTipoArticulacion($query, int $tipoArticulacion)
    {
        $query->where('tipo_articulacion',$tipoArticulacion);
    }
    
    /*=====  End of scope para consultar articulaciones por tipo de articulacion  ======*/
    
    

}
