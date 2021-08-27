<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\{Str, Facades\Session, Facades\Validator};
use App\Repositories\Repository\{UserRepository\UserRepository};
use App\Models\Nodo;

class ExportJsonController extends Controller
{
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        return view('exportar.index');
    }

    public function exportJsonUsers()
    {
        // $query = $this->userRepository->exportarUsersAJson()->first()->toJson(JSON_PRETTY_PRINT);
        $query = $this->userRepository->exportarUsersAJson()->get();
        foreach ($query as $key => $user) {
            foreach ($user->roles as $key => $rol) {
                unset($rol->pivot);
            }
            $user['nombre_tipo_documento'] = $user->tipodocumento->nombre;
            $user['nombre_eps'] = $user->eps->nombre;
            unset($user->tipodocumento_id);
            unset($user->gradoescolaridad_id);
            unset($user->gruposanguineo_id);
            unset($user->eps_id);
            unset($user->ciudad_id);
            unset($user->ciudad_expedicion_id);
            unset($user->etnia_id);
            unset($user->nombre_completo);
            unset($user->tipodocumento);
            unset($user->eps);
        }
        // dd($query->toJson(JSON_PRETTY_PRINT));
        // $query = $this->userRepository->exportarUsersAJson()->get()->toJson(JSON_PRETTY_PRINT);
        $filename = "users.json";
        $handle = fopen($filename, 'w+');
        fputs($handle, $query->toJson(JSON_PRETTY_PRINT));
        fclose($handle);
        $headers = array('Content-type'=> 'application/json');
        return response()->download($filename,'users.json',$headers);



        ## A partir de aquí no funciona el código
        // $headers = array('Content-type'=> 'application/json');
        // return response()->download('users.json','movies.json',$headers);
        // return file_put_contents('users_json.txt', $query); 
        // return $query->toJson(JSON_PRETTY_PRINT);
    }
}
