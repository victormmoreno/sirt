<?php

namespace App\Repositories\Repository\UserRepository;

use App\Models\{
    ActivationToken,
    Honorario,
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
    Perfil,
    Regional,
    Talento,
    TipoDocumento
};

use App\User;
use Cache;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Session;
use Spatie\Permission\Models\Role;

class UserRepository
{
    /*===========================================================================
    =            metodo para consultar todos los tipos de documentos            =
    ===========================================================================*/

    public function getAllTipoDocumento()
    {
        return TipoDocumento::allTipoDocumento()->get();
    }

    /*=====  End of metodo para consultar todos los tipos de documentos  ======*/

    /*=============================================================
    =            metodo para consultar todos los nodos            =
    =============================================================*/

    public function getAllNodos()
    {
        return Nodo::selectNodo()->pluck('nodos', 'id');
    }

    /*=====  End of metodo para consultar todos los nodos  ======*/

    /*=====================================================================
    =            metodo para consultar todos los departamentos            =
    =====================================================================*/

    public function getAllDepartamentos()
    {
        return Departamento::allDepartamentos()->get();
    }

    /*=====  End of metodo para consultar todos los departamentos  ======*/

    /*=================================================================
    =            metodo para consultar todoas las ciudades            =
    =================================================================*/

    public function getAllCiudades()
    {
        return Ciudad::all();
    }

    /*=====  End of metodo para consultar todoas las ciudades  ======*/

    /*============================================================================
    =            metodo para consultar las ciudades por departmamento            =
    ============================================================================*/

    public function getAllCiudadDepartamento($departamento)
    {
        return Ciudad::allCiudadDepartamento($departamento)->get();
    }

    /*=====  End of metodo para consultar las ciudades por departmamento  ======*/

    /*=============================================================================
    =            metodo para consultar todos los grados de escolaridad            =
    =============================================================================*/

    public function getSelectAllGradosEscolaridad()
    {
        return GradoEscolaridad::allGradosEscolaridad()->orderby('gradosescolaridad.nombre')->get();
    }

    /*=====  End of metodo para consultar todos los grados de escolaridad  ======*/

    /*=========================================================================
    =            metodo para consultar todos los grupos sanguineos            =
    =========================================================================*/

    public function getAllGrupoSanguineos()
    {
        return GrupoSanguineo::allGrupoSanguineos('gruposanguineos.nombre')->get();
    }

    /*=====  End of metodo para consultar todos los grupos sanguineos  ======*/

    /*===========================================================================
    =            metodo para consultar todos las eps segun su estado            =
    ===========================================================================*/

    public function getAllEpsActivas()
    {
        return Eps::allEps(Eps::IsActive(), 'eps.nombre')->get();
    }

    /*=====  End of metodo para consultar todos las eps segun su estado  ======*/

    /*===============================================
    =            metodod para registrar  token de activacion           =
    ===============================================*/

    public function activationToken($user)
    {
        return ActivationToken::create([
            'user_id'    => $user,
            'token'      => str_random(60),
            'created_at' => Carbon::now(),
        ]);
    }

    /*=====  End of metodod para registrar   ======*/

    /*====================================================================
    =            metodo para  consultar todas las ocupaciones            =
    ====================================================================*/

    public function getAllOcupaciones()
    {

        return Ocupacion::allOcupaciones()->pluck('nombre', 'id');
    }

    /*=====  End of metodo para  consultar todas las ocupaciones  ======*/

    /*=====  End of metodo para consultar todo el detalle del usuario por su id  ======*/

    /*===============================================================
    =            metodo para consultar el usuario por id            =
    ===============================================================*/

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
                'talento.perfil',
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
                'talento.perfil',
                'talento.entidad',
                'ingreso.nodo.entidad',
            ]
        )->where('documento', $document);
    }

    /*=====  End of metodo para consultar el usuario por id  ======*/

    /*========================================================================
    =            metodo para consultar la informacion del usuario            =
    ========================================================================*/

    public function account($id)
    {
        return User::with(['tipodocumento', 'grupoSanguineo', 'eps', 'ciudad', 'ciudad.departamento', 'ocupaciones', 'gradoescolaridad', 'talento', 'dinamizador', 'roles', 'dinamizador.nodo', 'dinamizador.nodo.entidad', 'gestor.nodo', 'gestor.nodo.entidad', 'gestor.lineatecnologica', 'infocenter', 'infocenter.nodo', 'infocenter.nodo.entidad'])->where('id', $id)->firstOrFail();
    }

    /*=====  End of metodo para consultar la informacion del usuario  ======*/

    /*========================================================================
    =            metodo para obtener todos los roles laravel permision            =
    ========================================================================*/

    public function getAllRoles()
    {
        return Role::whereNotIn('name', [User::IsDesarrollador()])->pluck('name', 'id');
    }

    /*=====  End of metodo para obtener todos los roles laravel permision  ======*/

    /*========================================================================
    =            metodo para obtener todos los roles menos el inidicado laravel permision            =
    ========================================================================*/

    public function getRoleWhereNotInRole(array $role)
    {

        // return $role;
        return Role::whereNotIn('name', $role)->pluck('name', 'id');
    }

    /*=====  End of metodo para obtener todos los roles menos el inidicado laravel permision  ======*/

    /*========================================================================
    =            metodo para obtener todos los roles inidicados laravel permision            =
    ========================================================================*/

    public function getRoleWhereInRole(array $role)
    {

        return Role::whereIn('name', $role)->pluck('name', 'id');
    }

    /*=====  End of metodo para obtener todos los roles inidicados laravel permision  ======*/

    /*=============================================================
    =            metodo para consultar todos los nodos            =
    =============================================================*/

    public function getAllNodo()
    {
        return Nodo::selectNodo()->pluck('nodos', 'id');
    }

    /*=====  End of metodo para consultar todos los nodos  ======*/

    /*=================================================================
    =            metodo para consultar las lineas por nodo            =
    =================================================================*/

    public function getAllLineaNodo($nodo)
    {
        return Nodo::allLineasPorNodo($nodo);
    }

    /*=====  End of metodo para consultar las lineas por nodo  ======*/

    /*============================================================================
    =            metodo para consultar todos los perfiles del talento            =
    ============================================================================*/

    public function getAllPerfiles()
    {
        return Perfil::allPerfiles()->pluck('nombre', 'id');
    }

    /*=====  End of metodo para consultar todos los perfiles del talento  ======*/

    /*==================================================================
    =            metodo para consultar todas las regionales            =
    ==================================================================*/

    public function getAllRegionales()
    {
        return Regional::allRegionales()->pluck('nombre', 'id');
    }

    /*=====  End of metodo para consultar todas las regionales  ======*/

    /*======================================================
    =            metodo para guardar un usuario            =
    ======================================================*/
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

                Honorario::create([
                    'gestor_id' => $gestor->id,
                    'anio' => Carbon::now()->isoFormat('YYYY'),
                    'valor' => $request->input('txthonorario')
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
        } catch (Exception $e) {
            DB::rollback();
            return false;
        }
    }

    /*=====  End of metodo para guardar un usuario  ======*/

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
            "perfil_id"             => $request->input('txttipotalento'),
            "tipo_talento_id"       => $request->input('txttipotalento'),
            "entidad_id"            => $entidad,

            "programa_formacion"    => $request->get('txtprogramaformacion') == $this->getIdTipoTalentoForNombre(TipoTalento::IS_APRENDIZ_SENA_CON_APOYO) ?
                $request->input('txtprogramaformacion_aprendiz') : $request->get('txttipotalento') == $this->getIdTipoTalentoForNombre(TipoTalento::IS_APRENDIZ_SENA_SIN_APOYO) ?
                $request->input('txtprogramaformacion_aprendiz') : $request->get('txttipotalento') == $this->getIdTipoTalentoForNombre(TipoTalento::IS_EGRESADO_SENA) ?
                $request->input('txtprogramaformacion_egresado') : null,

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
            "otro_tipo_talento"     => null,


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

    /*=========================================================
    =            metodo para actualizar un usuario            =
    =========================================================*/

    public function Update($request, $user)
    {

        if ($request->filled('txtnododinamizador')) {
            $userdinamizador = User::whereHas('dinamizador.nodo', function ($query) use ($request) {
                $query->where('id', $request->txtnododinamizador);
            })->get();
        }




        DB::beginTransaction();
        try {

            $userUpdated = $this->updateUser($request, $user);

            $userUpdated->ocupaciones()->sync($request->get('txtocupaciones'));

            $newRole = array_diff($request->input('role'), collect($userUpdated->getRoleNames())->toArray());

            $removeRole = array_diff(collect($userUpdated->getRoleNames())->toArray(), $request->input('role'));



            if ($removeRole != null && $this->roleIsAssigned($removeRole, User::IsDinamizador()) && isset($userUpdated->dinamizador)) {
                Dinamizador::find($userUpdated->dinamizador->id)->delete();
            }

            if ($removeRole != null && $this->roleIsAssigned($removeRole, User::IsInfocenter()) && isset($userUpdated->infocenter)) {
                Infocenter::find($userUpdated->infocenter->id)->delete();
            }

            if ($removeRole != null && $this->roleIsAssigned($removeRole, User::IsIngreso()) && isset($userUpdated->ingreso)) {
                Ingreso::find($userUpdated->ingreso->id)->delete();
            }

            if ($newRole != null && $this->roleIsAssigned($newRole, User::IsDinamizador()) && !isset($userUpdated->dinamizador) && $this->notExistRoleInArray($request, $userUpdated, User::IsDinamizador())) {
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

            if ($newRole != null && $this->roleIsAssigned($newRole, User::IsGestor()) && !isset($userUpdated->gestor) && $this->notExistRoleInArray($request, $userUpdated, User::IsGestor())) {

                if ($request->filled('txtnodogestor')) {
                    Gestor::create([
                        "user_id"             => $userUpdated->id,
                        "nodo_id"             => $request->input('txtnodogestor'),
                        "lineatecnologica_id" => $request->input('txtlinea'),
                        "honorarios"          => $request->input('txthonorario'),
                    ]);
                }
            }

            if ($newRole != null && $this->roleIsAssigned($newRole, User::IsInfocenter()) && !isset($userUpdated->infocenter) && $this->notExistRoleInArray($request, $userUpdated, User::IsInfocenter())) {
                Infocenter::create([
                    "user_id"   => $user->id,
                    "nodo_id"   => $request->input('txtnodoinfocenter'),
                    "extension" => $request->input('txtextension'),
                ]);
            }

            if ($newRole != null && $this->roleIsAssigned($newRole, User::IsTalento()) && !isset($userUpdated->talento) && $this->notExistRoleInArray($request, $userUpdated, User::IsTalento())) {
                $this->storeTalento($request, $userUpdated);
            }
            if ($newRole != null && $this->roleIsAssigned($newRole, User::IsIngreso()) && !isset($userUpdated->ingreso) && $this->notExistRoleInArray($request, $userUpdated, User::IsIngreso())) {
                Ingreso::create([
                    "nodo_id" => $request->input('txtnodoingreso'),
                    "user_id" => $user->id,
                ]);
            }

            //update dinamizador
            if (isset($userUpdated->dinamizador->id) && !$this->roleIsAssigned($removeRole, User::IsDinamizador())) {

                if ($userdinamizador->count() >= Dinamizador::cantidadDinamizadoresPermitidosPornodo() && $userUpdated->dinamizador->nodo->id == $request->input('txtnododinamizador')) {
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
                } else {
                    Dinamizador::find($userUpdated->dinamizador->id)->update([
                        "nodo_id" => $request->input('txtnododinamizador'),
                    ]);
                }
            }

            //update gestor
            if (isset($userUpdated->gestor) && $this->roleIsAssigned($removeRole, User::IsGestor()) && $request->filled('txtnodogestor')) {


                $gestor = Gestor::find($userUpdated->gestor->id)->update([
                    "nodo_id"             => $request->input('txtnodogestor'),
                    "lineatecnologica_id" => $request->input('txtlinea'),
                    "honorarios"          => $request->input('txthonorario'),
                ]);

                // $honorario = Honorario::where('gestor_id', $gestor->id)->where('anio', Carbon::now()->isoFormat('YYYY'))->first();
                // if (isset($honorario)) {
                //     $honorario->update([
                //         'gestor_id' => $gestor->id,
                //         'anio' => Carbon::now()->isoFormat('YYYY'),
                //         'valor' => $request->input('txthonorario')
                //     ]);
                // }
            } else if (isset($userUpdated->gestor) && !$this->roleIsAssigned($removeRole, User::IsGestor()) && $request->filled('txtnodogestor')) {
                $gestor = Gestor::find($userUpdated->gestor->id)->update([
                    "nodo_id"             => $request->input('txtnodogestor'),
                    "lineatecnologica_id" => $request->input('txtlinea'),
                    "honorarios"          => $request->input('txthonorario'),
                ]);

                // $honorario = Honorario::where('gestor_id', $gestor->id)->where('anio', Carbon::now()->isoFormat('YYYY'))->first();
                // if (isset($honorario)) {
                //     $honorario->update([
                //         'gestor_id' => $gestor->id,
                //         'anio' => Carbon::now()->isoFormat('YYYY'),
                //         'valor' => $request->input('txthonorario')
                //     ]);
                // }
            }

            //update infocenter
            if (isset($userUpdated->infocenter->id) && !$this->roleIsAssigned($removeRole, User::IsInfocenter()) && $request->filled('txtnodoinfocenter')) {

                Infocenter::find($userUpdated->infocenter->id)->update([
                    "nodo_id"   => $request->input('txtnodoinfocenter'),
                    "extension" => $request->input('txtextension'),
                ]);
            }

            if (isset($userUpdated->talento) && !$this->roleIsAssigned($removeRole, User::IsTalento())) {

                $this->updateTalento($request, $userUpdated);
            }

            if (isset($userUpdated->ingreso) && !$this->roleIsAssigned($removeRole, User::IsIngreso()) && $request->filled('txtnodoingreso')) {

                Ingreso::find($userUpdated->ingreso->id)->update([
                    "nodo_id" => $request->input('txtnodoingreso'),
                ]);
            }

            $userUpdated->syncRoles($request->role);

            DB::commit();

            return $userUpdated;
        } catch (Exception $e) {
            DB::rollback();
            return false;
        }
    }

    /*=====  End of metodo para actualizar un usuario  ======*/

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
     * @author julian londoño
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

            "perfil_id"             => $request->input('txttipotalento'),
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
            "otro_tipo_talento"     => null,

        ]);
    }

    /*=====  End of metodo para actualizar un usuario talento  ======*/

    /*=================================================================
    =            metodo para consultar el id del perfil por nombre            =
    =================================================================*/

    public function getIdPerfilForNombre(string $perfil)
    {
        return Perfil::where('nombre', $perfil)->first()->id;
    }

    public function getIdTipoTalentoForNombre(string $tipotalento)
    {
        return TipoTalento::where('nombre', $tipotalento)->first()->id;
    }

    /*=====  End of metodo para consultar el id del perfil por nombre  ======*/

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
            return $this->getInfoUsersTalentosWithProjects($anio)
                ->where('nodos.id', $nodo)
                ->where('gestores.id', $user);
        } else if ($user == null && session()->get('login_role') == User::IsDinamizador()) {
            if ($nodo == null) {
                $this->getInfoUsersTalentosWithProjects($anio);
            }
            return $this->getInfoUsersTalentosWithProjects($anio)
                ->where('nodos.id', $nodo);
        } else if ($user != null && session()->get('login_role') == User::IsDinamizador()) {
            if ($nodo == null) {
                $this->getInfoUsersTalentosWithProjects($anio)
                    ->where('gestores.id', $user);
            }
            return $this->getInfoUsersTalentosWithProjects($anio)
                ->where('nodos.id', $nodo)
                ->where('gestores.id', $user);
        } else if ($user == null && session()->get('login_role') == User::IsAdministrador()) {
            if ($nodo == null) {
                $this->getInfoUsersTalentosWithProjects($anio);
            }
            return $this->getInfoUsersTalentosWithProjects($anio)
                ->where('nodos.id', $nodo);
        }
    }

    private function getInfoUsersTalentosWithProjects($anio = null)
    {
        if ($anio == null) {
            return User::InfoUserDatatable()
                ->selectRaw('CONCAT(celular, "; ", users.telefono) AS contactos')
                ->join('talentos', 'talentos.user_id', '=', 'users.id')
                ->join('articulacion_proyecto_talento', 'articulacion_proyecto_talento.talento_id', '=', 'talentos.id')
                ->join('articulacion_proyecto', 'articulacion_proyecto_talento.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
                ->join('proyectos', 'proyectos.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
                ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
                ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
                ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id');
        }
        return User::InfoUserDatatable()
            ->selectRaw('CONCAT(celular, "; ", users.telefono) AS contactos')
            ->join('talentos', 'talentos.user_id', '=', 'users.id')
            ->join('articulacion_proyecto_talento', 'articulacion_proyecto_talento.talento_id', '=', 'talentos.id')
            ->join('articulacion_proyecto', 'articulacion_proyecto_talento.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
            ->join('proyectos', 'proyectos.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
            ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
            ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
            ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
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
}
