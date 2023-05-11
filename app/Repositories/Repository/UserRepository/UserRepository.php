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
use App\Events\User\UserHasNewPasswordGenerated;
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
        return User::query()
            ->withTrashed()
            ->where('users.id', $id)->firstOrFail();
    }

    public function getAllRoles()
    {
        return Role::query()->orderby('name')->pluck('name', 'id');
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
            $this->SyncInfoRolesUser($request, $user);
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
            "genero"               => $request->input('txtgenero'),
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


    /**
     * metodo para comprobar comprobar que el no exista en array
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
            "genero"               => $request->input('txtgenero'),
            "otra_eps"             => $request->input('txteps') == Eps::where('nombre', Eps::OTRA_EPS)->first()->id ? $request->input('txtotraeps') : null,
            "institucion"          => $request->input('txtinstitucion'),
            "titulo_obtenido"      => $request->get('txttitulo'),
            "fecha_terminacion"    => $request->get('txtfechaterminacion'),
            "estrato"              => $request->input('txtestrato'),
            "otra_ocupacion"       => collect($request->input('txtocupaciones'))->contains(Ocupacion::where('nombre', Ocupacion::IsOtraOcupacion())->first()->id) ? $request->input('txtotra_ocupacion') : null,
        ]);
        return $user;
    }


    private function getIdEntidadCentro(int $centro)
    {
        return Centro::select('entidades.id')
            ->join('entidades', 'entidades.id', '=', 'centros.entidad_id')
            ->where('centros.id', $centro)
            ->get()
            ->last()->id;
    }

    public function destroySessionUser()
    {
        Session::flush();
        Cache::flush();
    }

    public function getAllUsersForRole(string $role)
    {
        return User::InfoUserDatatable()
            ->role($role)
            ->orderby('users.created_at', 'desc')
            ->get();
    }

    public function getAllUsersForDatatables()
    {
        return User::InfoUserDatatable()->with(['roles' => function ($query) {
            $query->select('name');
        }])
        ->orderby('users.created_at', 'desc')
        ->get();
    }

    public function userInfoWithRelations(array $role = [], array $relations = [])
    {
        return User::infoUserRole($role, $relations);
    }

    public function getUsersTalentosByProject($nodo = null, $user = null, $anio = null)
    {
        if ($user != null && session()->get('login_role') == User::IsExperto()) {
            if ($nodo == null) {
                return $this->getInfoUsersTalentosWithProjects($anio)
                    ->where('gestores.id', $user);
            }
            $nodo = auth()->user()->gestor->nodo_id;
            return $this->getInfoUsersTalentosWithProjects($anio)
                ->where('nodos.id', $nodo)
                ->where('gestores.id', $user);
        } else if ($user == null && session()->get('login_role') == User::IsExperto()) {
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
        } else if ($user == null && session()->get('login_role') == User::IsActivador()) {
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
        // DB::beginTransaction();
        // try {
            $userUpdate = $this->SyncInfoRolesUser($request, $user);
            $userUpdate->update([
                'estado' => User::IsActive(),
            ]);
            DB::commit();
            return $userUpdate;
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     return false;
        // }
    }

    private function SyncInfoRolesUser($request, $userUpdated)
    {
        $newRole = array_diff($request->input('role'), collect($userUpdated->getRoleNames())->toArray());

        $this->UpdateOrCreateRoleApoyoTecnico($request, $userUpdated, $newRole);

        $this->UpdateOrCreateRoleArticulador($request, $userUpdated, $newRole);

        $this->UpdateOrCreateRoleDinamizador($request, $userUpdated, $newRole, User::IsDinamizador());

        $this->UpdateOrCreateRoleExpert($request, $userUpdated, $newRole);

        $this->UpdateOrCreateRoleInfocenter($request, $userUpdated, $newRole);

        $this->UpdateOrCreateRoleTalent($request, $userUpdated, $newRole);

        $this->UpdateOrCreateRoleIngreso($request, $userUpdated, $newRole);

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
     * assign information to new dinamizador
     * @return void
     */
    private function UpdateOrCreateRoleDinamizador($request, User $userUpdated, array $newRole, $role)
    {
        $userdinamizador = $this->queryDinamizadoresByNodo($request);

        if ($newRole != null
            && collect($request->role)->contains(User::IsDinamizador())
        ) {

        }
    }

    /**
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
     * assign information to new user apoyo tecnico
     * @return void
     */
    private function UpdateOrCreateRoleApoyoTecnico($request, $userUpdated, $role)
    {
        if ($request->filled('txtnodouser') && collect($request->role)->contains(User::IsApoyoTecnico())) {
            UserNodo::updateOrCreate(
                [
                    'user_id' => $userUpdated->id,
                    'role' => User::IsApoyoTecnico()
                ],
                [
                    'nodo_id' => $request->input('txtnodouser'),
                    'honorarios' => $request->input('txthonorariouser')
                ]
            );
        }
    }

    /**
     * assign information to new user articulador
     * @return
     */
    private function UpdateOrCreateRoleArticulador($request, $userUpdated, $role)
    {
        if ($request->filled('txtnodoarticulador') && collect($request->role)->contains(User::IsArticulador())) {
            UserNodo::updateOrCreate(
                [
                    'user_id' => $userUpdated->id,
                    'role' => User::IsArticulador()
                ],
                [
                    'nodo_id' => $request->input('txtnodoarticulador'),
                    'honorarios' => $request->input('txthonorarioarticulador')
                ]
            );
        }
    }

    /**
     * assign information to new experto
     * @return void
     */
    private function UpdateOrCreateRoleExpert($request, User $userUpdated, array $role)
    {
        if (
            $request->filled('txtnodogestor') && is_array($role) && collect($request->role)->contains(User::IsExperto())
        ) {
            Gestor::updateOrCreate(
                ['user_id' => $userUpdated->id],
                [
                    'nodo_id' => $request->input('txtnodogestor'),
                    'lineatecnologica_id' => $request->input('txtlinea'),
                    'honorarios' => $request->input('txthonorario')
                ]
            );
        }
    }
    /**
     * assign information to new infocenter
     * @return
     */
    private function UpdateOrCreateRoleInfocenter($request, User $userUpdated, array $role)
    {
        if ($request->filled('txtnodoinfocenter') && collect($request->role)->contains(User::IsInfocenter())) {
            Infocenter::updateOrCreate(
                ['user_id' => $userUpdated->id],
                [
                    'nodo_id'   => $request->input('txtnodoinfocenter'),
                    'extension' => $request->input('txtextension'),
                ]
            );
        }
    }

    /**
     * assign information to new talent
     * @return
     */
    private function UpdateOrCreateRoleTalent($request, User $userUpdated, array $role)
    {
        if ($role != null && collect($request->role)->contains(User::IsTalento())
        ) {
        }
    }

    /**
     * assign information to new ingreso
     * @return
     */
    private function UpdateOrCreateRoleIngreso($request, User $userUpdated, array $role)
    {
        if ($request->filled('txtnodoingreso') && collect($request->role)->contains(User::IsIngreso())) {
            Ingreso::updateOrCreate(
                ['user_id' => $userUpdated->id],
                ["nodo_id" => $request->input('txtnodoingreso')]
            );
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
    }

    /**
     * generate new password to user
     * @return void
     */
    public function generateNewPasswordToUser(User $user){
        DB::beginTransaction();
        try {
            $password = $this->generateFomatizedPassword($user);
            $user->update([
                "password"=> $password,
            ]);
            $message = "Nueva contraseña generada | " . config('app.name');
            event(new UserHasNewPasswordGenerated($user, $password, $message));
            DB::commit();
            return $this->sendGeneratePasswordResponse($password);

        } catch (\Exception $e) {
            DB::rollback();
            return $this->sendGeneratePasswordFailedResponse($e->getMessage());
        }
    }

    /**
     * Get the response for a successful generate password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendGeneratePasswordResponse(string $password)
    {
        return back()->with('status', "Contraseña generada: {$password}");
    }

    /**
     * Get the response for a failed generate password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendGeneratePasswordFailedResponse($error)
    {
        return back()
            ->withErrors('error', $error);
    }

    /**
     * Get the response for a failed generate password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    private function generateFomatizedPassword($user)
    {
        return config('auth.format_password'). sprintf("%04d",substr($user->documento ,-4)).'*';
    }

    public function updateAccessAUser($request, $user)
    {
        if(
            ($user->has('dinamizador') && isset($user->dinamizador)) ||
            ($user->isUserActivador()) ||
            ($user->has('articulador') && isset($user->articulador)) ||
            ($user->has('apoyotecnico') && isset($user->apoyotecnico)) ||
            ($user->has('gestor') && isset($user->gestor)) ||
            ($user->has('infocenter') && isset($user->infocenter)) ||
            ($user->has('ingreso') && isset($user->ingreso)) ||
            ($user->has('talento') && isset($user->talento))
        ){
            if ($request->get('txtestado') == 'on') {
                $user->update(['estado' => 0]);
                $user->delete();
                return redirect()->back()->withSuccess('Acceso de usuario modificado');
            } else {
                $user->update([
                    'estado' => User::IsActive(),
                ]);
                $user->restore();
                return redirect()->back()->withSuccess('Acceso de usuario modificado');
            }
        }
        else{
            return redirect()->back()->withError('No puedes cambiar el estado a este usuario. Primero asigna un rol y un nodo');
        }
        return redirect()->back()->withError('error', 'error al actualizar, intentalo de nuevo');
    }
}
