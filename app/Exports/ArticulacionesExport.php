<?php

namespace App\Exports;

use App\Models\{Articulacion, ArticulacionProyecto};
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;

class ArticulacionesExport
{
  use Exportable;
  // /**
  // * @return \Illuminate\Support\Collection
  // */
  // public function collection()
  // {
  //   return Articulacion::all();
  // }

  public function query()
  {
    return Articulacion::select('codigo_actividad AS codigo_articulacion', 'nombre', 'articulaciones.id')
    ->selectRaw('IF(tipo_articulacion = '.Articulacion::IsGrupo().', "Grupo de Investigación", IF(tipo_articulacion = '.Articulacion::IsEmpresa().', "Empresa", "Emprendedor(es)") ) AS tipo_articulacion')
    ->selectRaw('IF(articulaciones.estado = '.Articulacion::IsInicio().', "Inicio", IF(articulaciones.estado = '.Articulacion::IsEjecucion().', "Ejecución", "Cierre") ) AS estado')
    ->selectRaw('IF(revisado_final = '.ArticulacionProyecto::IsPorEvaluar().', "Por Evaluar", IF(revisado_final = '.ArticulacionProyecto::IsAprobado().', "Aprobado", "No Aprobado") ) AS revisado_final')
    ->selectRaw('CONCAT(users.documento, " - ", users.nombres, " ", users.apellidos) AS nombre_completo_gestor')
    ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'articulaciones.articulacion_proyecto_id')
    ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
    ->join('users', 'users.id', '=', 'gestores.user_id')
    ->where('actividades.gestor_id', 1)
    ->get()->toArray();
  }

  // public function array()
  // {
  //     return Articulacion::array()->where('id', 2)->get();
  // }
}
