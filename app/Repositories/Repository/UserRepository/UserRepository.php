<?php

namespace App\Repositories\Repository\UserRepository;

use App\Models\{
    ActivationToken,
    Ciudad,
    Departamento,
    Eps,
    Etnia,
    GradoEscolaridad,
    GrupoSanguineo,
    Infocenter,
    Ingreso,
    Nodo,
    Ocupacion,
    Regional,
    TipoDocumento,
    TipoTalento,
    TipoFormacion,
    TipoEstudio,
    LineaTecnologica
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

    public function getAllEtnias()
    {
        return Etnia::pluck('nombre', 'id');
    }

    public function getAllOcupaciones()
    {
        return Ocupacion::allOcupaciones()->pluck('nombre', 'id');
    }


    public function getAllEpsActivas()
    {
        return Eps::allEps(Eps::IsActive(), 'eps.nombre')->get();
    }

    public function getAllTipoTalento()
    {
        return TipoTalento::pluck('nombre', 'id');
    }

    public function getAllTipoEstudios()
    {
        return TipoEstudio::pluck('nombre', 'id');
    }

    public function activationToken($user)
    {
        return ActivationToken::create([
            'user_id'    => $user,
            'token'      => str_random(60),
            'created_at' => Carbon::now(),
        ]);
    }


    public function findByIdEloquent($id)
    {
        return User::query()
            ->withTrashed()
            ->where('users.id', $id);
    }

    public function findByIdBuilder($id)
    {
        return User::query()
        ->infoUserBuilder()
        ->select('users.id', 'tiposdocumentos.nombre as tipodocumento',
        'gradosescolaridad.nombre as gradoescolaridad',
        'gruposanguineos.nombre as gruposanguineo',
        'eps.nombre as eps', 'etnias.nombre as etnia',
        'ciudad_residencia.nombre as ciudad_residencia',
        'departamento_residencia.nombre as departamento_residencia',
        'ciudad_expedicion.nombre as ciudad_expedicion',
        'departamento_expedicion.nombre as departamento_expedicion',
        'users.documento','users.nombres', 'users.apellidos',
        'users.email','users.barrio','users.direccion','users.celular',
        'users.telefono','users.fechanacimiento', 'users.otra_eps',
        'users.institucion', 'users.titulo_obtenido', 'users.fecha_terminacion',
        'users.ultimo_login', 'users.estrato', 'users.otra_ocupacion',
        'users.informacion_user', 'users.informacion_user_completed_at',
        'users.created_at', 'users.deleted_at',
        )
        ->selectRaw('if(users.genero = 1, "Masculino", if(users.genero = 0, "Femenino", "No binario")) as nombre_genero')
        ->selectRaw('if(users.mujerCabezaFamilia = 1, "SI", "NO") as mujer_cabeza_familia')
        ->selectRaw('if(users.desplazadoPorViolencia = 1, "SI", "NO") as desplazado_violencia')
        ->selectRaw('if(users.grado_discapacidad = 1, "SI", "NO") as grado_discapacidad')
        ->selectRaw('if(users.grado_discapacidad = 1, users.descripcion_grado_discapacidad, "No Aplica") as descripcion_grado_discapacidad')
        ->selectRaw('if(users.estado = 1, "Habilidado", "Inhabilitado") as estado')
        ->selectRaw('GROUP_CONCAT(DISTINCT roles.name SEPARATOR "; ") as rols')
        ->selectRaw('GROUP_CONCAT(DISTINCT ocupaciones.nombre SEPARATOR "; ") as ocupacions')
        ->withTrashed()
        ->where('users.id', $id);
    }

    public function querySearchUser($field, $sentence, string $value)
    {
        return User::query()
        ->withTrashed()
        ->where($field, $sentence, $value);
    }

    public function findUserByDocumentEloquent($document)
    {
        return User::query()
        ->withTrashed()
        ->where('users.documento', $document);
    }

    public function findUserByDocumentBuilder($document)
    {
        return User::query()
        ->infoUserBuilder()
        ->select('users.id', 'tiposdocumentos.nombre as tipodocumento',
        'gradosescolaridad.nombre as gradoescolaridad',
        'gruposanguineos.nombre as gruposanguineo',
        'eps.nombre as eps', 'etnias.nombre as etnia',
        'ciudad_residencia.nombre as ciudad_residencia',
        'departamento_residencia.nombre as departamento_residencia',
        'ciudad_expedicion.nombre as ciudad_expedicion',
        'departamento_expedicion.nombre as departamento_expedicion',
        'users.documento','users.nombres', 'users.apellidos',
        'users.email','users.barrio','users.direccion','users.celular',
        'users.telefono','users.fechanacimiento', 'users.otra_eps',
        'users.institucion', 'users.titulo_obtenido', 'users.fecha_terminacion',
        'users.ultimo_login', 'users.estrato', 'users.otra_ocupacion',
        'users.created_at', 'users.deleted_at', 'users.informacion_user'
        )
        ->selectRaw('if(users.genero = 1, "Masculino", if(users.genero = 0, "Femenino", "No binario")) as nombre_genero')
        ->selectRaw('if(users.mujerCabezaFamilia = 1, "SI", "NO") as mujer_cabeza_familia')
        ->selectRaw('if(users.desplazadoPorViolencia = 1, "SI", "NO") as desplazado_violencia')
        ->selectRaw('if(users.grado_discapacidad = 1, "SI", "NO") as grado_discapacidad')
        ->selectRaw('if(users.grado_discapacidad = 1, users.descripcion_grado_discapacidad, "No Aplica") as descripcion_grado_discapacidad')
        ->selectRaw('if(users.estado = 1, "Habilidado", "Inhabilitado") as estado')
        ->selectRaw('GROUP_CONCAT(DISTINCT roles.name SEPARATOR "; ") as rols')
        ->selectRaw('GROUP_CONCAT(DISTINCT ocupaciones.nombre SEPARATOR "; ") as ocupaciones')
        ->withTrashed()
        ->where('users.documento', $document);
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

    public function getAllLineas()
    {
        return LineaTecnologica::pluck('nombre', 'id');
    }
    public function getAllTipoFormaciones()
    {
        return TipoFormacion::pluck('nombre', 'id');
    }

    public function getAllRegionales()
    {
        return Regional::allRegionales()->pluck('nombre', 'id');
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

    public function destroySessionUser()
    {
        Session::flush();
        Cache::flush();
    }

    private function SyncInfoRolesUser($request, $userUpdated)
    {
        $newRole = array_diff($request->input('role'), collect($userUpdated->getRoleNames())->toArray());



        $this->UpdateOrCreateRoleInfocenter($request, $userUpdated, $newRole);


        $this->UpdateOrCreateRoleIngreso($request, $userUpdated, $newRole);

        $userUpdated->syncRoles($request->role);
        return $userUpdated;
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
                'experto',
                'experto.nodo',
                'experto.nodo.entidad',
                'experto.nodo.centro',
                'experto.nodo.centro.regional',
                'experto.nodo.centro.entidad',
                'experto.lineatecnologica',
                'infocenter',
                'infocenter.nodo',
                'infocenter.nodo.entidad',
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
            ($user->has('experto') && isset($user->experto)) ||
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
