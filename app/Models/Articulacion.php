<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Articulacion extends Model
{


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
        'fase_id',
        'codigo_articulacion',
        'nombre',
        'fecha_inicio',
        'fecha_cierre',
        'objetivo_general',
        'conclusiones',
        'formulario_inicio',
        'cronograma',
        'seguimiento',
        'formulario_final'
    ];

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'articulaciones_productos')
            ->withTimestamps()
            ->withPivot('logrado');
    }

    /**
     * Define an inverse one-to-one or many relationship between articulaciones and users
     * @author devjul
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function asesor()
    {
        return $this->belongsTo(User::class, 'asesor_id', 'id');
    }

    /**
     * Define an inverse one-to-one or many relationship between articulaciones and node
     * @author devjul
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nodo()
    {
        return $this->belongsTo(Nodo::class, 'nodo_id', 'id');
    }

    public function fase()
    {
        return $this->belongsTo(Fase::class, 'fase_id', 'id');
    }

    public function scopeArticulacionesForTipoArticulacion($query, int $tipoArticulacion)
    {
        $query->where('tipo_articulacion', $tipoArticulacion);
    }

    public function scopeArticulacionesWithRelations($query, array $relations)
    {
        return $query->with($relations);
    }
}
