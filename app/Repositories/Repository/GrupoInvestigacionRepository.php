<?php

namespace App\Repositories\Repository;

use App\Models\{Entidad, GrupoInvestigacion};
use Illuminate\Support\Facades\DB;

class GrupoInvestigacionRepository
{

    // Modifica los datos de un grupo de investigación
    public function update($request, $grupo)
    {
        DB::transaction(function () use ($request, $grupo) {
            $grupo->entidad->ciudad_id     = $request->input('txtciudad_id');
            $grupo->entidad->nombre        = $request->input('txtnombre');
            $grupo->entidad->slug        = str()->slug($request->input('nombre') . str()->random(7), '-');
            $grupo->entidad->email_entidad = $request->input('txtemail_entidad');
            $grupo->entidad->update();
            $grupo->clasificacioncolciencias_id = $request->input('txtclasificacionclociencias_id');
            $grupo->codigo_grupo                = strtoupper($request->input('txtcodigo_grupo'));
            $grupo->tipogrupo                   = $request->input('txttipogrupo');
            $grupo->institucion                 = $request->input('txtinstitucion');
            $grupo->update();
            return $grupo;
        });
    }

    // Registra un grupo de investigación en la base de datos
    public function store($request)
    {
        DB::transaction(function () use ($request) {
            $entidad = Entidad::create([
            'ciudad_id'     => $request->input('txtciudad_id'),
            'nombre'        => $request->input('txtnombre'),
            'slug'          => str()->slug($request->input('nombre') . str()->random(7), '-'),
            'email_entidad' => $request->input('txtemail_entidad'),
            ]);

            return GrupoInvestigacion::create([
                'entidad_id'                  => $entidad->id,
                'clasificacioncolciencias_id' => $request->input('txtclasificacionclociencias_id'),
                'codigo_grupo'                => strtoupper($request->input('txtcodigo_grupo')),
                'tipogrupo'                   => $request->input('txttipogrupo'),
                'estado'                      => GrupoInvestigacion::IsActive(),
                'institucion'                 => $request->input('txtinstitucion'),
            ]);
        });
    }

    public function getAllGruposInvestigacionesForCiudad($ciudad)
    {
        return Entidad::allGrupoInvestigacionForCiudad($ciudad)->pluck('nombre', 'id');
    }

    public function getAllGruposInvestigacionDatatables($ciudad)
    {
        return Entidad::select(['entidades.id', 'entidades.nombre', 'gruposinvestigacion.institucion', 'gruposinvestigacion.codigo_grupo'])
        ->join('gruposinvestigacion', 'gruposinvestigacion.entidad_id', 'entidades.id')
        ->where('entidades.ciudad_id', '=', $ciudad)->get();
    }


}
