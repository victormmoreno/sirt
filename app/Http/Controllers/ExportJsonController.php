<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\{Arr, Str, Facades\Session, Facades\Validator};
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
        $query = $this->userRepository->exportarUsersAJson()->get();
        foreach ($query as $key => $user) {
            $talento = $user->talento;
            $this->unsetRoles($user);
            $this->setExperto($user);
            $this->unsetOcupaciones($user);
            $this->setFieldsUser($user);
            $this->unsetFieldsUser($user);
            $this->setTalento($user, $talento);
            
        }
        $filename = "users.json";
        $handle = fopen($filename, 'w+');
        fputs($handle, $query->toJson(JSON_PRETTY_PRINT));
        fclose($handle);
        $headers = array('Content-type'=> 'application/json');
        return response()->download($filename,'users.json',$headers);
    }

    private function unsetFieldsUser($user)
    {
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
        unset($user->gradoescolaridad);
        unset($user->gruposanguineo);
        unset($user->ciudad);
        unset($user->barrio);
        unset($user->direccion);
        unset($user->estrato);
        unset($user->ciudadexpedicion);
        unset($user->gestor);
        unset($user->talento);
        unset($user->institucion);
        unset($user->titulo_obtenido);
        unset($user->fecha_terminacion);  
    }

    private function setEscolaridad($user)
    {
        $escolaridad = 'No registra';
        if ($user->gradoescolaridad_id != null) {
            $escolaridad = $user->gradoescolaridad->nombre;
        }
        return $escolaridad;
    }

    private function setCiudadResidencia($user)
    {
        $ciudad_residencia = 'No registra';
        $departamento_residencia = 'No registra';
        if ($user->ciudad_id != null) {
            $ciudad_residencia = $user->ciudad->nombre;
            $departamento_residencia = $user->ciudad->departamento->nombre;
        }
        return [
            "ciudad" => $ciudad_residencia,
            "departamento" => $departamento_residencia,
        ];
    }

    private function setCiudadExpedicion($user)
    {
        $ciudad_expedicion = 'No registra';
        $departamento_expedicion = 'No registra';
        if ($user->ciudad_expedicion_id != null) {
            $ciudad_expedicion = $user->ciudadexpedicion->nombre;
            $departamento_expedicion = $user->ciudadexpedicion->departamento->nombre;
        }
        return [
            "ciudad" => $ciudad_expedicion,
            "departamento" => $departamento_expedicion
        ];
    }

    private function setFieldsUser($user)
    {
        $escolaridad = $this->setEscolaridad($user);
        $residencia = $this->setCiudadResidencia($user);
        $expedicion = $this->setCiudadExpedicion($user);

        $user['nombre_tipo_documento'] = $user->tipodocumento->nombre;
        $user['nombre_eps'] = $user->eps->nombre;
        // $user['nombre_gradoescolaridad'] = $escolaridad;
        $user['nombre_gruposanguineo'] = $user->gruposanguineo->nombre;
        $user['lugar_residencia'] = array(
            "ciudad" => $residencia['ciudad'],
            "departamento" => $residencia['departamento'],
            "barrio" => $user->barrio,
            "direccion" => $user->direccion,
            "estrato" => $user->estrato
        );
        $user['lugar_expedicion'] = array(
            "ciudad" => $expedicion['ciudad'],
            "departamento" => $expedicion['departamento'],
        );
        $user['ultimo_estudio'] = [
            "gradoescolaridad" => $escolaridad,
            "institucion" => $user->institucion,
            "titulo_obtenido" => $user->titulo_obtenido,
            "fecha_terminacion" => $user->fecha_terminacion
        ];
    }

    private function unsetRoles($user)
    {
        foreach ($user->roles as $key => $rol) {
            unset($rol->pivot);
        }
    }

    private function setExperto($user)
    {
        if ($user->gestor != null) {
            $user['experto'] = array(
                "id" => $user->gestor->id,
                "nodo_id" => $user->gestor->nodo_id,
                "lineatecnologica" => $user->gestor->lineatecnologica->nombre,
                "abreviatura" => $user->gestor->lineatecnologica->abreviatura,
                "honorarios" => $user->gestor->honorarios,
                "created_at" => $user->gestor->created_at,
                "updated_at" => $user->gestor->updated_at
            );
        }
    }

    private function setTalento($user, $talento)
    {
        $entidad = null;
        $tipotalento = null;
        $tipoformacion = null;
        $tipoestudio = null;
        if ($talento != null) {
            
            if ($talento->entidad != null) {
                $entidad = $talento->entidad->nombre;
            }
            if ($talento->tipotalento != null) {
                $tipotalento = $talento->tipotalento->nombre;
            }
            if ($talento->tipoformacion != null) {
                $tipoformacion = $talento->tipoformacion->nombre;
            }
            if ($talento->tipoestudio != null) {
                $tipoestudio = $talento->tipoestudio->nombre;
            }

            $user['talento'] = [
                "entidad" => $entidad,
                "tipo_talento" => $tipotalento,
                "tipo_formacion" => $tipoformacion,
                "tipoestudio" => $tipoestudio,
                "universidad" => $talento->universidad,
                "programa_formacion" => $talento->programa_formacion,
                "carrera_universitaria" => $talento->carrera_universitaria,
                "empresa" => $talento->empresa,
                "dependencia" => $talento->dependencia,
                "created_at" => $talento->created_at,
                "updated_at" => $talento->updated_at
            ];
        }
    }

    private function unsetOcupaciones($user)
    {
        if (!$user->ocupaciones->isEmpty()) {
            foreach ($user->ocupaciones as $key => $ocupacion) {
                unset($ocupacion->pivot);
                unset($ocupacion->id);
            }
        }

    }
}
