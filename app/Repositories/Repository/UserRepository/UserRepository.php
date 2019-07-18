<?php

namespace App\Repositories\Repository\UserRepository;

use App\Models\ActivationToken;
use App\Models\Ciudad;
use App\Models\Departamento;
use App\Models\Dinamizador;
use App\Models\Entidad;
use App\Models\Eps;
use App\Models\Gestor;
use App\Models\GradoEscolaridad;
use App\Models\GrupoSanguineo;
use App\Models\Infocenter;
use App\Models\Ingreso;
use App\Models\Nodo;
use App\Models\Ocupacion;
use App\Models\Perfil;
use App\Models\Regional;
use App\Models\Rols;
use App\Models\Talento;
use App\Models\TipoDocumento;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
        return GradoEscolaridad::allGradosEscolaridad()->orderby('gradosescolaridad.id')->get();
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
        return User::with('ocupaciones')->findOrFail($id);
    }

    /*=====  End of metodo para consultar el usuario por id  ======*/

    /*========================================================================
    =            metodo para consultar la informacion del usuario            =
    ========================================================================*/

    public function account($documento)
    {
        return User::where('documento', $documento)->firstOrFail();
    }

    /*=====  End of metodo para consultar la informacion del usuario  ======*/

    /*========================================================================
    =            metodo para obtener todos los roles laravel permision            =
    ========================================================================*/

    public function getAllRoles()
    {
        return Role::all()->pluck('name', 'id');
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
        // dd($this->existRoleInArray($request,User::IsAdministrador()));

        DB::beginTransaction();
        try {

            $user = $this->storeUser($request, $password);

            $user->ocupaciones()->sync($request->get('txtocupaciones'));

            if ($this->existRoleInArray($request, User::IsAdministrador())) {

                $this->assignRoleUser($user, config('laravelpermission.roles.roleAdministrador'));
            }

            if ($this->existRoleInArray($request, User::IsDinamizador())) {
                Dinamizador::create([
                    "user_id" => $user->id,
                    "nodo_id" => $request->input('txtnododinamizador'),
                ]);

                $this->assignRoleUser($user, config('laravelpermission.roles.roleDinamizador'));
            }

            if ($this->existRoleInArray($request, User::IsGestor())) {
                Gestor::create([
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

                $this->assignRoleUser($user, config('laravelpermission.roles.roleGestor'));
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

                $this->assignRoleUser($user, config('laravelpermission.roles.roleDinamizador'));
            }

            if ($this->existRoleInArray($request, User::IsProveedor())) {

                $this->assignRoleUser($user, $request->input('role'));
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
            "rol_id"              => Rols::where('nombre', '=', Rols::IsAdministrador())->first()->id,
            "tipodocumento_id"    => $request->input('txttipo_documento'),
            "gradoescolaridad_id" => $request->input('txtgrado_escolaridad'),
            "gruposanguineo_id"   => $request->input('txtgruposanguineo'),
            "eps_id"              => $request->input('txteps'),
            "ciudad_id"           => $request->input('txtciudad'),
            "nombres"             => $request->input('txtnombres'),
            "apellidos"           => $request->input('txtapellidos'),
            "documento"           => $request->input('txtdocumento'),
            "email"               => $request->input('txtemail'),
            "barrio"              => $request->input('txtbarrio'),
            "direccion"           => $request->input('txtdireccion'),
            "celular"             => $request->input('txtcelular'),
            "telefono"            => $request->input('txttelefono'),
            "fechanacimiento"     => $request->input('txtfecha_nacimiento'),
            "genero"              => $request->input('txtgenero') == 'on' ? $request['txtgenero'] = 0 : $request['txtgenero'] = 1,
            "otra_eps"            => $request->input('txteps') == Eps::where('nombre', Eps::OTRA_EPS)->first()->id ? $request->input('txtotraeps') : null,
            "estado"              => User::IsInactive(),
            "institucion"         => $request->input('txtinstitucion'),
            "titulo_obtenido"     => $request->get('txttitulo'),
            "fecha_terminacion"   => $request->get('txtfechaterminacion'),
            "password"            => $password,
            "estrato"             => $request->input('txtestrato'),
            "otra_ocupacion"      => collect($request->input('txtocupaciones'))->contains(Ocupacion::where('nombre', Ocupacion::IsOtraOcupacion())->first()->id) ? $request->input('txtotra_ocupacion') : null,
        ]);

    }

    private function assignRoleUser($user, $role)
    {
        return $user->assignRole($role);
    }

    protected function storeTalento($request, $user)
    {

        $entidad = null;

        if ($request->get('txtperfil') == Perfil::IsAprendizSenaConApoyo() || $request->get('txtperfil') == Perfil::IsAprendizSenaSinApoyo() || $request->get('txtperfil') == Perfil::IsEgresadoSena()) {
            $entidad = $request->input('txtcentroformacion') ?: $this->getIdNoAplicaEntidad();
        } else if ($request->get('txtperfil') == Perfil::IsInvestigador()) {
            $entidad = $this->getIdGrupoInvesitgacion($request) ?: $this->getIdNoAplicaEntidad();
        } else {
            $entidad = $this->getIdNoAplicaEntidad();
        }
        return Talento::create([
            "user_id"               => $user->id,
            "perfil_id"             => $request->input('txtperfil'),
            "entidad_id"            => $entidad,
            "universidad"           => $request->input('txtuniversidad') ?: null,
            "programa_formacion"    => $request->input('txtprogramaformacion') ?: 'No Aplica',
            "carrera_universitaria" => $request->input('txtcarrerauniversitaria') ?: 'No Aplica',
            "empresa"               => $request->input('txtempresa') ?: null,
            "otro_tipo_talento"     => $request->input('txtotrotipotalento') ?: null,
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
        DB::beginTransaction();
        try {

            $userUpdated = $this->updateUser($request, $user);

            $newRole    = array_diff($request->input('role'), collect($userUpdated->getRoleNames())->toArray());

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
                Dinamizador::create([
                    "user_id" => $userUpdated->id,
                    "nodo_id" => $request->input('txtnododinamizador'),
                ]);

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

                Dinamizador::find($userUpdated->dinamizador->id)->update([
                    "nodo_id" => $request->input('txtnododinamizador'),
                ]);


            }

            //update gestor
            if (isset($userUpdated->gestor) && !$this->roleIsAssigned($removeRole, User::IsGestor())) {

                Gestor::find($userUpdated->gestor->id)->update([
                    "nodo_id"             => $request->input('txtnodogestor'),
                    "lineatecnologica_id" => $request->input('txtlinea'),
                    "honorarios"          => $request->input('txthonorario'),
                ]);

            }

            //update infocenter
            if (isset($userUpdated->infocenter->id) && !$this->roleIsAssigned($removeRole, User::IsInfocenter())) {

                Infocenter::find($userUpdated->infocenter->id)->update([
                    "nodo_id"   => $request->input('txtnodoinfocenter'),
                    "extension" => $request->input('txtextension'),
                ]);

            }

            if (isset($userUpdated->talento) && !$this->roleIsAssigned($removeRole, User::IsTalento())) {

                $this->updateTalento($request, $userUpdated);

            }

            if (isset($userUpdated->ingreso) && !$this->roleIsAssigned($removeRole, User::IsIngreso())) {

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
            "rol_id"              => Rols::where('nombre', '=', Rols::IsAdministrador())->first()->id,
            "tipodocumento_id"    => $request->input('txttipo_documento'),
            "gradoescolaridad_id" => $request->input('txtgrado_escolaridad'),
            "gruposanguineo_id"   => $request->input('txtgruposanguineo'),
            "eps_id"              => $request->input('txteps'),
            "ciudad_id"           => $request->input('txtciudad'),
            "nombres"             => $request->input('txtnombres'),
            "apellidos"           => $request->input('txtapellidos'),
            "documento"           => $request->input('txtdocumento'),
            "email"               => $request->input('txtemail'),
            "barrio"              => $request->input('txtbarrio'),
            "direccion"           => $request->input('txtdireccion'),
            "celular"             => $request->input('txtcelular'),
            "telefono"            => $request->input('txttelefono'),
            "fechanacimiento"     => $request->input('txtfecha_nacimiento'),
            "genero"              => $request->input('txtgenero') == 'on' ? $request['txtgenero'] = 0 : $request['txtgenero'] = 1,
            "otra_eps"            => $request->input('txteps') == Eps::where('nombre', Eps::OTRA_EPS)->first()->id ? $request->input('txtotraeps') : null,
            "estado"              => User::IsInactive(),
            "institucion"         => $request->input('txtinstitucion'),
            "titulo_obtenido"     => $request->get('txttitulo'),
            "fecha_terminacion"   => $request->get('txtfechaterminacion'),
            "estrato"             => $request->input('txtestrato'),
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

        if ($request->get('txtperfil') == Perfil::IsAprendizSenaConApoyo() || $request->get('txtperfil') == Perfil::IsAprendizSenaSinApoyo() || $request->get('txtperfil') == Perfil::IsEgresadoSena()) {
            $entidad = $request->input('txtcentroformacion') ?: $this->getIdNoAplicaEntidad();
        } else if ($request->get('txtperfil') == Perfil::IsInvestigador()) {
            $entidad = $this->getIdGrupoInvesitgacion($request) ?: $this->getIdNoAplicaEntidad();
        } else {
            $entidad = $this->getIdNoAplicaEntidad();
        }

        return Talento::find($userUpdated->talento->id)->update([
            "perfil_id"             => $request->input('txtperfil'),
            "entidad_id"            => $entidad,
            "universidad"           => $request->input('txtuniversidad') ?: null,
            "programa_formacion"    => $request->input('txtprogramaformacion') ?: 'No Aplica',
            "carrera_universitaria" => $request->input('txtcarrerauniversitaria') ?: 'No Aplica',
            "empresa"               => $request->input('txtempresa') ?: null,
            "otro_tipo_talento"     => $request->input('txtotrotipotalento') ?: null,
        ]);

    }

    /*=====  End of metodo para actualizar un usuario talento  ======*/

}
