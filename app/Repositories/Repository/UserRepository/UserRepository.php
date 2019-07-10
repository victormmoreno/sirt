<?php

namespace App\Repositories\Repository\UserRepository;

use App\Models\ActivationToken;
use App\Models\Ciudad;
use App\Models\Departamento;
use App\Models\Dinamizador;
use App\Models\Entidad;
use App\Models\Eps;
use App\Models\GradoEscolaridad;
use App\Models\GrupoSanguineo;
use App\Models\Infocenter;
use App\Models\Nodo;
use App\Models\Ocupacion;
use App\Models\Perfil;
use App\Models\Regional;
use App\Models\Rols;
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
        return Entidad::join('gruposinvestigacion','gruposinvestigacion.entidad_id','entidades.id')
                ->where('gruposinvestigacion.codigo_grupo',$request->get('txtgrupoinvestigacion'))
                ->first()->id;
                 
        DB::beginTransaction();
        try {

            $user = $this->storeUser($request, $password);
            $user->ocupaciones()->sync($request->get('txtocupaciones'));

            if (collect($request->input('role'))->contains(User::IsAdministrador())) {
                $this->assignRoleUser($user, config('laravelpermission.roles.roleAdministrador'));
            }

            if (collect($request->input('role'))->contains(User::IsDinamizador())) {
                Dinamizador::create([
                    "user_id" => $user->id,
                    "nodo_id" => $request->input('txtnododinamizador'),
                ]);

                $this->assignRoleUser($user, config('laravelpermission.roles.roleDinamizador'));
            }

            if (collect($request->input('role'))->contains(User::IsGestor())) {
                Gestor::create([
                    "user_id"             => $user->id,
                    "nodo_id"             => $request->input('txtnodogestor'),
                    "lineatecnologica_id" => $request->input('txtlinea'),
                    "honorarios"          => $request->input('txthonorario'),
                ]);

                $this->assignRoleUser($user, config('laravelpermission.roles.roleGestor'));
            }
            if (collect($request->input('role'))->contains(User::IsInfocenter())) {
                Infocenter::create([
                    "user_id"   => $user->id,
                    "nodo_id"   => $request->input('txtnodoinfocenter'),
                    "extension" => $request->input('txtextension'),
                ]);

                $this->assignRoleUser($user, config('laravelpermission.roles.roleGestor'));
            }

            if (collect($request->input('role'))->contains(User::IsTalento())) {
                
            }

            DB::commit();
            return true;
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
            ]);

    }

    private function assignRoleUser($user, $role)
    {
        return $user->assignRole($role);
    }

    protected function storeTalento($request)
    {
        $entidad = null;  

        if ($request->get('txtperfil') == Perfil::IsAprendizSenaConApoyo() || $request->get('txtperfil') == Perfil::IsAprendizSenaSinApoyo() || $request->get('txtperfil') == Perfil::IsEgresadoSena()) {
            $entidad = $request->input('txtcentroformacion');
        }else if($request->get('txtperfil') == Perfil::IsInvestigador()){
            $entidad = Entidad::where('nombre','No Aplica')->first()->id;
        }else{
            $entidad = Entidad::where('nombre','No Aplica')->first()->id;
        }
        return Talento::create([
                    "user_id"   => $user->id,
                    "perfil_id"   => $request->input('txtperfil'),
                    "entidad_id" => $entidad,
                    "universidad" => $request->input('txtuniversidad'),
                    "programa_formacion" => $request->input('txtprogramaformacion'),
                    "carrera_universitaria" => $request->input('txtcarrerauniversitaria'),
                    "empresa" => $request->input('txtempresa'),
                    "otro_tipo_talento" => $request->input('txtotrotipotalento'),
                ]);
    }

}
