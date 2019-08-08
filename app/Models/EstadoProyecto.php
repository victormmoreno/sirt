<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoProyecto extends Model
{
    protected $table = 'estadosproyecto';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
    ];

    // Scope para consultar los estados de proyecto
    public function scopeConsultarEstadosDeProyectoNoCierre($query)
    {
      return $query->select('id', 'nombre')
      ->whereIn('nombre', ['Inicio', 'Planeación', 'En ejecución']);
    }

    // Scope para consultar los estados de proyecto
    public function scopeConsultarTodosEstadosDeProyecto($query)
    {
      return $query->select('id', 'nombre')
      ->whereIn('nombre', ['Inicio', 'Planeación', 'En ejecución', 'Cierre PF', 'Cierre PMV']);
    }

    /*===============================================
    =            relaciones polimorficas            =
    ===============================================*/
    
    /* relacion con la tabla proyecto */
    
    public function proyectos()
    {
      return $this->hasMany(Proyecto::class, 'estadoproyecto_id', 'id');
    }
    /*=====  End of relaciones polimorficas  ======*/
    
}
