<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{Hash, Notification, Validator};
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{ TipoTalento, TipoFormacion, TipoEstudio, Etnia, Eps, Ocupacion, Talento, Entidad};
use App\Repositories\Repository\UserRepository\UserRepository;
use App\Http\Requests\UsersRequests\{UserFormRequest};
use Illuminate\Support\Facades\DB;
use App\Events\User\UserWasRegistered;
use App\Repositories\Repository\UserRepository\DinamizadorRepository;
use App\Notifications\User\{ RoleAssignedOfficer};
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
        $this->middleware('auth')->only(['confirmContratorInformation', 'showConfirmContratorInformationForm']);
        $this->userRepository = $userRepository;
    }

    /**
     * Show the application registration form.
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
            'nodos'             => $this->userRepository->getAllNodoPrueba(),
            'regionales'        => $this->userRepository->getAllRegionales(),
            'tipotalentos' => TipoTalento::pluck('nombre', 'id'),
            'tipoformaciones' => TipoFormacion::pluck('nombre', 'id'),
            'tipoestudios' => TipoEstudio::pluck('nombre', 'id'),
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

                $message = "Bienvenido(a) {$user->nombres} {$user->apellidos} a " . config('app.name') . ", ahora debes esperar a que validemos tu información.";

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
            $user->ocupaciones()->sync($request->get('txtocupaciones'));





                // $dinamizadorRepository = new DinamizadorRepository;
                // $dinamizador = $dinamizadorRepository->getAllDinamizadoresPorNodo($request->input('txtnodo'))->first();


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
            "genero"               => $request->input('txtgenero'),
            "mujerCabezaFamilia"   => $request->input('txtmadrecabezafamilia'),
            "desplazadoPorViolencia" => $request->input('txtdesplazadoporviolencia'),
            "otra_eps"             => $request->input('txteps') == Eps::where('nombre', Eps::OTRA_EPS)->first()->id ? $request->input('txtotraeps') : null,
            "institucion"          => $request->input('txtinstitucion'),
            "titulo_obtenido"      => $request->get('txttitulo'),
            "fecha_terminacion"    => $request->get('txtfechaterminacion'),
            "password"             => $password,
            "estrato"              => $request->input('txtestrato'),
            "otra_ocupacion"       => collect($request->input('txtocupaciones'))->contains(Ocupacion::where('nombre', Ocupacion::IsOtraOcupacion())->first()->id) ? $request->input('txtotra_ocupacion') : null,
        ]);
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


    public function confirmContratorInformation(Request $request, int $documento)
    {
        $user = User::withTrashed()->where('documento', $documento)->firstOrFail();

        $req = new Request;
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
