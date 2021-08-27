<?php

namespace App\Repositories\Repository\UserRepository;

use App\Models\{
    ActivationToken,
    Centro,
    Ciudad,
    Departamento,
    Dinamizador,
    Entidad,
    Eps,
    Gestor,
    TipoTalento,
    GradoEscolaridad,
    GrupoSanguineo,
    Infocenter,
    Ingreso,
    Nodo,
    Ocupacion,
    Regional,
    Talento,
    TipoDocumento,
    UserNodo
};
use App\User;
use Cache;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Session;
use Spatie\Permission\Models\Role;
class UserRepository
{

    public function getAllTipoDocumento()
    {
        return TipoDocumento::allTipoDocumento()->get();
    }

    public function getAllNodos()
    {
        return Nodo::selectNodo()->pluck('nodos', 'id');
    }

    public function getAllDepartamentos()
    {
        return Departamento::allDepartamentos()->get();
    }

    public function getAllCiudades()
    {
        return Ciudad::all();
    }

    public function getAllCiudadDepartamento($departamento)
    {
        return Ciudad::allCiudadDepartamento($departamento)->get();
    }

    public function getSelectAllGradosEscolaridad()
    {
        return GradoEscolaridad::allGradosEscolaridad()->orderby('gradosescolaridad.nombre')->get();
    }

    public function getAllGrupoSanguineos()
    {
        return GrupoSanguineo::allGrupoSanguineos('gruposanguineos.nombre')->get();
    }

    public function getAllEpsActivas()
    {
        return Eps::allEps(Eps::IsActive(), 'eps.nombre')->get();
    }

    public function activationToken($user)
    {
        return ActivationToken::create([
            'user_id'    => $user,
            'token'      => str_random(60),
            'created_at' => Carbon::now(),
        ]);
    }

    public function getAllOcupaciones()
    {
        return Ocupacion::allOcupaciones()->pluck('nombre', 'id');
    }

    public function findById($id)
    {
        return User::with(
            [
                'tipodocumento' => function ($query) {
                    $query->select('id', 'nombre');
                },
                'roles'         => function ($query) {
                    $query->select('id', 'name');
                },
                'ocupaciones',
                'eps',
                'gradoescolaridad',
                'gruposanguineo',
                'ciudad',
                'ciudad.departamento',
                'ciudadexpedicion.departamento',
                'dinamizador',
                'dinamizador.nodo',
                'dinamizador.nodo.entidad',
                'gestor',
                'gestor.nodo',
                'gestor.nodo.entidad',
                'gestor.nodo.centro',
                'gestor.nodo.centro.regional',
                'gestor.nodo.centro.entidad',
                'gestor.lineatecnologica',
                'infocenter',
                'infocenter.nodo',
                'infocenter.nodo.entidad',
                'talento',
                'talento.entidad',
                'ingreso.nodo.entidad',
            ]
        )->findOrFail($id);
    }


    public function findUserByDocument($document)
    {
        return User::with(
            [
                'tipodocumento' => function ($query) {
                    $query->select('id', 'nombre');
                },
                'roles'         => function ($query) {
                    $query->select('id', 'name');
                },
                'ocupaciones',
                'eps',
                'gradoescolaridad',
                'gruposanguineo',
                'ciudad',
                'ciudad.departamento',
                'ciudadexpedicion.departamento',
                'dinamizador',
                'dinamizador.nodo',
                'dinamizador.nodo.entidad',
                'gestor',
                'gestor.nodo',
                'gestor.nodo.entidad',
                'gestor.nodo.centro',
                'gestor.nodo.centro.regional',
                'gestor.nodo.centro.entidad',
                'gestor.lineatecnologica',
                'infocenter',
                'infocenter.nodo',
                'infocenter.nodo.entidad',
                'talento',

                'talento.entidad',
                'ingreso.nodo.entidad',
            ]
        )->withTrashed()->where('documento', $document);
    }

    public function account($id)
    {
        return User::with(['tipodocumento', 'grupoSanguineo', 'eps', 'ciudad', 'ciudad.departamento', 'ocupaciones', 'gradoescolaridad', 'talento', 'dinamizador', 'roles', 'dinamizador.nodo', 'dinamizador.nodo.entidad', 'gestor.nodo', 'gestor.nodo.entidad', 'gestor.lineatecnologica', 'infocenter', 'infocenter.nodo', 'infocenter.nodo.entidad'])->withTrashed()->where('id', $id)->firstOrFail();
    }

    public function getAllRoles()
    {
        return Role::whereNotIn('name', [User::IsDesarrollador()])->orderby('name')->pluck('name', 'id');
    }

    public function getRoleWhereNotInRole(array $role)
    {
        return Role::whereNotIn('name', $role)->orderby('name')->pluck('name', 'id');
    }


    public function getRoleWhereInRole(array $role)
    {

        return Role::whereIn('name', $role)->pluck('name', 'id');
    }

    public function getAllNodo()
    {
        return Nodo::selectNodo()->orderby('entidades.nombre')->pluck('nodos', 'id');
    }

    public function getAllNodoPrueba()
    {
        return Nodo::selectNodo()->where('entidades.nombre', '!=', Nodo::NODO_PRUEBA)->orderby('entidades.nombre')->pluck('nodos', 'id');
    }


    public function getAllLineaNodo($nodo)
    {
        return Nodo::allLineasPorNodo($nodo);
    }

    public function getAllRegionales()
    {
        return Regional::allRegionales()->pluck('nombre', 'id');
    }

    public function Store($request, $password)
    {
        DB::beginTransaction();
        try {
            $user = $this->storeUser($request, $password);
            $user->ocupaciones()->sync($request->get('txtocupaciones'));
            if ($this->existRoleInArray($request, User::IsAdministrador())) {
                $this->assignRoleUser($user, config('laravelpermission.roles.roleAdministrador'));
            }
            if ($this->existRoleInArray($request, User::IsDinamizador())) {
                $this->exitOneDinamizadorForNodo($user, $request);
            }
            if ($this->existRoleInArray($request, User::IsGestor())) {
                $gestor = Gestor::create([
                    "user_id"             => $user->id,
                    "nodo_id"             => $request->input('txtnodogestor'),
                    "lineatecnologica_id" => $request->input('txtlinea'),
                    "honorarios"          => $request->input('txthonorario'),
                ]);
                $this->assignRoleUser($user, config('laravelpermission.roles.roleGestor'));
            }
            if ($this->existRoleInArray($request, User::IsInfocenter())) {
                Infocenter::create([
                    "user_id"   => $user->id,
                    "nodo_id"   => $request->input('txtnodoinfocenter'),
                    "extension" => $request->input('txtextension'),
                ]);
                $this->assignRoleUser($user, config('laravelpermission.roles.roleInfocenter'));
            }
            if ($this->existRoleInArray($request, User::IsTalento())) {
                $this->storeTalento($request, $user);
                $this->assignRoleUser($user, config('laravelpermission.roles.roleTalento'));
            }
            if ($this->existRoleInArray($request, User::IsIngreso())) {
                Ingreso::create([
                    "nodo_id" => $request->input('txtnodoingreso'),
                    "user_id" => $user->id,
                ]);
                $this->assignRoleUser($user, config('laravelpermission.roles.roleIngreso'));
            }
            if ($this->existRoleInArray($request, User::IsProveedor())) {
                $this->assignRoleUser($user, config('laravelpermission.roles.roleProveedor'));
            }
            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    private function storeUser($request, $password)
    {
        return User::create([
            "tipodocumento_id"     => $request->input('txttipo_documento'),
            "gradoescolaridad_id"  => $request->input('txtgrado_escolaridad'),
            "gruposanguineo_id"    => $request->input('txtgruposanguineo'),
            "eps_id"               => $request->input('txteps'),
            "ciudad_id"            => $request->input('txtciudad'),
            "ciudad_expedicion_id" => $request->input('txtciudadexpedicion'),
            "nombres"              => $request->input('txtnombres'),
            "apellidos"            => $request->input('txtapellidos'),
            "documento"            => $request->input('txtdocumento'),
            "email"                => $request->input('txtemail'),
            "barrio"               => $request->input('txtbarrio'),
            "direccion"            => $request->input('txtdireccion'),
            "etnia_id"               => $request->input('txtetnias'),
            "grado_discapacidad"    => $request->input('txtgrado_discapacidad'),
            "descripcion_grado_discapacidad"    => $request->input('txtdiscapacidad'),
            "celular"              => $request->input('txtcelular'),
            "telefono"             => $request->input('txttelefono'),
            "fechanacimiento"      => $request->input('txtfecha_nacimiento'),
            "genero"               => $request->input('txtgenero') == 'on' ? $request['txtgenero'] = 0 : $request['txtgenero'] = 1,
            "otra_eps"             => $request->input('txteps') == Eps::where('nombre', Eps::OTRA_EPS)->first()->id ? $request->input('txtotraeps') : null,
            "estado"               => User::IsActive(),
            "institucion"          => $request->input('txtinstitucion'),
            "titulo_obtenido"      => $request->get('txttitulo'),
            "fecha_terminacion"    => $request->get('txtfechaterminacion'),
            "password"             => $password,
            "estrato"              => $request->input('txtestrato'),
            "otra_ocupacion"       => collect($request->input('txtocupaciones'))->contains(Ocupacion::where('nombre', Ocupacion::IsOtraOcupacion())->first()->id) ? $request->input('txtotra_ocupacion') : null,
        ]);
    }

    private function assignRoleUser($user, $role)
    {
        return $user->assignRole($role);
    }

    protected function storeTalento($request, $user)
    {
        $entidad = null;

        if (
            $request->get('txttipotalento') == TipoTalento::where('nombre', TipoTalento::IS_APRENDIZ_SENA_SIN_APOYO)->first()->id ||
            $request->get('txttipotalento') == TipoTalento::where('nombre', TipoTalento::IS_APRENDIZ_SENA_CON_APOYO)->first()->id
        ) {
            $entidad = $request->input('txtcentroformacion_aprendiz') ?: $this->getIdNoAplicaEntidad();
        } else if (
            $request->get('txttipotalento') == TipoTalento::where('nombre', TipoTalento::IS_EGRESADO_SENA)->first()->id
        ) {
            $entidad = $request->input('txtcentroformacion_egresado') ?: $this->getIdNoAplicaEntidad();
        } else if (
            $request->get('txttipotalento') == TipoTalento::where('nombre', TipoTalento::IS_FUNCIONARIO_SENA)->first()->id
        ) {
            $entidad = $request->input('txtcentroformacion_funcionarioSena') ?: $this->getIdNoAplicaEntidad();
        } else if (
            $request->get('txttipotalento') == TipoTalento::where('nombre', TipoTalento::IS_INSTRUCTOR_SENA)->first()->id
        ) {
            $entidad = $request->input('txtcentroformacion_instructorSena') ?: $this->getIdNoAplicaEntidad();
        } else {
            $entidad = $this->getIdNoAplicaEntidad();
        }
        return Talento::create([
            "user_id"               => $user->id,
            "tipo_talento_id"       => $request->input('txttipotalento'),
            "entidad_id"            => $entidad,

            "programa_formacion"    => $request->get('txtprogramaformacion') == $this->getIdTipoTalentoForNombre(TipoTalento::IS_APRENDIZ_SENA_CON_APOYO) ? $request->input('txtprogramaformacion_aprendiz') :
                (
                    $request->get('txttipotalento') == $this->getIdTipoTalentoForNombre(TipoTalento::IS_APRENDIZ_SENA_SIN_APOYO) ? $request->input('txtprogramaformacion_aprendiz') :
                    (
                        $request->get('txttipotalento') == $this->getIdTipoTalentoForNombre(TipoTalento::IS_EGRESADO_SENA) ? $request->input('txtprogramaformacion_egresado') : null
                    )
                ),
            "tipo_formacion_id"    => $request->get('txttipotalento') == $this->getIdTipoTalentoForNombre(TipoTalento::IS_EGRESADO_SENA) ? $request->input('txttipoformacion') : null,
            "tipo_estudio_id"    => $request->get('txttipotalento') == $this->getIdTipoTalentoForNombre(TipoTalento::IS_ESTUDIANTE_UNIVERSITARIO) ? $request->input('txttipoestudio') : null,
            "dependencia"    => $request->get('txttipotalento') == $this->getIdTipoTalentoForNombre(TipoTalento::IS_FUNCIONARIO_SENA) ? $request->input('txtdependencia') : null,
            "universidad"           => $request->get('txttipotalento') == $this->getIdTipoTalentoForNombre(TipoTalento::IS_ESTUDIANTE_UNIVERSITARIO) ? $request->input('txtuniversidad') : null,
            "carrera_universitaria" => $request->get('txttipotalento') == $this->getIdTipoTalentoForNombre(TipoTalento::IS_ESTUDIANTE_UNIVERSITARIO) ? $request->input('txtcarrera') : null,
            "empresa"               => $request->get('txttipotalento') == $this->getIdTipoTalentoForNombre(TipoTalento::IS_FUNCIONARIO_EMPRESA) ? $request->input('txtempresa') : null,

        ]);
    }

    /*===============================================================================
    =            metodo para consultar el id del grupo de investigacion (table entidad)            =
    ===============================================================================*/
    private function getIdGrupoInvesitgacion($request)
    {
        return Entidad::select('entidades.id')->join('gruposinvestigacion', 'gruposinvestigacion.entidad_id', 'entidades.id')
            ->where('entidades.nombre', $request->get('txtgrupoinvestigacion'))
            ->first()->id;
    }

    /*=====  End of metodo para consultar el id del grupo de investigacion (table entidad)  ======*/

    /*====================================================================================
    =            metodo para consultar el id de no aplica en la tabla entidad            =
    ====================================================================================*/
    protected function getIdNoAplicaEntidad()
    {
        return Entidad::where('nombre', 'No Aplica')->first()->id;
    }

    /*=====  End of metodo para consultar el id de no aplica en la tabla entidad  ======*/

    public function getIdTipoTalentoForNombre(string $tipotalento)
    {
        return TipoTalento::where('nombre', $tipotalento)->first()->id;
    }

    public function Update($request, $user)
    {
        DB::beginTransaction();
        try {
            $userUpdated = $this->updateUser($request, $user);
            $userUpdated->ocupaciones()->sync($request->get('txtocupaciones'));
            $userUpdate = $this->SyncInfoRolesUser($request, $userUpdated);
            DB::commit();
            return $userUpdate;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }


    /*==========================================================================
    =            metodo para preguntar si existe el rol en el array            =
    ==========================================================================*/

    private function existRoleInArray($request, $role)
    {
        if ($request->filled('role')) {
            if (collect($request->input('role'))->contains($role)) {
                return true;
            }
            return false;
        }
    }

    /*=====  End of metodo para preguntar si existe el rol en el array  ======*/

    /**
     * undocumented function
     * metodo para comprobar comprobar que el no exista en array
     *
     * @author julian londo���o
     **/
    private function notExistRoleInArray($request, $userUpdated, $role)
    {
        if ($request->filled('role')) {
            if (!collect($userUpdated->getRoleNames())->contains($role)) {
                return true;
            }
            return false;
        }
    }

    /*===================================================================================================
    =            metodo para cononcer si el nuevo rol esta asignado a un usuario determinado            =
    ===================================================================================================*/

    private function roleIsAssigned($newRole, $role)
    {
        return collect($newRole)->contains($role);
    }

    /*=====  End of metodo para cononcer si el nuevo rol esta asignado a un usuario determinado  ======*/

    /*==============================================================================================
    =            metodo privado para actualizar un usuario y se llamdo en $this->Update            =
    ==============================================================================================*/

    private function updateUser($request, $user)
    {
        $user->update([
            "tipodocumento_id"     => $request->input('txttipo_documento'),
            "gradoescolaridad_id"  => $request->input('txtgrado_escolaridad'),
            "gruposanguineo_id"    => $request->input('txtgruposanguineo'),
            "eps_id"               => $request->input('txteps'),
            "ciudad_id"            => $request->input('txtciudad'),
            "ciudad_expedicion_id" => $request->input('txtciudadexpedicion'),
            "nombres"              => $request->input('txtnombres'),
            "apellidos"            => $request->input('txtapellidos'),
            "documento"            => $request->input('txtdocumento'),
            "email"                => $request->input('txtemail'),
            "barrio"               => $request->input('txtbarrio'),
            "direccion"            => $request->input('txtdireccion'),
            "etnia_id"               => $request->input('txtetnias'),
            "grado_discapacidad"    => $request->input('txtgrado_discapacidad'),
            "descripcion_grado_discapacidad"    => $request->input('txtgrado_discapacidad') == 1 ? $request['txtdiscapacidad'] : null,
            "celular"              => $request->input('txtcelular'),
            "telefono"             => $request->input('txttelefono'),
            "fechanacimiento"      => $request->input('txtfecha_nacimiento'),
            "genero"               => $request->input('txtgenero') == 'on' ? $request['txtgenero'] = 0 : $request['txtgenero'] = 1,
            "otra_eps"             => $request->input('txteps') == Eps::where('nombre', Eps::OTRA_EPS)->first()->id ? $request->input('txtotraeps') : null,
            "institucion"          => $request->input('txtinstitucion'),
            "titulo_obtenido"      => $request->get('txttitulo'),
            "fecha_terminacion"    => $request->get('txtfechaterminacion'),
            "estrato"              => $request->input('txtestrato'),
            "otra_ocupacion"       => collect($request->input('txtocupaciones'))->contains(Ocupacion::where('nombre', Ocupacion::IsOtraOcupacion())->first()->id) ? $request->input('txtotra_ocupacion') : null,
        ]);

        return $user;
    }

    /*=====  End of metodo privado para actualizar un usuario y se llamdo en Update  ======*/

    /*=================================================================
    =            metodo para actualizar un usuario talento            =
    =================================================================*/
    public function updateTalento($request, $userUpdated)
    {
        $entidad = null;

        if (
            $request->get('txttipotalento') == TipoTalento::where('nombre', TipoTalento::IS_APRENDIZ_SENA_SIN_APOYO)->first()->id ||
            $request->get('txttipotalento') == TipoTalento::where('nombre', TipoTalento::IS_APRENDIZ_SENA_CON_APOYO)->first()->id
        ) {
            $entidad = $request->input('txtcentroformacion_aprendiz') ?: $this->getIdNoAplicaEntidad();
        } else if (
            $request->get('txttipotalento') == TipoTalento::where('nombre', TipoTalento::IS_EGRESADO_SENA)->first()->id
        ) {
            $entidad = $request->input('txtcentroformacion_egresado') ?: $this->getIdNoAplicaEntidad();
        } else if (
            $request->get('txttipotalento') == TipoTalento::where('nombre', TipoTalento::IS_FUNCIONARIO_SENA)->first()->id
        ) {
            $entidad = $request->input('txtcentroformacion_funcionarioSena') ?: $this->getIdNoAplicaEntidad();
        } else if (
            $request->get('txttipotalento') == TipoTalento::where('nombre', TipoTalento::IS_INSTRUCTOR_SENA)->first()->id
        ) {
            $entidad = $request->input('txtcentroformacion_instructorSena') ?: $this->getIdNoAplicaEntidad();
        } else {
            $entidad = $this->getIdNoAplicaEntidad();
        }


        if (
            $request->get('txttipotalento') == $this->getIdTipoTalentoForNombre(TipoTalento::IS_APRENDIZ_SENA_CON_APOYO) ||
            $request->get('txttipotalento') == $this->getIdTipoTalentoForNombre(TipoTalento::IS_APRENDIZ_SENA_SIN_APOYO)
        ) {
            $programa = $request->input('txtprogramaformacion_aprendiz');
        } elseif ($request->get('txttipotalento') == $this->getIdTipoTalentoForNombre(TipoTalento::IS_EGRESADO_SENA)) {
            $programa = $request->input('txtprogramaformacion_egresado');
        } else {
            $programa = 'No Aplica';
        }
        return Talento::find($userUpdated->talento->id)->update([

            "tipo_talento_id"       => $request->input('txttipotalento'),
            "entidad_id"            => $entidad,

            "programa_formacion"    =>  $programa,

            "tipo_formacion_id"    => $request->get('txttipotalento') == $this->getIdTipoTalentoForNombre(TipoTalento::IS_EGRESADO_SENA) ?
                $request->input('txttipoformacion') : null,

            "tipo_estudio_id"    => $request->get('txttipotalento') == $this->getIdTipoTalentoForNombre(TipoTalento::IS_ESTUDIANTE_UNIVERSITARIO) ?
                $request->input('txttipoestudio') : null,
            "dependencia"    => $request->get('txttipotalento') == $this->getIdTipoTalentoForNombre(TipoTalento::IS_FUNCIONARIO_SENA) ?
                $request->input('txtdependencia') : null,


            "universidad"           => $request->get('txttipotalento') == $this->getIdTipoTalentoForNombre(TipoTalento::IS_ESTUDIANTE_UNIVERSITARIO) ?
                $request->input('txtuniversidad') : null,


            "carrera_universitaria" => $request->get('txttipotalento') == $this->getIdTipoTalentoForNombre(TipoTalento::IS_ESTUDIANTE_UNIVERSITARIO) ?
                $request->input('txtcarrera') : null,

            "empresa"               => $request->get('txttipotalento') == $this->getIdTipoTalentoForNombre(TipoTalento::IS_FUNCIONARIO_EMPRESA) ?
                $request->input('txtempresa') : null,
        ]);
    }

    /*=====  End of metodo para actualizar un usuario talento  ======*/


    /*===========================================================
    =            metodo para consultar las entidades(centros) por centro            =
    ===========================================================*/

    private function getIdEntidadCentro(int $centro)
    {
        return Centro::select('entidades.id')
            ->join('entidades', 'entidades.id', '=', 'centros.entidad_id')
            ->where('centros.id', $centro)
            ->get()
            ->last()->id;
    }

    /*=====  End of metodo para consultar las entidades(centros) por centro  ======*/

    /*===========================================================================
    =            metodo para destruir la session y cache del usuario            =
    ===========================================================================*/

    public function destroySessionUser()
    {
        Session::flush();
        Cache::flush();
    }

    /*=====  End of metodo para destruir la session y cache del usuario  ======*/

    /*===========================================================
    =            metodo para buscar usuarios por rol            =
    ===========================================================*/

    public function getAllUsersForRole(string $role)
    {
        return User::InfoUserDatatable()
            ->role($role)
            ->orderby('users.created_at', 'desc')
            ->get();
    }

    /*=====  End of metodo para buscar usuarios por rol  ======*/

    /*============================================================================
    =            metodo para mostrar todos los usuarios en datatables            =
    ============================================================================*/

    public function getAllUsersForDatatables()
    {
        return User::InfoUserDatatable()->with(['roles' => function ($query) {
            $query->select('name');
        }])
        ->orderby('users.created_at', 'desc')
        ->get();
    }

    /*=====  End of metodo para mostrar todos los usuarios en datatables  ======*/

    /*==========================================================================
    =            metodo para validar que solo exista un dinamizador por nodo            =
    ==========================================================================*/

    private function exitOneDinamizadorForNodo($user, $request, $method = 'store')
    {
        $userdinamizador = User::with('dinamizador.nodo')->whereHas('dinamizador.nodo', function ($query) use ($request) {
            $query->where('id', $request->txtnododinamizador);
        })->get();

        if ($userdinamizador->count() >= Dinamizador::cantidadDinamizadoresPermitidosPornodo()) {
            $userdinamizador->each(function ($item) {
                if ($item->hasRole(User::IsDinamizador()) && $item->roles->count() == 1) {

                    $item->update([
                        'estado' => User::IsInactive(),
                    ]);
                }
                $item->dinamizador->delete();
                $item->removeRole(config('laravelpermission.roles.roleDinamizador'));
            });
        }
        if ($method == 'store') {
            Dinamizador::create([
                "user_id" => $user->id,
                "nodo_id" => $request->input('txtnododinamizador'),
            ]);
            $this->assignRoleUser($user, config('laravelpermission.roles.roleDinamizador'));
        }
    }

    /*=====  End of metodo para validar que solo exista un dinamizador por nodo  ======*/

    public function userInfoWithRelations(array $role = [], array $relations = [])
    {
        return User::infoUserRole($role, $relations);
    }


    public function getUsersTalentosByProject($nodo = null, $user = null, $anio = null)
    {

        if ($user != null && session()->get('login_role') == User::IsGestor()) {

            if ($nodo == null) {
                return $this->getInfoUsersTalentosWithProjects($anio)
                    ->where('gestores.id', $user);
            }
            $nodo = auth()->user()->gestor->nodo_id;
            return $this->getInfoUsersTalentosWithProjects($anio)
                ->where('nodos.id', $nodo)
                ->where('gestores.id', $user);
        } else if ($user == null && session()->get('login_role') == User::IsGestor()) {
            $user = auth()->user()->gestor->id;
            if ($nodo == null) {
                $this->getInfoUsersTalentosWithProjects($anio);
            }
            $nodo = auth()->user()->gestor->nodo_id;
            return $this->getInfoUsersTalentosWithProjects($anio)
                ->where('nodos.id', $nodo)
                ->where('gestores.id', $user);
        } else if ($user == null && session()->get('login_role') == User::IsDinamizador()) {

            if ($nodo == null) {
                $this->getInfoUsersTalentosWithProjects($anio);
            }
            $nodo = auth()->user()->dinamizador->nodo_id;
            return $this->getInfoUsersTalentosWithProjects($anio)
                ->where('nodos.id', $nodo);
        } else if ($user != null && session()->get('login_role') == User::IsDinamizador()) {
            if ($nodo == null) {
                $this->getInfoUsersTalentosWithProjects($anio)
                    ->where('gestores.id', $user);
            }
            $nodo = auth()->user()->dinamizador->nodo_id;
            return $this->getInfoUsersTalentosWithProjects($anio)
                ->where('nodos.id', $nodo)
                ->where('gestores.id', $user);
        } else if ($user == null && session()->get('login_role') == User::IsAdministrador()) {
            if ($nodo == null) {
                $this->getInfoUsersTalentosWithProjects($anio);
            }
            return $this->getInfoUsersTalentosWithProjects($anio)
                ->where('nodos.id', $nodo);
        } else if ($user == null && session()->get('login_role') == User::IsInfocenter()) {
            if ($nodo == null) {
                $this->getInfoUsersTalentosWithProjects($anio);
            }
            $nodo = auth()->user()->infocenter->nodo_id;
            return $this->getInfoUsersTalentosWithProjects($anio)
                ->where('nodos.id', $nodo);
        } else if ($user != null && session()->get('login_role') == User::IsInfocenter()) {
            if ($nodo == null) {
                $this->getInfoUsersTalentosWithProjects($anio)
                    ->where('gestores.id', $user);
            }
            $nodo = auth()->user()->infocenter->nodo_id;
            return $this->getInfoUsersTalentosWithProjects($anio)
                ->where('nodos.id', $nodo)
                ->where('gestores.id', $user);
        }
    }

    private function getInfoUsersTalentosWithProjects($anio = null)
    {
        if ($anio == null) {
            return User::select(
                'users.id',
                'tiposdocumentos.nombre as tipodocumento',
                'users.documento',
                'users.email',
                'users.direccion',
                'users.celular',
                'users.telefono',
                'users.barrio',
                'users.estado',
                'users.genero',
                'users.institucion',
                'users.titulo_obtenido',
                'users.fecha_terminacion',
                'users.estrato',
                'users.otra_eps',
                'users.otra_ocupacion',
                'users.grado_discapacidad',
                'users.descripcion_grado_discapacidad',
                'users.fechanacimiento',
                'tipo_talentos.nombre as tipotalento',
                'etnias.nombre as etnia',
                'gruposanguineos.nombre as grupo_sanguineo',
                'gradosescolaridad.nombre as grado_escolaridad',
                'eps.nombre as eps'
            )
                ->selectRaw("CONCAT(users.nombres,' ',users.apellidos) as nombre")
                ->selectRaw("CONCAT(ciudades.nombre,' - ',departamentos.nombre) as residencia")
                ->join('tiposdocumentos', 'tiposdocumentos.id', '=', 'users.tipodocumento_id')
                ->join('ciudades', 'ciudades.id', '=', 'users.ciudad_id')
                ->join('departamentos', 'departamentos.id', '=', 'ciudades.departamento_id')
                ->join('gruposanguineos', 'gruposanguineos.id', 'users.gruposanguineo_id')
                ->join('gradosescolaridad', 'gradosescolaridad.id', 'users.gradoescolaridad_id')
                ->join('talentos', 'talentos.user_id', '=', 'users.id')
                ->join('eps', 'eps.id', 'users.eps_id')
                ->join('tipo_talentos', 'tipo_talentos.id', '=', 'talentos.tipo_talento_id')
                ->leftjoin('etnias', 'etnias.id', 'users.etnia_id')
                ->join('articulacion_proyecto_talento', 'articulacion_proyecto_talento.talento_id', '=', 'talentos.id')
                ->join('articulacion_proyecto', 'articulacion_proyecto_talento.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
                ->join('proyectos', 'proyectos.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
                ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
                ->join('gestores', 'gestores.id', '=', 'proyectos.asesor_id')
                ->join('nodos', 'nodos.id', '=', 'proyectos.nodo_id')
                ->groupBy('users.documento');
        }
        return User::select(
            'users.id',
            'tiposdocumentos.nombre as tipodocumento',
            'users.documento',
            'users.email',
            'users.direccion',
            'users.celular',
            'users.telefono',
            'users.barrio',
            'users.estado',
            'users.genero',
            'users.institucion',
            'users.titulo_obtenido',
            'users.fecha_terminacion',
            'users.estrato',
            'users.otra_eps',
            'users.otra_ocupacion',
            'users.grado_discapacidad',
            'users.descripcion_grado_discapacidad',
            'users.fechanacimiento',
            'tipo_talentos.nombre as tipotalento',
            'etnias.nombre as etnia',
            'gruposanguineos.nombre as grupo_sanguineo',
            'gradosescolaridad.nombre as grado_escolaridad',
            'eps.nombre as eps'
        )
            ->selectRaw("CONCAT(users.nombres,' ',users.apellidos) as nombre")
            ->selectRaw("CONCAT(ciudades.nombre,' - ',departamentos.nombre) as residencia")
            ->join('tiposdocumentos', 'tiposdocumentos.id', '=', 'users.tipodocumento_id')
            ->join('ciudades', 'ciudades.id', '=', 'users.ciudad_id')
            ->join('departamentos', 'departamentos.id', '=', 'ciudades.departamento_id')
            ->join('gruposanguineos', 'gruposanguineos.id', 'users.gruposanguineo_id')
            ->join('gradosescolaridad', 'gradosescolaridad.id', 'users.gradoescolaridad_id')
            ->join('talentos', 'talentos.user_id', '=', 'users.id')
            ->join('eps', 'eps.id', 'users.eps_id')
            ->join('tipo_talentos', 'tipo_talentos.id', '=', 'talentos.tipo_talento_id')
            ->leftjoin('etnias', 'etnias.id', 'users.etnia_id')
            ->join('articulacion_proyecto_talento', 'articulacion_proyecto_talento.talento_id', '=', 'talentos.id')
            ->join('articulacion_proyecto', 'articulacion_proyecto_talento.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
            ->join('proyectos', 'proyectos.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
            ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
            ->join('gestores', 'gestores.id', '=', 'proyectos.asesor_id')
            ->join('nodos', 'nodos.id', '=', 'proyectos.nodo_id')
            ->where(function ($q) use ($anio) {
                $q->where(function ($query) use ($anio) {
                    $query->whereYear('fecha_cierre', $anio);
                })
                    ->orWhere(function ($query) use ($anio) {
                        $query->whereYear('fecha_inicio', $anio);
                    });
            })
            ->orderBy('nombres');
    }

    public function UpdateUserConfirm($request, $user)
    {
        DB::beginTransaction();
        try {
            $userUpdate = $this->SyncInfoRolesUser($request, $user);

            $userUpdate->update([
                'estado' => User::IsActive(),
            ]);
            DB::commit();
            return $userUpdate;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    private function SyncInfoRolesUser($request, $userUpdated)
    {

        $newRole = array_diff($request->input('role'), collect($userUpdated->getRoleNames())->toArray());

        $removeRole = array_diff(collect($userUpdated->getRoleNames())->toArray(), $request->input('role'));

        $this->removeInfoTableToRole($userUpdated, $removeRole);

        $this->assigInformationNewApoyoTecnico($request, $userUpdated, $newRole);

        $this->assigInformationNewArticulador($request, $userUpdated, $newRole);

        $this->assigInformationNewDinamizador($request, $userUpdated, $newRole, User::IsDinamizador());

        $this->assigInformationNewGestor($request, $userUpdated, $newRole);

        $this->assigInformationNewInfocenter($request, $userUpdated, $newRole);

        $this->assigInformationNewTalent($request, $userUpdated, $newRole);

        $this->assigInformationNewIngreso($request, $userUpdated, $newRole);

        //update

        $this->updateInfoRemoveApoyoTecnico($request, $userUpdated, $removeRole);
        $this->updateInfoRemoveArticulador($request, $userUpdated, $removeRole);

        $this->updateInfoRemoveDinamizador($request, $userUpdated, $removeRole);

        $this->updateInfoRemoveGestor($request, $userUpdated, $removeRole);

        $this->updateInfoRemoveInfocenter($request, $userUpdated, $removeRole);

        $this->updateInfoRemoveTalento($request, $userUpdated, $removeRole);

        $this->updateInfoRemoveIngreso($request, $userUpdated, $removeRole);

        $userUpdated->syncRoles($request->role);

        return $userUpdated;
    }

    public function getArticuladorForNode($node)
    {
        return User::select('users.id')
            ->selectRaw('CONCAT(users.nombres, " ", users.apellidos) AS articulador')
            ->join('user_nodo', 'user_nodo.user_id', '=', 'users.id')
            ->join('nodos', 'nodos.id', '=', 'user_nodo.nodo_id')
            ->role(User::IsArticulador())
            ->where('nodos.id', $node);
    }



    /**
     * @author devjul
     * remove information in tables according to role
     * @return void
     */
    private function removeInfoTableToRole(User $userUpdated, array $removeRole)
    {
        if ($removeRole != null && $this->roleIsAssigned($removeRole, User::IsDinamizador()) && isset($userUpdated->dinamizador)) {
            Dinamizador::find($userUpdated->dinamizador->id)->delete();
        }

        if ($removeRole != null && $this->roleIsAssigned($removeRole, User::IsInfocenter()) && isset($userUpdated->infocenter)) {
            Infocenter::find($userUpdated->infocenter->id)->delete();
        }

        if ($removeRole != null && $this->roleIsAssigned($removeRole, User::IsIngreso()) && isset($userUpdated->ingreso)) {
            Ingreso::find($userUpdated->ingreso->id)->delete();
        }
    }

    /**
     * @author devjul
     * assign information to new dinamizador
     * @return void
     */
    private function assigInformationNewDinamizador($request, User $userUpdated, array $newRole, $role)
    {
        $userdinamizador = $this->queryDinamizadoresByNodo($request);

        if ($newRole != null && $this->roleIsAssigned($newRole, $role) && !isset($userUpdated->dinamizador) && $this->notExistRoleInArray($request, $userUpdated, $role)) {
            if ($userdinamizador !== null && $userdinamizador->count() >= Dinamizador::cantidadDinamizadoresPermitidosPornodo()) {
                $userdinamizador->each(function ($item) use($role) {
                    if ($item->hasRole($role) && $item->roles->count() == 1) {

                        $item->update([
                            'estado' => User::IsInactive(),
                        ]);
                    }
                    $item->dinamizador->delete();
                    $item->removeRole(config('laravelpermission.roles.roleDinamizador'));
                });
                Dinamizador::create([
                    "user_id" => $userUpdated->id,
                    "nodo_id" => $request->input('txtnododinamizador'),
                ]);
            } else {
                Dinamizador::create([
                    "user_id" => $userUpdated->id,
                    "nodo_id" => $request->input('txtnododinamizador'),
                ]);
            }
        }
    }

    /**
     * @author devjul
     * returns all the dynamizers of a node
     * @return
     */
    protected function queryDinamizadoresByNodo($request)
    {
        if ($request->filled('txtnododinamizador')) {
            return User::whereHas('dinamizador.nodo', function ($query) use ($request) {
                $query->where('id', $request->txtnododinamizador);
            })->get();
        }
        return null;
    }
    /**
     * @author devjul
     * assign information to new user apoyo tecnico
     * @return
     */
    private function assigInformationNewApoyoTecnico($request, $userUpdated, $newRole)
    {
        if ($newRole != null && $this->roleIsAssigned($newRole, User::IsApoyoTecnico()) && !isset($userUpdated->apoyotecnico) && $this->notExistRoleInArray($request, $userUpdated, User::IsApoyoTecnico())) {
            UserNodo::create([
                'user_id' => $userUpdated->id,
                'nodo_id' => $request->input('txtnodouser'),
                'role' => User::IsApoyoTecnico(),
                'honorarios' => $request->input('txthonorariouser'),
            ]);
        }
    }

    /**
     * @author devjul
     * assign information to new user articulador
     * @return
     */
    private function assigInformationNewArticulador($request, $userUpdated, $newRole)
    {
        if ($newRole != null && $this->roleIsAssigned($newRole, User::IsArticulador()) && !isset($userUpdated->articulador) && $this->notExistRoleInArray($request, $userUpdated, User::IsArticulador())) {
            UserNodo::create([
                'user_id' => $userUpdated->id,
                'nodo_id' => $request->input('txtnodoarticulador'),
                'role' => User::IsArticulador(),
                'honorarios' => $request->input('txthonorarioarticulador'),
            ]);
        }
    }

    /**
     * @author devjul
     * assign information to new experto
     * @return
     */
    private function assigInformationNewGestor($request, User $userUpdated, array $newRole)
    {
        if ($newRole != null && $this->roleIsAssigned($newRole, User::IsGestor()) && !isset($userUpdated->gestor) && $this->notExistRoleInArray($request, $userUpdated, User::IsGestor())) {
            Gestor::create([
                "user_id"             => $userUpdated->id,
                "nodo_id"             => $request->input('txtnodogestor'),
                "lineatecnologica_id" => $request->input('txtlinea'),
                "honorarios"          => $request->input('txthonorario'),
            ]);
        }
    }
    /**
     * @author devjul
     * assign information to new infocenter
     * @return
     */
    private function assigInformationNewInfocenter($request, User $userUpdated, array $newRole)
    {
        if ($newRole != null && $this->roleIsAssigned($newRole, User::IsInfocenter()) && !isset($userUpdated->infocenter) && $this->notExistRoleInArray($request, $userUpdated, User::IsInfocenter())) {
            Infocenter::create([
                "user_id"   => $userUpdated->id,
                "nodo_id"   => $request->input('txtnodoinfocenter'),
                "extension" => $request->input('txtextension'),
            ]);
        }
    }

    /**
     * @author devjul
     * assign information to new talent
     * @return
     */
    private function assigInformationNewTalent($request, User $userUpdated, array $newRole)
    {
        if ($newRole != null && $this->roleIsAssigned($newRole, User::IsTalento()) && !isset($userUpdated->talento) && $this->notExistRoleInArray($request, $userUpdated, User::IsTalento())) {
            $this->storeTalento($request, $userUpdated);
        }
    }

    /**
     * @author devjul
     * assign information to new ingreso
     * @return
     */
    private function assigInformationNewIngreso($request, User $userUpdated, array $newRole)
    {
        if ($newRole != null && $this->roleIsAssigned($newRole, User::IsIngreso()) && !isset($userUpdated->ingreso) && $this->notExistRoleInArray($request, $userUpdated, User::IsIngreso())) {
            Ingreso::create([
                "user_id" => $userUpdated->id,
                "nodo_id" => $request->input('txtnodoingreso'),
            ]);
        }
    }

    /**
     * @author devjul
     * update information to user dinamizador
     * @return void
     */
    private function updateInfoRemoveDinamizador($request, User $userUpdated, array $removeRole){
        $userdinamizador = $this->queryDinamizadoresByNodo($request);

        if (isset($userUpdated->dinamizador->id) && !$this->roleIsAssigned($removeRole, User::IsDinamizador())) {

            if ($userdinamizador !== null  && $userdinamizador->count() >= Dinamizador::cantidadDinamizadoresPermitidosPornodo() && $userUpdated->dinamizador->nodo->id == $request->input('txtnododinamizador')) {
                $userdinamizador->each(function ($item) {

                    if ($item->hasRole(User::IsDinamizador()) && $item->roles->count() == 1) {
                        $item->update([
                            'estado' => User::IsInactive(),
                        ]);
                    }
                    $item->dinamizador->delete();
                    $item->removeRole(config('laravelpermission.roles.roleDinamizador'));
                });

                Dinamizador::create([
                    "user_id" => $userUpdated->id,
                    "nodo_id" => $request->input('txtnododinamizador'),
                ]);
            }
        }
    }

    /**
     * @author devjul
     * update information to user experto
     * @return void
     */
    private function updateInfoRemoveGestor($request, User $userUpdated, array $removeRole){
        if (isset($userUpdated->gestor) && $this->roleIsAssigned($removeRole, User::IsGestor()) && $request->filled('txtnodogestor')) {

            Gestor::find($userUpdated->gestor->id)->update([
                "nodo_id"             => $request->input('txtnodogestor'),
                "lineatecnologica_id" => $request->input('txtlinea'),
                "honorarios"          => $request->input('txthonorario'),
            ]);
        } else if (isset($userUpdated->gestor) && !$this->roleIsAssigned($removeRole, User::IsGestor()) && $request->filled('txtnodogestor')) {

            Gestor::find($userUpdated->gestor->id)->update([
                "nodo_id"             => $request->input('txtnodogestor'),
                "lineatecnologica_id" => $request->input('txtlinea'),
                "honorarios"          => $request->input('txthonorario'),
            ]);
        }
    }

    /**
     * @author devjul
     * update information to user infocenter
     * @return void
     */
    private function updateInfoRemoveInfocenter($request, User $userUpdated, array $removeRole){
        if (isset($userUpdated->infocenter->id) && !$this->roleIsAssigned($removeRole, User::IsInfocenter()) && $request->filled('txtnodoinfocenter')) {

            Infocenter::find($userUpdated->infocenter->id)->update([
                "nodo_id"   => $request->input('txtnodoinfocenter'),
                "extension" => $request->input('txtextension'),
            ]);
        }
    }

    /**
     * @author devjul
     * update information to user talento
     * @return void
     */
    private function updateInfoRemoveTalento($request, User $userUpdated, array $removeRole){
        if (isset($userUpdated->talento) && !$this->roleIsAssigned($removeRole, User::IsTalento())) {
            $this->updateTalento($request, $userUpdated);
        }
    }

    /**
     * @author devjul
     * update information to user ingreso
     * @return void
     */
    private function updateInfoRemoveIngreso($request, User $userUpdated, array $removeRole){
        if (isset($userUpdated->ingreso) && !$this->roleIsAssigned($removeRole, User::IsIngreso()) && $request->filled('txtnodoingreso')) {
            Ingreso::find($userUpdated->ingreso->id)->update([
                "nodo_id" => $request->input('txtnodoingreso'),
            ]);
        }
    }

    /**
     * @author devjul
     * update information to user apoyo tecnico
     * @return void
     */
    private function updateInfoRemoveApoyoTecnico($request, User $userUpdated, array $removeRole){
        if (isset($userUpdated->apoyotecnico->id) && !$this->roleIsAssigned($removeRole, User::IsApoyoTecnico()) && $request->filled('txtnodouser')) {
            UserNodo::find($userUpdated->apoyotecnico->id)->update([
                'user_id' => $userUpdated->id,
                'nodo_id' => $request->input('txtnodouser'),
                'honorarios' => $request->input('txthonorariouser'),
            ]);
        }
    }

    /**
     * @author devjul
     * update information to user articulador
     * @return void
     */
    private function updateInfoRemoveArticulador($request, User $userUpdated, array $removeRole){
        if (isset($userUpdated->articulador->id) && !$this->roleIsAssigned($removeRole, User::IsArticulador()) && $request->filled('txtnodoarticulador')) {
            UserNodo::find($userUpdated->articulador->id)->update([
                'user_id' => $userUpdated->id,
                'nodo_id' => $request->input('txtnodoarticulador'),
                'honorarios' => $request->input('txthonorarioarticulador'),
            ]);
        }
    }

    public function exportarUsersAJson()
    {
        return User::with(
            [
                'tipodocumento' => function ($query) {
                    $query->select('id', 'nombre');
                },
                'roles' => function ($query) {
                    $query->select('id', 'name');
                },
                'ocupaciones',
                'eps' => function ($query)
                {
                    $query->select('id', 'nombre');
                },
                'gradoescolaridad' => function ($query)
                {
                    $query->select('id', 'nombre');
                },
                'gruposanguineo'  => function ($query)
                {
                    $query->select('id', 'nombre');
                },
                'ciudad.departamento'  => function ($query)
                {
                    $query->select('id', 'nombre');
                },
                'ciudadexpedicion.departamento'  => function ($query)
                {
                    $query->select('id', 'nombre');
                },
                'dinamizador',
                'dinamizador.nodo',
                'dinamizador.nodo.entidad',
                'articulador',
                'apoyotecnico',
                'gestor',
                'gestor.nodo',
                'gestor.nodo.entidad',
                'gestor.nodo.centro',
                'gestor.nodo.centro.regional',
                'gestor.nodo.centro.entidad',
                'gestor.lineatecnologica',
                'infocenter',
                'infocenter.nodo',
                'infocenter.nodo.entidad',
                'talento',
                'talento.entidad',
                'talento.tipotalento',
                'talento.tipoformacion',
                'talento.tipoestudio',
                'ingreso.nodo.entidad',
            ]
        )->withTrashed();


        // return User::select('tp.nombre AS tipodocumento', 'ge.nombre AS gradoescolaridad', 'gs.nombre AS gruposanguineo',
        // 'e.nombre AS eps', 'otra_eps', 'cr.nombre AS ciudad_residencia', 'dr.nombre AS departamento_residencia', 'ce.nombre AS ciudad_expedicion', 'de.nombre AS departamento_expedicion',
        // 'et.nombre AS etnia', 'nombres', 'apellidos', 'documento', 'email', 'email_verified_at', 'barrio', 'direccion', 'celular', 'telefono', 'fechanacimiento', 'genero', 'mujerCabezaFamilia',
        // 'desplazadoPorViolencia', 'grado_discapacidad', 'descripcion_grado_discapacidad', 'users.estado', 'institucion', 'titulo_obtenido', 'fecha_terminacion', 'remember_token', 'ultimo_login',
        // 'password', 'estrato', 'otra_ocupacion', 'users.created_at', 'users.updated_at', 'users.deleted_at')
        // ->join('tiposdocumentos as tp', 'tp.id', '=', 'users.tipodocumento_id')
        // ->join('gradosescolaridad as ge', 'ge.id', '=', 'users.gradoescolaridad_id')
        // ->join('gruposanguineos as gs', 'gs.id', '=', 'users.gruposanguineo_id')
        // ->join('eps as e', 'e.id', '=', 'users.eps_id')
        // ->join('ciudades as cr', 'cr.id', '=', 'users.ciudad_id')
        // ->join('departamentos as dr', 'dr.id', '=', 'cr.departamento_id')
        // ->join('ciudades as ce', 'ce.id', '=', 'users.ciudad_expedicion_id')
        // ->join('departamentos as de', 'de.id', '=', 'ce.departamento_id')
        // ->join('etnias as et', 'et.id', '=', 'users.etnia_id')
        // ;
    }

}
