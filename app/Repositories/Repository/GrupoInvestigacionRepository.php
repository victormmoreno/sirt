<?php

namespace App\Repositories\Repository;

use App\Models\GrupoInvestigacion;
use App\Models\ClasificacionColciencias;
use App\Models\Entidad;
use Illuminate\Support\Facades\DB;

class GrupoInvestigacionRepository
{
  // Modifica los datos de un grupo de investigación
  public function update($request, $grupo)
  {
    DB::transaction(function () use ($request, $grupo) {
      $grupo->entidad->ciudad_id = $request->input('txtciudad_id');
      $grupo->entidad->nombre = $request->input('txtnombre');
      $grupo->entidad->email_entidad = $request->input('txtemail_entidad');
      $grupo->entidad->update();
      $grupo->clasificacioncolciencias_id = $request->input('txtclasificacionclociencias_id');
      $grupo->codigo_grupo = strtoupper($request->input('txtcodigo_grupo'));
      $grupo->tipogrupo = $request->input('txttipogrupo');
      $grupo->institucion = $request->input('txtinstitucion');
      $grupo->nombres_contacto = $request->input('txtnombres_contacto');
      $grupo->correo_contacto = $request->input('txtcorreo_contacto');
      $grupo->telefono_contacto = $request->input('txttelefono_contacto');
      $grupo->update();
      return $grupo;
    });
  }

  // Registra un grupo de investigación en la base de datos
  public function store($request)
  {
    DB::transaction(function () use ($request) {
      $entidad = Entidad::create([
        'ciudad_id' => $request->input('txtciudad_id'),
        'nombre' => $request->input('txtnombre'),
        'email_entidad' => $request->input('txtemail_entidad'),
      ]);

      return GrupoInvestigacion::create([
        'entidad_id' => $entidad->id,
        'clasificacioncolciencias_id' => $request->input('txtclasificacionclociencias_id'),
        'codigo_grupo' => strtoupper($request->input('txtcodigo_grupo')),
        'tipogrupo' => $request->input('txttipogrupo'),
        'estado' => GrupoInvestigacion::IsActive(),
        'institucion' => $request->input('txtinstitucion'),
        'nombres_contacto' => $request->input('txtnombres_contacto'),
        'correo_contacto' => $request->input('txtcorreo_contacto'),
        'telefono_contacto' => $request->input('txttelefono_contacto'),
      ]);
    });
  }

}
