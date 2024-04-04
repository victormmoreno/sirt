<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB};
use App\Models\{Etnia, Eps, Ocupacion};
use App\Repositories\Repository\UserRepository\UserRepository;
use App\Http\Requests\UsersRequests\UserFormRequest;
use App\Events\User\UserWasRegistered;
class RegisterController extends Controller
{
    use RegistersUsers;
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    public $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Show the application registration form.
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('auth.register', [
            'etnias'            => $this->userRepository->getAllEtnias(),
            'tiposdocumentos'   => $this->userRepository->getAllTipoDocumento(),
            'gradosescolaridad' => $this->userRepository->getSelectAllGradosEscolaridad(),
            'gruposanguineos'   => $this->userRepository->getAllGrupoSanguineos(),
            'eps'               => $this->userRepository->getAllEpsActivas(),
            'departamentos'     => $this->userRepository->getAllDepartamentos(),
            'ocupaciones'       => $this->userRepository->getAllOcupaciones(),
        ]);
    }

    /**
     * Handle a registration request for the application.
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $req = new UserFormRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'state'   => 'error_form',
                'fail'   => true,
                'errors' => $validator->errors(),
            ]);
        } else {
            $user = $this->store($request);
            if ($user != null) {
                $message = "Bienvenido(a) {$user->nombres} {$user->apellidos} a " . config('app.name');
                return response()->json([
                    'state'   => 'success',
                    'message' => $message,
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

    protected function store($request)
    {
        DB::beginTransaction();
        try {
            $password = User::generatePasswordRamdom();
            $user = $this->createUser($request, $password);
            $user->assignRole(User::IsUsuario());
            if($user != null){
                $message = "Credenciales de ingreso a " . config('app.name');
                event(new UserWasRegistered($user, $password, $message));
            }
            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    private function createUser($request, $password): User
    {
        $user =  User::create([
            "tipodocumento_id"     => $request->input('tipo_documento'),
            "documento"            => $request->input('documento'),
            "ciudad_expedicion_id" => $request->input('ciudadexpedicion'),
            "email"                => $request->input('email'),
            "telefono"             => $request->input('telefono'),
            "celular"              => $request->input('celular'),
            "ciudad_id"            => $request->input('ciudad'),
            "barrio"               => $request->input('barrio'),
            "nombres"              => $request->input('nombres'),
            "apellidos"            => $request->input('apellidos'),
            "fechanacimiento"      => $request->input('fechanacimiento'),
            "gruposanguineo_id"    => $request->input('gruposanguineo'),
            "estrato"              => $request->input('estrato'),
            "etnia_id"             => $request->input('etnia'),
            "eps_id"               => $request->input('eps'),
            "otra_eps"             => $request->input('eps') == Eps::where('nombre', Eps::OTRA_EPS)->first()->id ? $request->input('otraeps') : null,
            "grado_discapacidad"   => $request->input('gradodiscapacidad'),
            "descripcion_grado_discapacidad"    => $request->input('discapacidad'),
            "mujerCabezaFamilia"   => $request->input('madrecabezafamilia'),
            "desplazadoPorViolencia" => $request->input('desplazadoporviolencia'),
            "genero"               => $request->input('genero'),
            "institucion"          => $request->input('institucion'),
            "gradoescolaridad_id"  => $request->input('gradoescolaridad'),
            "titulo_obtenido"      => $request->get('titulo'),
            "fecha_terminacion"    => $request->get('fechaterminacion'),
            "password"             => $password,
            "otra_ocupacion"       => collect($request->input('ocupaciones'))->contains(Ocupacion::where('nombre', Ocupacion::IsOtraOcupacion())->first()->id) ? $request->input('otra_ocupacion') : null,
        ]);
        $user->ocupaciones()->sync($request->get('ocupaciones'));
        return $user;
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
}
