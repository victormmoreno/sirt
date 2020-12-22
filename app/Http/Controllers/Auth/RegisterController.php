<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Models\LineaTecnologica;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{Hash, Notification, Validator};
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Models\{Contratista, TipoTalento, TipoFormacion, TipoEstudio, Etnia, Eps, Ocupacion, Talento, Entidad};
use App\Repositories\Repository\UserRepository\UserRepository;
use App\Http\Requests\UsersRequests\{UserFormRequest, ConfirmUserRequest};
use Illuminate\Support\Facades\DB;
use App\Events\User\UserWasRegistered;
use App\Repositories\Repository\UserRepository\DinamizadorRepository;
use App\Notifications\User\{NewContractor, RoleAssignedOfficer};



class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public $userRepository;


    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('guest')->except(['confirmContratorInformation', 'showConfirmContratorInformationForm']);
        $this->userRepository = $userRepository;
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }


    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('auth.register', [
            'etnias' => Etnia::pluck('nombre', 'id'),
            'tiposdocumentos'   => $this->userRepository->getAllTipoDocumento(),
            'gradosescolaridad' => $this->userRepository->getSelectAllGradosEscolaridad(),
            'gruposanguineos'   => $this->userRepository->getAllGrupoSanguineos(),
            'eps'                 => $this->userRepository->getAllEpsActivas(),
            'departamentos'     => $this->userRepository->getAllDepartamentos(),
            'ocupaciones'       => $this->userRepository->getAllOcupaciones(),
            'nodos'             => $this->userRepository->getAllNodo(),
            'regionales'        => $this->userRepository->getAllRegionales(),
            'tipotalentos' => TipoTalento::pluck('nombre', 'id'),
            'tipoformaciones' => TipoFormacion::pluck('nombre', 'id'),
            'tipoestudios' => TipoEstudio::pluck('nombre', 'id'),
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request){

        $req = new UserFormRequest;

        $validator = Validator::make($request->all(), $req->rules(), $req->messages());

        if ($validator->fails()) {
            return response()->json([
                'state'   => 'error_form',
                'fail'   => true,
                'errors' => $validator->errors(),
            ]);
        } else {

            //generar una contraseña
            $password = User::generatePasswordRamdom();
            //creamos el usuario
            $user = $this->store($request, $password);

            if ($user != null) {
                //evento para crear token para activacion de cuenta
                // $this->userRepository->activationToken($user->id);

                //envio de email con contraseña
                event(new UserWasRegistered($user, $password));



                return response()->json([
                    'state'   => 'success',
                    'message' => 'El Usuario ha sido creado satisfactoriamente',
                    'url' => route('login'),
                    'user' => $user,
                ]);
            } else {

                return response()->json([
                    'state'   => 'error',
                    'message' => 'El Usuario no se ha creado',
                    'url' => false
                ]);
            }
        }

    }

    protected function store($request, $password)
    {

        DB::beginTransaction();
        try {

            $user = $this->createUser($request, $password);

            $user->ocupaciones()->sync($request->get('txtocupaciones'));

            if ($request->filled('txttipousuario') && $request->input('txttipousuario') == 'talento') {
                $this->storeTalento($request, $user);
                $this->assignRoleUser($user, config('laravelpermission.roles.roleTalento'));
            }

            if ($request->filled('txttipousuario') && $request->input('txttipousuario') == 'contratista') {

                Contratista::create([
                    "user_id"   => $user->id,
                    "nodo_id"   => $request->input('txtnodo'),
                    "tipo_contratista"   => $request->input('txttipocontratista') == "contratista" ?  1 : $request['txttipocontratista'] = 0, //1 contratista. 0 planta
                ]);

                $dinamizadorRepository = new DinamizadorRepository;

                $dinamizador = $dinamizadorRepository->getAllDinamizadoresPorNodo($request->input('txtnodo'))->first();

                if($dinamizador != null){
                    Notification::send($dinamizador, new NewContractor($user, $dinamizador));
                }
                
            }

            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollback();
            return false;
        }
    }

    private function createUser($request, $password)
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
            "estado"               => $this->stateUser($request),
            "institucion"          => $request->input('txtinstitucion'),
            "titulo_obtenido"      => $request->get('txttitulo'),
            "fecha_terminacion"    => $request->get('txtfechaterminacion'),
            "password"             => $password,
            "estrato"              => $request->input('txtestrato'),
            "otra_ocupacion"       => collect($request->input('txtocupaciones'))->contains(Ocupacion::where('nombre', Ocupacion::IsOtraOcupacion())->first()->id) ? $request->input('txtotra_ocupacion') : null,
        ]);
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

            "programa_formacion"    => $this->programaFormacion($request),

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

    protected function getIdNoAplicaEntidad()
    {
        return Entidad::where('nombre', 'No Aplica')->first()->id;
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        //
    }

    private function assignRoleUser($user, $role)
    {
        return $user->assignRole($role);
    }

    private function stateUser($request){

        if ($request->filled('txttipousuario') && $request->input('txttipousuario') == 'talento') {
            return User::IsActive();
        }
        return User::IsInactive();
    }

    public function getIdTipoTalentoForNombre(string $tipotalento)
    {
        return TipoTalento::where('nombre', $tipotalento)->first()->id;
    }

    protected function programaFormacion($request){
        if($request->get('txtprogramaformacion') == $this->getIdTipoTalentoForNombre(TipoTalento::IS_APRENDIZ_SENA_CON_APOYO) || $request->get('txttipotalento') == $this->getIdTipoTalentoForNombre(TipoTalento::IS_APRENDIZ_SENA_SIN_APOYO)){
            return $request->input('txtprogramaformacion_aprendiz');
        }else if($request->get('txttipotalento') == $this->getIdTipoTalentoForNombre(TipoTalento::IS_EGRESADO_SENA)){
            $request->input('txtprogramaformacion_egresado');
        }else{
            return null;
        }
    }

    public function showConfirmContratorInformationForm(int $documento){

        $user = User::withTrashed()->where('documento', $documento)->firstOrFail();
        $this->authorize('confirmContratorInformation', $user);
        return view('auth.confirm-contractor-information', [
            'user' => $user,
            'roles' => $this->userRepository->getRoleWhereNotInRole([User::IsDesarrollador() ]),
            'nodos'             => $this->userRepository->getAllNodo(),
            'lineas' => LineaTecnologica::pluck('nombre', 'id'),
            'tipotalentos' => TipoTalento::pluck('nombre', 'id'),
            'regionales'        => $this->userRepository->getAllRegionales(),
            'tipoformaciones' => TipoFormacion::pluck('nombre', 'id'),
            'tipoestudios' => TipoEstudio::pluck('nombre', 'id'),
            'lineas' => LineaTecnologica::pluck('nombre', 'id'),
        ]);
    }

    public function confirmContratorInformation(Request $request, int $documento){

        $user = User::withTrashed()->where('documento', $documento)->firstOrFail();
        $this->authorize('confirmContratorInformation', $user);

        $req = new ConfirmUserRequest;

        $validator = Validator::make($request->all(), $req->rules(), $req->messages());

        if ($validator->fails()) {
            return response()->json([
                'state'   => 'error_form',
                'fail'   => true,
                'errors' => $validator->errors(),
            ]);
        } else {
            
            if ($user != null) {
                $userUpdate = $this->userRepository->UpdateUserConfirm($request, $user);

                if($userUpdate != null){
                    Notification::send($userUpdate, new RoleAssignedOfficer($userUpdate));
                }

                return response()->json([
                    'state'   => 'success',
                    'message' => 'El Usuario ha sido modificado satisfactoriamente',
                    'url' => route('usuario.index'),
                    'user' => $userUpdate,
                ]);
            } else {
                return response()->json([
                    'state'   => 'error',
                    'message' => 'El Usuario no se ha modificado',
                    'url' => false
                ]);
            }
        }   

    }

}