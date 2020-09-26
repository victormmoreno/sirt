<?php

namespace App\Imports;

use App\Models\{
    Ciudad,
    Entidad,
    Eps,
    TipoTalento,
    GradoEscolaridad,
    GrupoSanguineo,
    Ocupacion,
    Talento,
    TipoDocumento,
    TipoEstudio,
    TipoFormacion
};
use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\{DB};
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TalentosImport implements ToCollection, WithHeadingRow
{
    public $validaciones;
    public $hoja;
    public function __construct()
    {
        $this->validaciones = new ValidacionesImport;
        $this->hoja = 'Talentos';
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
                $vGenero = $this->validarGenero($row['genero'], $key);
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
                // $vGradoEscolaridad = $this->validarQuery($queryGradoEscolaridad, $row['grado_escolaridad'], $key, 'Grado de escolaridad');
                // if (!$vGradoEscolaridad) {
                //     return $vGradoEscolaridad;
                // }
                // Validar tipo de talento
                $queryTipoTalento = TipoTalento::where('nombre', $row['tipo_talento'])->first();
                $vTipoTalento = $this->validaciones->validarQuery($queryTipoTalento, $row['tipo_talento'], $key, 'Tipo de talento', $this->hoja);
                if (!$vTipoTalento) {
                    return $vTipoTalento;
                }
                // Validar tipo de formación
                $queryTipoFormacion = TipoFormacion::where('nombre', $row['tipo_formacion'])->first();
                // if ($queryTipoTalento->nombre == 'Egresado SENA') {
                //     $vTipoFormacion = $this->validarQuery($queryTipoFormacion, $row['tipo_formacion'], $key, 'Tipo de formación');
                //     if (!$vTipoFormacion) {
                //         return $vTipoFormacion;
                //     }
                // }

                // Validar tipo de estudio
                $queryTipoEstudioUniversidad = TipoEstudio::where('nombre', $row['tipo_estudio_universidad'])->first();
                // if ($queryTipoTalento->nombre == 'Estudiante Universitario') {
                //     $vTipoEstudioUniversidad = $this->validarQuery($queryTipoEstudioUniversidad, $row['tipo_formacion'], $key, 'Tipo de estudio universitario');
                //     if (!$vTipoEstudioUniversidad) {
                //         return $vTipoEstudioUniversidad;
                //     }
                // }

                $user = User::where('documento', $documento)->withTrashed()->first();
                $user_email = User::where('email', $row['correo'])->withTrashed()->first();

                $ocupaciones = explode(',', $row['ocupaciones']);
                $ocupaciones = $this->getOcupaciones($ocupaciones);

                $tipo_formacion_id = $this->getTipoFormacion($queryTipoTalento, $queryTipoFormacion);
                $datos_universidad = $this->getDatosUniversitarios($row, $queryTipoTalento, $queryTipoEstudioUniversidad);
                $entidad_id = $this->getEntidad($row, $queryTipoTalento);
                $dependencia = $this->getDependencia($row, $queryTipoTalento);
                $empresa = $this->getEmpresaFuncionario($row, $queryTipoTalento);
                if ($user == null) {
                    // No hay registrado
                    if ($user_email == null) {
                        // en caso de que el correo no se encuentra registrado
                        // Registrar nueva talento
                        $user = $this->registrarUser($row, $queryTipoDocumento, $queryGradoEscolaridad, $queryGrupoSanguineo, $queryEps, $queryCiudadResidencia, $queryCiudadExpedicion, $ocupaciones[1]);
                        $user->ocupaciones()->sync($ocupaciones[0], false);
                        $this->registrarTalento($row['programa_formacion'], $user, $queryTipoTalento, $tipo_formacion_id, $datos_universidad, $entidad_id, $dependencia, $empresa);
                    } else {
                        // El correo ya se encuentra registrado en un usuario
                        // dd('registra nueva usuario con correo existente - ERROR' . ($key+2));
                        return $this->errorValidacionCorreo($row['correo'], $key, $user_email->documento);
                    }
                } else {
                    // El usuario existe - Cambia información
                    if ($user_email != null && $user_email->documento == $documento) {
                        // Permite actualizar la información porque el correo le pertenece a la persona
                        // Cambia la información actual
                        $this->updateUser($user, $row, $queryTipoDocumento, $queryGradoEscolaridad, $queryGrupoSanguineo, $queryEps, $queryCiudadResidencia, $queryCiudadExpedicion, $ocupaciones[1]);
                        $user->ocupaciones()->sync($ocupaciones[0], true);
                        $this->updateTalento($row['programa_formacion'], $user, $queryTipoTalento, $tipo_formacion_id, $datos_universidad, $entidad_id, $dependencia, $empresa);
                    } else {
                        // No permite actualizar la información porque el correo se encuentra asociado a otra persona
                        return $this->errorValidacionCorreo($row['correo'], $key, $user->documento);
                        // if ($user_email == null) {
                        //     return $this->errorValidacionCorreo($row['correo'], $key, $user->documento);
                        // } else {
                        //     return $this->errorValidacionCorreo($row['correo'], $key, $user_email->documento);
                        // }
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

    private function errorValidacionCorreo($email, $i, $documento_registrado)
    {
        session()->put('errorMigracion', 'Error en la hoja de "Talentos": El correo ' . $email . ' en el registro de la fila #' . ($i+2) . ' ya se encuentra asociado al usuario con número de cédula: '.$documento_registrado.' (No se permite la duplicación de correos).');
        return false;
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
            "direccion" => $row['direccion'],
            "celular" => $row['celular'],
            "telefono" => $row['telefono'],
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

    private function updateTalento($programa, $user, $tipo_talento, $tipo_formacion, array $datos_universidad, $entidad_id, $dependencia, $empresa)
    {
        return $user->talento()->update([
            "user_id" => $user->id,
            "tipo_talento_id" => $tipo_talento == null ? null : $tipo_talento->id,
            "entidad_id" => $entidad_id,
            "programa_formacion" => $programa,
            "tipo_formacion_id" => $tipo_formacion,
            "universidad" => $datos_universidad[0],
            "carrera_universitaria" => $datos_universidad[1],
            "tipo_estudio_id" => $datos_universidad[2],
            "dependencia" => $dependencia,
            "empresa" => $empresa
        ]);
    }

    private function getEntidad($row, $tipo_talento)
    {
        $entidad_id = null;

        if ($tipo_talento != null) {
            if ($tipo_talento->nombre == TipoTalento::where('nombre', TipoTalento::IS_APRENDIZ_SENA_SIN_APOYO)->first()->nombre || 
            $tipo_talento->nombre == TipoTalento::where('nombre', TipoTalento::IS_APRENDIZ_SENA_CON_APOYO)->first()->nombre || 
            $tipo_talento->nombre == TipoTalento::where('nombre', TipoTalento::IS_EGRESADO_SENA)->first()->nombre ) {
                
                $entidad_id = Entidad::where('nombre', $row['centro_formacion'])->first();
                if ($entidad_id != null) {
                    $entidad_id = $entidad_id->id;
                }
            }
    
            if ($tipo_talento->nombre == TipoTalento::where('nombre', TipoTalento::IS_FUNCIONARIO_SENA)->first()->nombre) {
                $entidad_id = Entidad::where('nombre', $row['centro_formacion_funcionario'])->first();
                if ($entidad_id != null) {
                    $entidad_id = $entidad_id->id;
                }
            }
    
            if ($tipo_talento->nombre == TipoTalento::where('nombre', TipoTalento::IS_INSTRUCTOR_SENA)->first()->nombre) {
                $entidad_id = Entidad::where('nombre', $row['centro_formacion_instructor'])->first();
                if ($entidad_id != null) {
                    $entidad_id = $entidad_id->id;
                }
            }
        }

        return $entidad_id;
    }

    private function getDatosUniversitarios($row, $tipo_talento, $tipo_estudio)
    {
        $universidad = null;
        $carrera = null;
        $tipo_estudio_id = null;
        if ($tipo_talento != null) {
            if ($tipo_talento->nombre == TipoTalento::where('nombre', TipoTalento::IS_ESTUDIANTE_UNIVERSITARIO)->first()->nombre) {
                $universidad = $row['universidad'];
                $carrera = $row['nombre_carrera'];
                if ($tipo_estudio != null) {
                    $tipo_estudio_id = $tipo_estudio->id;
                }
            }
        }
        return [$universidad, $carrera, $tipo_estudio_id];
    }

    private function getTipoFormacion($tipo_talento, $tipo_formacion) {
        $tipo_formacion_id = null;
        if ($tipo_talento != null) {
            if ($tipo_talento->nombre == TipoTalento::where('nombre', TipoTalento::IS_EGRESADO_SENA)->first()->nombre) {
                if ($tipo_formacion != null) {
                    $tipo_formacion_id = $tipo_formacion->id;
                }
            }
        }
        return $tipo_formacion_id;
    }

    private function getDependencia($row, $tipo_talento)
    {
        $dependencia = null;
        if ($tipo_talento != null) {
            if ($tipo_talento->nombre == TipoTalento::where('nombre', TipoTalento::IS_FUNCIONARIO_SENA)->first()->nombre) {
                $dependencia = $row['dependencia_funcionario'];
            }
        }
        return $dependencia;
    }

    private function getEmpresaFuncionario($row, $tipo_talento)
    {
        $empresa = null;
        if ($tipo_talento != null) {
            if ($tipo_talento->nombre == TipoTalento::where('nombre', TipoTalento::IS_FUNCIONARIO_EMPRESA)->first()->nombre) {
                $empresa = $row['nombre_empresa'];
            }
        }
        return $empresa;
    }

    private function registrarTalento($programa, $user, $tipo_talento, $tipo_formacion, array $datos_universidad, $entidad_id, $dependencia, $empresa)
    {
        
        return Talento::create([
            "user_id" => $user->id,
            "tipo_talento_id" => $tipo_talento == null ? null : $tipo_talento->id,
            "entidad_id" => $entidad_id,
            "programa_formacion" => $programa,
            "tipo_formacion_id" => $tipo_formacion,
            "universidad" => $datos_universidad[0],
            "carrera_universitaria" => $datos_universidad[1],
            "tipo_estudio_id" => $datos_universidad[2],
            "dependencia" => $dependencia,
            "empresa" => $empresa
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
            "direccion" => $row['direccion'],
            "celular" => $row['celular'],
            "telefono" => $row['telefono'],
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

    private function validarGenero($genero, $i)
    {
        if ($genero != 'MASCULINO' && $genero != 'FEMENINO') {
            session()->put('errorMigracion', 'Error en la hoja de "Talentos": El género ' . $genero . ' en el registro de la fila #' . ($i+2) . ' no es válido (MASCULINO O FEMENINO).');
            return false;
        }
        return true;
    }
    
}
