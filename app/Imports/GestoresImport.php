<?php

namespace App\Imports;

use App\Models\{
    Ciudad,
    Eps,
    GradoEscolaridad,
    GrupoSanguineo,
    LineaTecnologica,
    Ocupacion,
    TipoDocumento
};
use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\{DB};
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GestoresImport implements ToCollection, WithHeadingRow
{
    public $nodo;
    public $validaciones;
    public $hoja = 'Gestores';

    public function __construct($nodo)
    {
        $this->nodo = $nodo;
        $this->validaciones = new ValidacionesImport;
        // $this->hoja = 'Ideas';
    }
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        DB::beginTransaction();
        try {
            foreach ($rows as $key => $row) {
                $row['correo'] = str_replace(' ', '', $row['correo']);
                $row['correo'] = ltrim(rtrim($row['correo']));
                // Validar documento
                $documento = str_replace(' ', '', $row['documento']);
                $vDocumento = $this->validaciones->validarCelda($documento, $key, 'Número de documento', $this->hoja);
                if (!$vDocumento) {
                    return $vDocumento;
                }
                // Validar tipo de documento
                $queryTipoDocumento = TipoDocumento::where('nombre', $row['tipo_documento'])->first();
                $vTipoDocumento = $this->validaciones->validarQuery($queryTipoDocumento, $row['tipo_documento'], $key, 'Tipo de documento', $this->hoja);
                if (!$vTipoDocumento) {
                    return $vTipoDocumento;
                }
                // Validar ciudad de expedición
                $queryCiudadExpedicion = Ciudad::where('nombre', $row['ciudad_expedicion'])->first();
                $vCiudadExpedicion = $this->validaciones->validarQuery($queryCiudadExpedicion, $row['ciudad_expedicion'], $key, 'Ciudad de expedición', $this->hoja);
                if (!$vCiudadExpedicion) {
                    return $vCiudadExpedicion;
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
                // Validar fecha de nacimiento
                $vFechaNacimiento = $this->validaciones->validarFecha($row['fecha_nacimiento'], $key, 'Fecha de nacimiento', $this->hoja);
                if (!$vFechaNacimiento) {
                    return $vFechaNacimiento;
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
                // Validar ciudad de residencia
                $queryCiudadResidencia = Ciudad::where('nombre', $row['ciudad_residencia'])->first();
                $vCiudadResidencia = $this->validaciones->validarQuery($queryCiudadResidencia, $row['ciudad_residencia'], $key, 'Ciudad de residencia', $this->hoja);
                if (!$vCiudadResidencia) {
                    return $vCiudadResidencia;
                }

                // Validar correo electrónico
                $vCorreo = $this->validaciones->validarCelda($row['correo'], $key, 'Correo electrónico', $this->hoja);
                if (!$vCorreo) {
                    return $vCorreo;
                }
                // Validar fecha de terminación del último estudio
                $vFechaTerminacion = $this->validaciones->validarFecha($row['fecha_terminacion'], $key, 'Fecha de terminación', $this->hoja);
                if (!$vFechaTerminacion) {
                    return $vFechaTerminacion;
                }
                // Validar grado de escolaridad
                $queryGradoEscolaridad = GradoEscolaridad::where('nombre', $row['grado_escolaridad'])->first();
                // Validar línea tecnológica
                $queryLinea = LineaTecnologica::where('nombre', $row['linea'])->first();
                $vLinea = $this->validaciones->validarQuery($queryLinea, $row['linea'], $key, 'Línea tecnológica', $this->hoja);
                if (!$vLinea) {
                    return $vLinea;
                }

                $user = User::where('documento', $documento)->withTrashed()->first();
                $user_email = User::where('email', $row['correo'])->withTrashed()->first();

                $ocupaciones = explode(',', $row['ocupaciones']);
                $ocupaciones = $this->getOcupaciones($ocupaciones);

                if ($user == null) {
                    // No hay registrado
                    if ($user_email == null) {
                        // en caso de que el correo no se encuentra registrado
                        // Registrar nueva talento
                        $user = $this->registrarUser($row, $queryTipoDocumento, $queryGradoEscolaridad, $queryGrupoSanguineo, $queryEps, $queryCiudadResidencia, $queryCiudadExpedicion, $ocupaciones[1]);
                        $user->ocupaciones()->sync($ocupaciones[0], false);
                        $this->registrarGestor($user, $queryLinea, $row['honorarios']);
                    } else {
                        // El correo ya se encuentra registrado en un usuario
                        return $this->validaciones->errorValidacionCorreo($row['correo'], $key, $user_email->documento, $this->hoja);
                    }
                } else {
                    // El usuario existe - Cambia información
                    if ($user_email != null && $user_email->documento == $documento) {
                        // Permite actualizar la información porque el correo le pertenece a la persona
                        // Cambia la información actual
                        $this->updateUser($user, $row, $queryTipoDocumento, $queryGradoEscolaridad, $queryGrupoSanguineo, $queryEps, $queryCiudadResidencia, $queryCiudadExpedicion, $ocupaciones[1]);
                        $user->ocupaciones()->sync($ocupaciones[0], true);
                        $this->updateGestor($user, $queryLinea, $row['honorarios']);
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

    private function updateGestor($user, $linea, $honorarios)
    {
        $user->experto->update([
            "user_id" => $user->id,
            "nodo_id" => $this->nodo,
            "lineatecnologica_id" => $linea->id,
            "honorarios" => $honorarios
        ]);
    }

    private function updateUser($user, $row, $tipo_documento, $grado_escolaridad, $grupo_sanguineo, $eps, $ciudad_residencia, $ciudad_expedicion, $otra_ocupacion)
    {
        return $user->update([
            "tipodocumento_id" => $tipo_documento->id,
            "gradoescolaridad_id" => $grado_escolaridad == null ? null : $grado_escolaridad->id,
            "gruposanguineo_id" => $grupo_sanguineo->id,
            "eps_id" => $eps->id,
            "ciudad_id" => $ciudad_residencia->id,
            "ciudad_expedicion_id" => $ciudad_expedicion->id,
            "nombres" => $row['nombres'],
            "apellidos" => $row['apellidos'],
            "email" => $row['correo'],
            "barrio" => $row['barrio'],
            "celular" => $row['celular'],
            "telefono" => $row['telefono'],
            "fechanacimiento" => $row['fecha_nacimiento'],
            "genero" => $row['genero'] == 'FEMENINO' ? 0 : 1,
            "otra_eps" => $eps->nombre == 'Otra' ? $row['otra_eps'] : null,
            "institucion" => $row['institucion'],
            "titulo_obtenido" => $row['titulo_obtenido'],
            "fecha_terminacion" => $row['fecha_terminacion'],
            "estrato" => $row['estrato'],
            "otra_ocupacion" => $otra_ocupacion
        ]);
    }

    private function getOcupaciones($ocupaciones)
    {
        $otra_ocupacion = null;
        $ocupaciones_foraneas = array();
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
        return [$ocupaciones_foraneas, $otra_ocupacion];
    }

    private function registrarGestor($user, $linea, $honorarios)
    {
        Gestor::create([
            "user_id" => $user->id,
            "nodo_id" => $this->nodo,
            "lineatecnologica_id" => $linea->id,
            "honorarios" => $honorarios
        ]);
    }

    private function registrarUser($row, $tipo_documento, $grado_escolaridad, $grupo_sanguineo, $eps, $ciudad_residencia, $ciudad_expedicion, $otra_ocupacion)
    {
        return User::create([
            "tipodocumento_id" => $tipo_documento->id,
            "gradoescolaridad_id" => $grado_escolaridad == null ? null : $grado_escolaridad->id,
            "gruposanguineo_id" => $grupo_sanguineo->id,
            "eps_id" => $eps->id,
            "ciudad_id" => $ciudad_residencia->id,
            "ciudad_expedicion_id" => $ciudad_expedicion->id,
            "nombres" => $row['nombres'],
            "apellidos" => $row['apellidos'],
            "documento" => $row['documento'],
            "email" => $row['correo'],
            "barrio" => $row['barrio'],
            "celular" => $row['celular'],
            "telefono" => $row['telefono'],
            "fechanacimiento" => $row['fecha_nacimiento'],
            "genero" => $row['genero'] == 'FEMENINO' ? 0 : 1,
            "otra_eps" => $eps->nombre == 'Otra' ? $row['otra_eps'] : null,
            "estado" => User::IsInactive(),
            "institucion" => $row['institucion'],
            "titulo_obtenido" => $row['titulo_obtenido'],
            "fecha_terminacion" => $row['fecha_terminacion'],
            "estrato" => $row['estrato'],
            "otra_ocupacion" => $otra_ocupacion
        ]);
    }
}
