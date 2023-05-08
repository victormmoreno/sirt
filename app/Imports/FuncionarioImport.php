<?php

namespace App\Imports;

use App\Models\{
    Ciudad,
    Eps,
    GradoEscolaridad,
    GrupoSanguineo,
    Ocupacion,
    TipoDocumento,
};
use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\{DB};
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('slug');

class FuncionarioImport implements ToCollection, WithHeadingRow
{
    public $validaciones;
    public $hoja;
    public $nodo;
    public function __construct($nodo)
    {
        $this->validaciones = new ValidacionesImport;
        $this->hoja = 'Funcionario';
        $this->nodo = $nodo;
    }
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        DB::beginTransaction();
        try {
            foreach ($rows as $key => $row)
            {
                $row['correo'] = str_replace(' ', '', $row['correo']);
                $row['correo'] = ltrim(rtrim($row['correo']));
                // Mayúsculas
                $row['genero'] = strtoupper($row['genero']);
                // Validar documento
                $documento = str_replace(' ', '', $row['documento']);
                $row['documento'] = str_replace(' ', '', $row['documento']);
                $vDocumento = $this->validaciones->validarCelda($documento, $key, 'Número de documento', $this->hoja);
                if (!$vDocumento) {
                    return $vDocumento;
                }
                $vDocumento = $this->validaciones->validarTamanhoCelda($documento, $key, 'Número de documento', 11, $this->hoja);
                if (!$vDocumento) {
                    return $vDocumento;
                }
                // Validar tipo de documento
                $queryTipoDocumento = TipoDocumento::where('nombre', $row['tipo_documento'])->first();
                $vTipoDocumento = $this->validaciones->validarQuery($queryTipoDocumento, $row['tipo_documento'], $key, 'Tipo de documento', $this->hoja);
                if (!$vTipoDocumento) {
                    return $vTipoDocumento;
                }
                // Validar nombres y apellidos
                $vNombres = $this->validaciones->validarCelda($row['nombres'], $key, 'Nombres', $this->hoja);
                if (!$vNombres) {
                    return $vNombres;
                }
                $vApellidos = $this->validaciones->validarCelda($row['apellidos'], $key, 'Apellidos', $this->hoja);
                if (!$vApellidos) {
                    return $vApellidos;
                }

                // Validar género
                $vGenero = $this->validaciones->validarGenero($row['genero'], $key, $this->hoja);
                if (!$vGenero) {
                    return $vGenero;
                }
                // Validar grupo sanguineo
                $queryGrupoSanguineo = GrupoSanguineo::where('nombre', $row['grupo_sanguineo'])->first();
                $vGrupoSanguineo = $this->validaciones->validarQuery($queryGrupoSanguineo, $row['grupo_sanguineo'], $key, 'Grupo sanguíneo', $this->hoja);
                if (!$vGrupoSanguineo) {
                    return $vGrupoSanguineo;
                }
                // Validar eps
                $queryEps = Eps::where('nombre', $row['eps'])->first();
                $vEps = $this->validaciones->validarQuery($queryEps, $row['eps'], $key, 'Eps', $this->hoja);
                if (!$vEps) {
                    return $vEps;
                }
                // Validar correo electrónico
                $vCorreo = $this->validaciones->validarCelda($row['correo'], $key, 'Correo electrónico', $this->hoja);
                if (!$vCorreo) {
                    return $vCorreo;
                }

                // Validar grado de escolaridad
                $queryGradoEscolaridad = GradoEscolaridad::where('nombre', $row['grado_escolaridad'])->first();
                $user = User::where('documento', $documento)->withTrashed()->first();
                $user_email = User::where('email', $row['correo'])->withTrashed()->first();

                $ocupaciones = explode(',', $row['ocupaciones']);
                $ocupaciones = $this->getOcupaciones($ocupaciones);


                if ($user == null) {
                    // No hay registrado
                    if ($user_email == null) {
                        // en caso de que el correo no se encuentra registrado
                        $user = $this->registrarUser($row, $queryTipoDocumento, $queryGradoEscolaridad, $queryGrupoSanguineo, $queryEps, $ocupaciones[1]);
                        $user->ocupaciones()->sync($ocupaciones[0], false);

                    } else {
                        return $this->validaciones->errorValidacionCorreo($row['correo'], $key, $user_email->documento, $this->hoja);
                    }
                } else {
                    // El usuario existe - Cambia información
                    if ($user != null && $user->documento == $documento && $user->email = $row['correo']) {
                        // Permite actualizar la información porque el correo le pertenece a la persona
                        // Cambia la información actual
                        $this->updateUser($user, $row, $queryTipoDocumento, $queryGradoEscolaridad, $queryGrupoSanguineo, $queryEps, $ocupaciones[1]);
                        $user->ocupaciones()->sync($ocupaciones[0], true);

                    } else {
                        // No permite actualizar la información porque el correo se encuentra asociado a otra persona
                        return $this->validaciones->errorValidacionCorreo($row['correo'], $key, $user->documento, $this->hoja);
                    }
                }
            }
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return false;
        }
    }

    private function getOcupaciones($ocupaciones)
    {
        $otra_ocupacion = null;
        $ocupaciones_foraneas = array();
        if (count($ocupaciones) != 0) {
            for ($i=0; $i < count($ocupaciones) ; $i++) {
                $ocupaciones[$i] = ltrim(rtrim($ocupaciones[$i]));
                $ocupaciones[$i] = ucfirst(strtolower($ocupaciones[$i]));
                switch ($ocupaciones[$i]) {
                    case 'Estudiante':
                        $ocupacion_id = Ocupacion::where('nombre', 'Estudiante')->first()->id;
                        array_push($ocupaciones_foraneas, $ocupacion_id);
                        break;
                    case 'Independiente':
                        $ocupacion_id = Ocupacion::where('nombre', 'Independiente')->first()->id;
                        array_push($ocupaciones_foraneas, $ocupacion_id);
                        break;
                    case 'Empleado':
                        $ocupacion_id = Ocupacion::where('nombre', 'Empleado')->first()->id;
                        array_push($ocupaciones_foraneas, $ocupacion_id);
                        break;
                    case 'Otra':
                        $ocupacion_id = Ocupacion::where('nombre', 'Otra')->first()->id;
                        array_push($ocupaciones_foraneas, $ocupacion_id);
                        break;
                    default:
                        $otra_ocupacion = $ocupaciones[$i];
                        break;
                }
            }
        }
        return [$ocupaciones_foraneas, $otra_ocupacion];
    }

    private function registrarUser($row, $tipo_documento, $grado_escolaridad, $grupo_sanguineo, $eps, $otra_ocupacion)
    {
        $ciudad_expedicion = Ciudad::where('nombre', str_slug($row['ciudad_expedicion'], '_'))->first();
        $ciudad_residencia = Ciudad::where('nombre', str_slug($row['ciudad_residencia'],'_'))->first();
        return User::create([
            "tipodocumento_id" => $tipo_documento->id,
            "gradoescolaridad_id" => $grado_escolaridad == null ? null : $grado_escolaridad->id,
            "gruposanguineo_id" => $grupo_sanguineo->id,
            "eps_id" => $eps->id,
            "ciudad_id" => $ciudad_residencia == null ? null : $ciudad_residencia->id,
            "ciudad_expedicion_id" => $ciudad_expedicion == null ? null : $ciudad_expedicion->id,
            "nombres" => $row['nombres'],
            "apellidos" => $row['apellidos'],
            "documento" => $row['documento'],
            "email" => $row['correo'],
            "direccion" => $row['direccion'],
            "celular" => $row['celular'],
            "fechanacimiento" => str_slug($row['fecha_nacimiento'], '_'),
            "genero" => $row['genero'] == 'FEMENINO' ? 0 : 1,
            "otra_eps" => $eps->nombre == 'Otra' ? str_slug($row['otra_eps'], '_') : null,
            "estado" => User::IsActive(),
            "institucion" => $row['institucion'],
            "titulo_obtenido" => str_slug($row['titulo_obtenido'], '_'),
            "fecha_terminacion" => str_slug($row['fecha_terminacion'], '_'),
            "estrato" => $row['estrato'],
            "otra_ocupacion" => $otra_ocupacion
        ]);
    }

    private function updateUser($user, $row, $tipo_documento, $grado_escolaridad, $grupo_sanguineo, $eps, $otra_ocupacion)
    {
        $ciudad_expedicion = Ciudad::where('nombre', $row['ciudad_expedicion'])->first();
        $ciudad_residencia = Ciudad::where('nombre', $row['ciudad_residencia'])->first();
        return $user->update([
            "tipodocumento_id" => $tipo_documento->id,
            "gradoescolaridad_id" => $grado_escolaridad == null ? null : $grado_escolaridad->id,
            "gruposanguineo_id" => $grupo_sanguineo->id,
            "eps_id" => $eps->id,
            "ciudad_id" => $ciudad_residencia == null ? null : $ciudad_residencia->id,
            "ciudad_expedicion_id" => $ciudad_expedicion == null ? null : $ciudad_expedicion->id,
            "nombres" => $row['nombres'],
            "apellidos" => $row['apellidos'],
            "email" => $row['correo'],
            "direccion" => $row['direccion'],
            "celular" => $row['celular'],
            "fechanacimiento" => $row['fecha_nacimiento'],
            "genero" => $row['genero'] == 'FEMENINO' ? 0 : 1,
            "otra_eps" => $eps->nombre == 'Otra' ? $row['otra_eps'] : null,
            "estado" => User::IsActive(),
            "institucion" => $row['institucion'],
            "titulo_obtenido" => $row['titulo_obtenido'],
            "fecha_terminacion" => $row['fecha_terminacion'],
            "estrato" => $row['estrato'],
            "otra_ocupacion" => $otra_ocupacion
        ]);
    }

}
