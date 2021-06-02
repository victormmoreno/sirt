<?php

namespace App\Repositories\Repository;

use App\Models\{Empresa, Sede, Proyecto};
use Illuminate\Support\Facades\{DB, Session};
use App\User;

class EmpresaRepository
{

    /**
     * Consulta las empresas asociadas a proyectos, articulaciones y edts
     * @param string $fecha_inicio Primera fecha para realizar el filtro
     * @param string $fecha_fin Segunda fecha para realizar el filtro
     * @return Builder
     * @author dum
     */
    public function consultarEmpresasAsociadosAServicios($fecha_inicio, $fecha_fin)
    {
        return Empresa::select('nit',
        'entidades.nombre',
        'codigo_actividad')
        ->join('entidades', 'entidades.id', '=', 'empresas.entidad_id')
        ->join('articulacion_proyecto', 'articulacion_proyecto.entidad_id', '=', 'entidades.id')
        ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
        ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
        ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
        ->where('entidades.nombre', '!=', 'No Aplica')
        ->where(function($q) use ($fecha_inicio, $fecha_fin) {
        $q->where(function($query) use ($fecha_inicio, $fecha_fin) {
            $query->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin]);
        })
        ->orWhere(function($query) use ($fecha_inicio, $fecha_fin) {
            $query->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin]);
        });
        });
    }

    /**
        * Consulta las empresas asociadas como propietarias a proyecto
        *
        * @param string $fecha_inicio
        * @param string $fecha_cierre
        * @return Eloquent
        * @author dum
        **/
    public function empresasPropietarias(string $fecha_inicio, string $fecha_cierre)
    {
        return Empresa::select(
        'codigo_actividad',
        'nit',
        'codigo_ciiu',
        'entidades.nombre AS nombre_empresa',
        'fecha_creacion',
        'sectores.nombre AS nombre_sector',
        'entidades.email_entidad',
        'empresas.direccion',
        'tamanhos_empresas.nombre AS tamanho_empresa',
        'tipos_empresas.nombre AS tipo_empresa',
        'areasconocimiento.nombre AS nombre_areaconocimiento',
        'lineastecnologicas.nombre AS nombre_linea',
        'entidad_nodo.nombre AS nodo_nombre',
        'sublineas.nombre AS nombre_sublinea',
        'actividades.nombre',
        'fases.nombre AS nombre_fase'
        )
        ->selectRaw('concat(ciudades.nombre, " - ", departamentos.nombre) AS ciudad')
        ->selectRaw('concat(ideas.codigo_idea, " - ", ideas.nombre_proyecto) AS nombre_idea')
        ->selectRaw('concat(users.documento, " - ", users.nombres, " ", users.apellidos) AS gestor')
        ->selectRaw('IF(pp.trl_esperado = '.Proyecto::IsTrl6Esperado().', "TRL 6", "TRL 7 - TRL 8") AS trl_esperado')
        ->selectRaw('IF(fases.nombre = "Finalizado", IF(pp.trl_obtenido = 0, "TRL 6", IF(pp.trl_obtenido = 1, "TRL 7", "TRL 8")), "El proyecto no se ha cerrado") AS trl_obtenido')
        ->selectRaw('IF(fases.nombre = "Finalizado" || fases.nombre = "Suspendido", fecha_cierre, "El proyecto no se ha cerrado") AS fecha_cierre')
        ->selectRaw('IF(areasconocimiento.nombre = "Otro", pp.otro_areaconocimiento, "No aplica") AS otro_areaconocimiento')
        ->selectRaw('IF(pp.fabrica_productividad = 0, "No", "Si") AS fabrica_productividad')
        ->selectRaw('IF(pp.reci_ar_emp = 0, "No", "Si") AS reci_ar_emp')
        ->selectRaw('IF(pp.economia_naranja = 0, "No", "Si") AS economia_naranja')
        ->selectRaw('IF(pp.economia_naranja = 0, "No aplica", pp.tipo_economianaranja) AS tipo_economianaranja')
        ->selectRaw('IF(pp.dirigido_discapacitados = 0, "No", "Si") AS dirigido_discapacitados')
        ->selectRaw('IF(pp.dirigido_discapacitados = 0, "No aplica", pp.tipo_discapacitados) AS tipo_discapacitados')
        ->selectRaw('IF(pp.art_cti = 0, "No", "Si") AS art_cti')
        ->selectRaw('IF(pp.art_cti = 0, "No aplica", pp.nom_act_cti) AS nom_act_cti')
        ->selectRaw('IF(fases.nombre = "Cierre", IF(pp.diri_ar_emp = 0, "No", "Si"), "El proyecto no se ha cerrado") AS diri_ar_emp')
        ->selectRaw('DATE_FORMAT(fecha_cierre, "%Y") AS anho')
        ->selectRaw('DATE_FORMAT(fecha_cierre, "%m") AS mes')
        ->join('entidades', 'entidades.id', '=', 'empresas.entidad_id')
        ->join('propietarios', 'propietarios.propietario_id', '=', 'empresas.id')
        ->join('proyectos', 'proyectos.id', '=', 'propietarios.proyecto_id')
        ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
        ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
        ->join('proyectos AS pp', 'pp.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
        ->join('fases', 'fases.id', '=', 'pp.fase_id')
        ->join('sectores', 'sectores.id', '=', 'empresas.sector_id')
        ->join('ciudades', 'ciudades.id', '=', 'entidades.ciudad_id')
        ->join('departamentos', 'departamentos.id', '=', 'ciudades.departamento_id')
        ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
        ->join('entidades AS entidad_nodo', 'entidad_nodo.id', '=', 'nodos.entidad_id')
        ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
        ->join('users', 'users.id', '=', 'gestores.user_id')
        ->join('sublineas', 'sublineas.id', '=', 'pp.sublinea_id')
        ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'sublineas.lineatecnologica_id')
        ->join('areasconocimiento', 'areasconocimiento.id', '=', 'pp.areaconocimiento_id')
        ->leftJoin('ideas', 'ideas.id', '=', 'pp.idea_id')
        ->leftJoin('tamanhos_empresas', 'tamanhos_empresas.id', '=', 'empresas.tamanhoempresa_id')
        ->leftJoin('tipos_empresas', 'tipos_empresas.id', '=', 'empresas.tipoempresa_id')
        ->where('entidades.nombre', '!=', 'No Aplica')
        ->where('propietarios.propietario_type', 'App\Models\Empresa')
        ->where(function($q) use ($fecha_inicio, $fecha_cierre) {
        $q->where(function($query) use ($fecha_inicio, $fecha_cierre) {
            $query->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_cierre]);
        })
        ->orWhere(function($query) use ($fecha_inicio, $fecha_cierre) {
            $query->where(function($query) use ($fecha_inicio, $fecha_cierre) {
            $query->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_cierre]);
            $query->orWhere(function ($query) {
            $query->whereIn('fases.nombre', ['Inicio', 'Planeación', 'Ejecución', 'Cierre']);
            });
        });
        });
        });
    }

    // Modifica los datos de una empresa
    public function update($request, $empresa)
    {
        DB::beginTransaction();
        try {
        $empresa->update([
            'sector_id' => $request->input('txtsector_empresa'),
            'tipoempresa_id' => $request->input('txttipoempresa_id_empresa'),
            'tamanhoempresa_id' => $request->input('txttamanhoempresa_id_empresa'),
            'nombre' => $request->input('txtnombre_empresa'),
            'email' => $request->input('txtemail_empresa'),
            'nit' => $request->input('txtnit_empresa'),
            'fecha_creacion' => $request->input('txtfecha_creacion_empresa'),
            'codigo_ciiu' => $request->input('txtcodigo_ciiu_empresa')
        ]);
        DB::commit();
        return [
            'state' => true,
            'msg' => 'Los datos de la empresa se han modificado exitosamente!',
            'title' => 'Modificación exitosa!',
            'type' => 'success'
        ];
        return $empresa;
        } catch (Exception $e) {
        DB::rollback();
        return [
            'state' => false,
            'msg' => 'Los datos de la empresa no se han modificado!',
            'title' => 'Modificación errónea!',
            'type' => 'error'
        ];
        }

    }

    // Modifica los datos de una sede
    public function updateSedes($request, $sede)
    {
        DB::beginTransaction();
        try {
        $sede->update([
            'ciudad_id' => $request->input('txtciudad_id_sede'),
            'nombre_sede' => $request->input('txtnombre_sede'),
            'direccion' => $request->input('txtdireccion_sede')
        ]);
        DB::commit();
        return [
            'state' => true,
            'msg' => 'Los datos de la sede se han modificado exitosamente!',
            'title' => 'Modificación exitosa!',
            'type' => 'success'
        ];
        } catch (Exception $e) {
        DB::rollback();
        return [
            'state' => false,
            'msg' => 'Los datos de la sede no se han modificado!',
            'title' => 'Modificación errónea!',
            'type' => 'error'
        ];
        }

    }

    public function storeSede($request, $empresa)
    {
        DB::beginTransaction();
        try {
        $empresa->sedes()->create([
            'ciudad_id' => $request->input('txtciudad_id_sede'),
            'nombre_sede' => $request->input('txtnombre_sede'),
            'direccion' => $request->input('txtdireccion_sede')
        ]);
        DB::commit();
        return [
            'state' => true,
            'msg' => 'Los datos de la sede se han registrado exitosamente!',
            'title' => 'Registro exitoso!',
            'type' => 'success'
        ];
        } catch (Exception $e) {
        DB::rollback();
        return [
            'state' => false,
            'msg' => 'Los datos de la sede no se han registrado!',
            'title' => 'Registro erróneo!',
            'type' => 'error'
        ];
        }
    }

    // Modifica los datos de una sede
    public function update_responsable($request, $empresa)
    {
        DB::beginTransaction();
        try {
        $user = null;
        if ($request->input('txttype_search') == 1) {
            $user = User::withTrashed()->where('documento', 'LIKE', "%" . $request->input('txtsearch_user') . "%")->first();
        } else {
            $user = User::withTrashed()->where('email', 'LIKE', "%" . $request->input('txtsearch_user') . "%")->first();
        }

        if ($user == null) {
            return [
                'state' => false,
                'msg' => 'El usuario no existe!',
                'title' => 'Modificación errónea!',
                'type' => 'error'
            ];
        }

        $empresa->update([
            'user_id' => $user->id
        ]);
        DB::commit();
        return [
            'state' => true,
            'msg' => 'El responsable de la empresa se ha modificado exitosamente!',
            'title' => 'Modificación exitosa!',
            'type' => 'success'
        ];
        } catch (Exception $e) {
        DB::rollback();
        return [
            'state' => false,
            'msg' => 'El responsable de la empresa no se ha modificado!',
            'title' => 'Modificación errónea!',
            'type' => 'error'
        ];
        }

    }

    // Registra una empresa en la base de datos
    public function store($request)
    {
        DB::beginTransaction();
        try {
        $user_id = null;
        if (Session::get('login_role') == User::IsTalento()) {
            $user_id = auth()->user()->id;
        }

        $empresa = Empresa::create([
            'sector_id' => $request->input('txtsector_empresa'),
            'user_id' => $user_id,
            'tipoempresa_id' => $request->input('txttipoempresa_id_empresa'),
            'tamanhoempresa_id' => $request->input('txttamanhoempresa_id_empresa'),
            'nombre' => $request->input('txtnombre_empresa'),
            'email' => $request->input('txtemail_empresa'),
            'nit' => $request->input('txtnit_empresa'),
            'fecha_creacion' => $request->input('txtfecha_creacion_empresa'),
            'codigo_ciiu' => $request->input('txtcodigo_ciiu_empresa')
        ]);

        $sede = Sede::create([
            'empresa_id' => $empresa->id,
            'ciudad_id' => $request->input('txtciudad_id_sede'),
            'nombre_sede' => $request->input('txtnombre_sede'),
            'direccion' => $request->input('txtdireccion_sede')
        ]);
        
        DB::commit();
        // return $empresa;
        return [
            'state' => true,
            'empresa' => $empresa,
            'sede' => $sede
        ];
        } catch (Exception $e) {
        DB::rollback();
        return [
            'state' => false,
            'empresa' => null,
            'sede' => null
        ];
        }

    }

    // Consulta las empresas de la red de tecnoparque
    public function consultarEmpresas()
    {
        return Empresa::select('nit',
        'empresas.id',
        'empresas.nombre AS nombre_empresa',
        'sectores.nombre AS sector_empresa')
        ->join('sectores', 'sectores.id', '=', 'empresas.sector_id')
        ->join('users', 'users.id', '=', 'empresas.user_id');
    }
    
    public function consultarSedeRepository($id)
    {
        return Sede::where('id', $id)->with('empresa', 'ciudad', 'ciudad.departamento');
    }

    public function consultarEmpresaParams(string $field, string $value)
    {
        return Empresa::where($value, $field)->with('sector', 'tipoempresa', 'tamanhoempresa', 'sedes', 'sedes.ciudad', 'sedes.ciudad.departamento');
    }

    /**
        * Consulta los detalles de una empresa
        * @param $param Valor del parámetro por el que se va a filtrar
        * @param $field Nombre del campo por el que se va a filtrar
        * @return Builder
        * @author dum
        */
    public function consultarDetallesDeUnaEmpresa($id)
    {
        return Empresa::find($id);
    }

}
