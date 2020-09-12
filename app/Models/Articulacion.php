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

    protected $table = 'articulaciones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'articulacion_proyecto_id',
        'tipo_articulacion',
        'acc',
        'informe_final',
        'acuerdos',
        'alcance_articulacion',
        'siguientes_investigaciones',
        'fase_id'
    ];

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'articulaciones_productos')
            ->withTimestamps()
            ->withPivot('logrado');
    }

    public function fase()
    {
        return $this->belongsTo(Fase::class, 'fase_id', 'id');
    }

    // Relacion muchos a muchos con talentos
    public function talentos()
    {
        return $this->belongsToMany(Talento::class, 'articulacion_talento')
            ->withTimestamps()
            ->withPivot('talento_lider');
    }

    public function articulacion_proyecto()
    {
        return $this->belongsTo(ArticulacionProyecto::class, 'articulacion_proyecto_id', 'id');
    }

    /*====================================================================================
    =            scope para consultar articulaciones por tipo de articulacion            =
    ====================================================================================*/

    public function scopeArticulacionesForTipoArticulacion($query, int $tipoArticulacion)
    {
        $query->where('tipo_articulacion', $tipoArticulacion);
    }

    /*=====  End of scope para consultar articulaciones por tipo de articulacion  ======*/

    /*===================================================================
    =            scope para consultar articulaciones           =
    ===================================================================*/

    public function scopeArticulacionesWithRelations($query, array $relations)
    {
        return $query->with($relations);
    }

    /*=====  End of scope para consultar por estado de proyecto  ======*/
}
