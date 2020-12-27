<?php

namespace App\Imports;

use App\Models\{Actividad, AreaConocimiento, Fase, ArticulacionProyecto, GrupoInvestigacion, Proyecto, Sublinea, Idea, Empresa, Entidad};
use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\{DB};
use Maatwebsite\Excel\Concerns\ToCollection;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProyectosImport implements ToCollection, WithHeadingRow
{
    public $nodo;
    public $ideaRepository;
    public $validaciones;
    public $hoja = 'Proyectos';

    public function __construct($nodo)
    {
        $this->nodo = $nodo;
        $this->validaciones = new ValidacionesImport;
    }
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $validacion = null;
        try {
            foreach ($rows as $key => $row) {
                // quitar espacios a los campos que no los necesita
                $row['documento_gestor'] = str_replace(' ', '', $row['documento_gestor']);
                $row['documento_gestor'] = ltrim(rtrim($row['documento_gestor']));
                $row['talento_duenho'] = str_replace(' ', '', $row['talento_duenho']);
                $row['talentos_ejecutores'] = str_replace(' ', '', $row['talentos_ejecutores']);
                $row['empresa_duenha'] = str_replace(' ', '', $row['empresa_duenha']);
                $row['grupo_investigacion_duenho'] = str_replace(' ', '', $row['grupo_investigacion_duenho']);
                $row['trl_esperado'] = ltrim(rtrim($row['trl_esperado']));
                $row['trl_obtenido'] = ltrim(rtrim($row['trl_obtenido']));
                // Mayúsculas
                $row['cumplio_primer_objetivo'] = strtoupper($row['cumplio_primer_objetivo']);
                $row['cumplio_segundo_objetivo'] = strtoupper($row['cumplio_segundo_objetivo']);
                $row['cumplio_tercer_objetivo'] = strtoupper($row['cumplio_tercer_objetivo']);
                $row['cumplio_cuarto_objetivo'] = strtoupper($row['cumplio_cuarto_objetivo']);
                $row['area_emprendiemiento_sena'] = strtoupper($row['area_emprendiemiento_sena']);
                $row['economia_naranja'] = strtoupper($row['economia_naranja']);
                $row['proyecto_dirigido_discapacitados'] = strtoupper($row['proyecto_dirigido_discapacitados']);
                $row['articulado_cti'] = strtoupper($row['articulado_cti']);
                $row['fabrica_productividad'] = strtoupper($row['fabrica_productividad']);

                // Validar número de documento del gestor
                $gestor = User::where('documento', $row['documento_gestor'])->withTrashed()->first();
                $validacion = $this->validaciones->validarQuery($gestor, $row['documento_gestor'], $key, 'Número de documento del gestor', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }
                // Validar nombre del proyecto
                $validacion = $this->validaciones->validarCelda($row['nombre_proyecto'], $key, 'Nombre del proyecto', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }
                $validacion = $this->validaciones->validarCelda($row['fecha_inicio'], $key, 'Fecha de inicio', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }
                $validacion = $this->validaciones->validarCelda($row['fecha_cierre'], $key, 'Fecha de cierre', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }
                $validacion = $this->validaciones->validarTamanhoCelda($row['nombre_proyecto'], $key, 'Nombre del proyecto', 500, $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                $validacion = $this->validaciones->validarTamanhoCelda($row['actor_cti'], $key, 'Actor CT+i', 50, $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }
                $validacion = $this->validaciones->validarTamanhoCelda($row['tipo_discapacitado'], $key, 'Tipo de discapacidad', 100, $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }
                // Validar fecha de inicio del proyecto
                $validacion = $this->validaciones->validarFecha($row['fecha_inicio'], $key, 'Fecha de inicio', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }
                // Validar fecha de cierre del proyecto
                $validacion = $this->validaciones->validarFecha($row['fecha_cierre'], $key, 'Fecha de cierre', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }
                // Validar área de conocimiento
                $area_conocimiento = AreaConocimiento::where('nombre', $row['area_conocimiento'])->first();
                $validacion = $this->validaciones->validarQuery($area_conocimiento, $row['area_conocimiento'], $key, 'Área de conocimiento', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }
                if ($area_conocimiento->nombre != 'Otro') {
                    $row['otra_area_conocimento'] = null;
                }
                // Validar sublínea
                $sublinea = Sublinea::where('nombre', $row['sublinea'])->first();
                $validacion = $this->validaciones->validarQuery($sublinea, $row['sublinea'], $key, 'Sublínea', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }
                // Validar trl esperado
                // $validacion = $this->validarTrl($row['trl_esperado'], $key, 'esperado');
                // if (!$validacion) {
                //     return $validacion;
                // }
                // Validar	objetivo_general
                $validacion = $this->validaciones->validarTamanhoCelda($row['objetivo_general'], $key, 'Objetivo general del proyecto', 500, $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }
                // Validar	conclusiones	
                $validacion = $this->validaciones->validarTamanhoCelda($row['conclusiones'], $key, 'Conclusiones del proyecto', 1000, $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }
                // Validar	alcance_proyecto
                $validacion = $this->validaciones->validarTamanhoCelda($row['alcance_proyecto'], $key, 'Alcance del proyecto', 1000, $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }
                // Validar	primer_objetivo
                $validacion = $this->validaciones->validarTamanhoCelda($row['primer_objetivo'], $key, 'Primer objetivo del proyecto', 500, $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }
                // Validar	segundo_objetivo
                $validacion = $this->validaciones->validarTamanhoCelda($row['segundo_objetivo'], $key, 'Segundo objetivo del proyecto', 500, $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }
                // Validar	tercer_objetivo
                $validacion = $this->validaciones->validarTamanhoCelda($row['tercer_objetivo'], $key, 'Tercer objetivo del proyecto', 500, $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }
                // Validar	cuarto_objetivo
                $validacion = $this->validaciones->validarTamanhoCelda($row['cuarto_objetivo'], $key, 'Cuarto objetivo del proyecto', 500, $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }
                // Validar trl obtenido
                // $validacion = $this->validarTrl($row['trl_obtenido'], $key, 'obtenido');
                // if (!$validacion) {
                //     return $validacion;
                // }
                // Validar las evidencias producto: prototipo_producto
                $validacion = $this->validaciones->validarTamanhoCelda($row['prototipo_producto'], $key, 'Prototipo producto del proyecto', 300, $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }
                // modelo_negocio
                $validacion = $this->validaciones->validarTamanhoCelda($row['modelo_negocio'], $key, 'Modelo de negocio del proyecto', 300, $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }
                // pruebas_documentadas
                $validacion = $this->validaciones->validarTamanhoCelda($row['pruebas_documentadas'], $key, 'Pruebas documentadas del proyecto', 300, $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }
                // evidencias_normatividad
                $validacion = $this->validaciones->validarTamanhoCelda($row['evidencias_normatividad'], $key, 'Evidencias de normatividad del proyecto', 300, $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                $talentos = explode(',', $row['talentos_ejecutores']);
                // dd($talentos);
                
                $actividad = Actividad::where('codigo_actividad', $row['codigo_proyecto'])->first();
                $idea_id = $this->getIdeaProyecto($row['codigo_idea'], $key);
                $entidad_id = Entidad::where('nombre', 'No Aplica')->get()->last()->id;
                
                if ($actividad == null) {
                    // Registrar nuevo proyecto
                    $codigo_actividad = $this->generarCodigoDeProyecto($row['codigo_proyecto'], $sublinea, $gestor, $row['fecha_inicio']);
                    $actividad = $this->registrarNuevaActividad($codigo_actividad, $row, $gestor);
                    $articulacion_proyecto = $this->registrarArticulacionProyecto($actividad, $entidad_id);
                    $this->registrarNuevoProyecto($actividad, $row, $idea_id, $area_conocimiento->id, $sublinea->id, $talentos);
                } else {
                    // Actualizar proyecto existente
                    if ($this->nodo == $actividad->nodo_id) {
                        $this->actualizarActividadExistente($actividad, $gestor, $row);
                        if ($actividad->articulacion_proyecto == null) {
                            $this->registrarArticulacionProyecto($actividad, $entidad_id);
                        }
                        if ($actividad->articulacion_proyecto->proyecto == null) {
                            $this->registrarNuevoProyecto($actividad, $row, $idea_id, $area_conocimiento->id, $sublinea->id, $talentos);
                        } else {
                            $this->actualizarProyectoExistente($actividad, $row, $idea_id, $area_conocimiento->id, $sublinea->id, $talentos);
                        }
                    } else {
                        session()->put('errorMigracion', 'Error en la hoja de "'.$this->hoja.'": El código de proyecto '.$row['codigo_proyecto'].' en el registro de la fila #' . ($key+2) . ' ya se encuentra registrado en un proyecto del nodo '.$actividad->nodo->entidad->nombre.' 
                        (Se recomienda cambiar el código de los proyecto, ya que la base de datos no permite códigos duplicados).');
                    }
                }
            }
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
            return false;
        }
    }

    private function obtenerTalentosProyecto($talentos_ejecutores, $talento_lider)
    {
        // $talento_temporal = null;
        $talentos = array();
        if (count($talentos_ejecutores) != 0) {
            for ($i=0; $i < count($talentos_ejecutores) ; $i++) { 
                $talento_temporal = User::where('documento', $talentos_ejecutores[$i])->withTrashed()->first();
                if ($talento_temporal != null) {
                    if ($talento_temporal->talento != null) {
                        if ($talentos_ejecutores[$i] == $talento_lider) {
                            $talentos[$i] = array('talento_lider' => 1, 'talento_id' => $talento_temporal->talento->id);
                        } else {
                            $talentos[$i] = array('talento_lider' => 0, 'talento_id' => $talento_temporal->talento->id);
                        }
                    }
                }
            }
        }

        return $talentos;
    }

    private function obtenerUsersPropietarios($users_duenhos)
    {
        $arrUsers = explode(',', $users_duenhos);
        $user_temporal = null;
        $duenhos = array();
        if (count($arrUsers) != 0) {
            for ($i=0; $i < count($arrUsers) ; $i++) { 
                $user_temporal = User::where('documento', $arrUsers[$i])->withTrashed()->first();
                if ($user_temporal != null) {
                    $duenhos[$i] = $user_temporal->id;
                }
            }
        }

        return $duenhos;
    }

    private function obtenerEmpresasPropietarias($empresas_duenhas)
    {
        $arrEmpresas = explode(',', $empresas_duenhas);
        $empresa_temporal = null;
        $duenhos = array();
        if (count($arrEmpresas) != 0) {
            for ($i=0; $i < count($arrEmpresas) ; $i++) { 
                $empresa_temporal = Empresa::where('nit', $arrEmpresas[$i])->first();
                if ($empresa_temporal != null) {
                    $duenhos[$i] = $empresa_temporal->id;
                }
            }
        }

        return $duenhos;
    }

    private function obtenerGruposPropietarios($grupos_duenhos)
    {
        $arrGrupos = explode(',', $grupos_duenhos);
        $grupo_temporal = null;
        $duenhos = array();
        if (count($arrGrupos) != 0) {
            for ($i=0; $i < count($arrGrupos) ; $i++) { 
                $grupo_temporal = GrupoInvestigacion::where('codigo_grupo', $arrGrupos[$i])->first();
                if ($grupo_temporal != null) {
                    $duenhos[$i] = $grupo_temporal->id;
                }
            }
        }
        return $duenhos;
    }

    private function getTrlObtenido($trl)
    {
        $trl_obtenido = null;

        if ($trl == 'TRL 6') {
            $trl_obtenido = 0;
        }
        if ($trl == 'TRL 7') {
            $trl_obtenido = 1;
        }
        if ($trl == 'TRL 8') {
            $trl_obtenido = 2;
        }

        return $trl_obtenido;
    }

    private function getTrlEsperado($trl)
    {
        $trl_esperado = null;
        if ($trl == 'TRL 7' || $trl == 'TRL 8' || $trl == 'TRL 7 - TRL 8') {
            $trl_esperado = Proyecto::IsTrl78Esperado();
        }
        if ($trl == 'TRL 6') {
            $trl_esperado = Proyecto::IsTrl6Esperado();
        }
        return $trl_esperado;
    }

    private function getIdeaProyecto($codigo_idea, $key)
    {
        $idea_id = null;
        if ($codigo_idea == null) {
            $idea_id = Idea::where('codigo_idea', '#0000')->first()->id;
        } else {
            $idea = Idea::where('codigo_idea', $codigo_idea)->first();
            if ($idea == null) {
                $idea_id = Idea::where('codigo_idea', '#0000')->first()->id;
            } else {
                $idea_id = $idea->id;
            }
        }
        return $idea_id;
    }

    private function generarCodigoDeProyecto($codigo_excel, $sublinea, $user_gestor, $fecha_inicio)
    {
        $codigo_proyecto = $codigo_excel;
        if ($codigo_proyecto == null) {
            $anho = Carbon::parse($fecha_inicio)->isoFormat('YYYY');
            $tecnoparque = sprintf("%02d", $this->nodo);
            $linea = $sublinea->linea->id;
            $gestor = sprintf("%03d", $user_gestor->gestor->id);
            $idProyecto = Proyecto::selectRaw('MAX(id+1) AS max')->get()->last();
            $idProyecto->max == null ? $idProyecto->max = 1 : $idProyecto->max = $idProyecto->max;
            $idProyecto->max = sprintf("%04d", $idProyecto->max);
        
            return 'P' . $anho . '-' . $tecnoparque . $linea . $gestor . '-' . $idProyecto->max;
        }
        return $codigo_proyecto;
    }
    private function registrarNuevaActividad($codigo_actividad, $row, $user_gestor)
    {
        return Actividad::create([
            'gestor_id' => $user_gestor->gestor->id,
            'nodo_id' => $this->nodo,
            'codigo_actividad' => $codigo_actividad,
            'nombre' => $row['nombre_proyecto'],
            'fecha_inicio' => $row['fecha_inicio'],
            'fecha_cierre' => $row['fecha_cierre'],
            'conclusiones' => $row['conclusiones'],
            'objetivo_general' => $row['objetivo_general']
          ]);
    }

    private function registrarArticulacionProyecto($actividad, $entidad_id)
    {
        return ArticulacionProyecto::create([
            'entidad_id' => $entidad_id,
            'actividad_id' => $actividad->id
          ]);
    }

    private function registrarNuevoProyecto($actividad, $row, $idea_id, $area_conocimiento_id, $sublinea_id, $talentos)
    {
        $trl_esperado = $this->getTrlEsperado($row['trl_esperado']);
        $trl_obtenido = $this->getTrlObtenido($row['trl_obtenido']);

        $proyecto = Proyecto::create([
          'articulacion_proyecto_id' => $actividad->articulacion_proyecto->id,
          'fase_id' => Fase::where('nombre', 'Cierre')->first()->id,
          'idea_id' => $idea_id,
          'areaconocimiento_id' => $area_conocimiento_id,
          'otro_areaconocimiento' => $row['otra_area_conocimento'],
          'sublinea_id' => $sublinea_id,
          'trl_esperado' => $trl_esperado,
          'reci_ar_emp' => $row['area_emprendiemiento_sena'] == 'SI' ? 1 : 0,
          'economia_naranja' => $row['economia_naranja'] == 'SI' ? 1 : 0,
          'tipo_economianaranja' => $row['economia_naranja'] == 'SI' ? $row['tipo_economia_naranja'] : null,
          'dirigido_discapacitados' => $row['proyecto_dirigido_discapacitados'] == 'SI' ? 1 : 0,
          'tipo_discapacitados' => $row['proyecto_dirigido_discapacitados'] == 'SI' ? $row['tipo_discapacitado'] : null,
          'art_cti' => $row['articulado_cti'] == 'SI' ? 1 : 0,
          'nom_act_cti' => $row['articulado_cti'] == 'SI' ? $row['actor_cti'] : null,
          'alcance_proyecto' => $row['alcance_proyecto'],
          'fabrica_productividad' => $row['fabrica_productividad'] == 'SI' ? 1 : 0,
          'trl_obtenido' => $trl_obtenido,
          'trl_prototipo' => $row['prototipo_producto'],
          'trl_modelo' => $row['modelo_negocio'],
          'trl_pruebas' => $row['pruebas_documentadas'],
          'trl_normatividad' => $row['evidencias_normatividad']
        ]);
      
          $syncData = array();
          $syncData = $this->obtenerTalentosProyecto($talentos, $row['talento_interlocutor']);
          
          $actividad->articulacion_proyecto->talentos()->sync($syncData, false);
          
          $actividad->objetivos_especificos()->create([
            'objetivo' => $row['primer_objetivo'] == null ? 'No registra' : $row['primer_objetivo'],
            'cumplido' => $row['cumplio_primer_objetivo'] == 'SI' ? 1 : 0
          ]);
    
          $actividad->objetivos_especificos()->create([
            'objetivo' => $row['segundo_objetivo'] == null ? 'No registra' : $row['segundo_objetivo'],
            'cumplido' => $row['cumplio_segundo_objetivo'] == 'SI' ? 1 : 0
          ]);
    
          $actividad->objetivos_especificos()->create([
            'objetivo' => $row['tercer_objetivo'] == null ? 'No registra' : $row['tercer_objetivo'],
            'cumplido' => $row['cumplio_tercer_objetivo'] == 'SI' ? 1 : 0
          ]);
    
          $actividad->objetivos_especificos()->create([
            'objetivo' => $row['cuarto_objetivo'] == null ? 'No registra' : $row['cuarto_objetivo'],
            'cumplido' => $row['cumplio_cuarto_objetivo'] == 'SI' ? 1 : 0
          ]);

          $users_propietarios = array();
          $users_propietarios = $this->obtenerUsersPropietarios($row['talento_duenho']);
          $proyecto->users_propietarios()->attach($users_propietarios);

          $empresas_propietarias = array();
          $empresas_propietarias = $this->obtenerEmpresasPropietarias($row['empresa_duenha']);
          $proyecto->empresas()->attach($empresas_propietarias);
          
          $grupos_duenhos = array();
          $grupos_duenhos = $this->obtenerGruposPropietarios($row['grupo_investigacion_duenho']);
          $proyecto->gruposinvestigacion()->attach($grupos_duenhos);
    }

    private function actualizarActividadExistente($actividad, $user_gestor, $row)
    {
        return $actividad->update([
            'gestor_id' => $user_gestor->gestor->id,
            // 'nodo_id' => $this->nodo,
            'nombre' => $row['nombre_proyecto'],
            'fecha_inicio' => $row['fecha_inicio'],
            'fecha_cierre' => $row['fecha_cierre'],
            'conclusiones' => $row['conclusiones'],
            'objetivo_general' => $row['objetivo_general']
        ]);
    }

    private function actualizarProyectoExistente($actividad, $row, $idea_id, $area_conocimiento_id, $sublinea_id, $talentos)
    {
        $trl_esperado = $this->getTrlEsperado($row['trl_esperado']);
        $trl_obtenido = $this->getTrlObtenido($row['trl_obtenido']);
        

            
        $actividad->articulacion_proyecto->proyecto->update([
              'fase_id' => Fase::where('nombre', 'Cierre')->first()->id,
              'idea_id' => $idea_id,
              'areaconocimiento_id' => $area_conocimiento_id,
              'otro_areaconocimiento' => $row['otra_area_conocimento'],
              'sublinea_id' => $sublinea_id,
              'trl_esperado' => $trl_esperado,
              'reci_ar_emp' => $row['area_emprendiemiento_sena'] == 'SI' ? 1 : 0,
              'economia_naranja' => $row['economia_naranja'] == 'SI' ? 1 : 0,
              'tipo_economianaranja' => $row['economia_naranja'] == 'SI' ? $row['tipo_economia_naranja'] : null,
              'dirigido_discapacitados' => $row['proyecto_dirigido_discapacitados'] == 'SI' ? 1 : 0,
              'tipo_discapacitados' => $row['proyecto_dirigido_discapacitados'] == 'SI' ? $row['tipo_discapacitado'] : null,
              'art_cti' => $row['articulado_cti'] == 'SI' ? 1 : 0,
              'nom_act_cti' => $row['actor_cti'] == 'SI' ? $row['actor_cti'] : null,
              'alcance_proyecto' => $row['alcance_proyecto'],
              'fabrica_productividad' => $row['fabrica_productividad'] == 'SI' ? 1 : 0,
              'trl_obtenido' => $trl_obtenido,
              'trl_prototipo' => $row['prototipo_producto'],
              'trl_modelo' => $row['modelo_negocio'],
              'trl_pruebas' => $row['pruebas_documentadas'],
              'trl_normatividad' => $row['evidencias_normatividad']
        ]);
              
              
        $syncData = array();
        $syncData = $this->obtenerTalentosProyecto($talentos, $row['talento_interlocutor']);
              
        $actividad->articulacion_proyecto->talentos()->sync($syncData, true);

        // Primero objetivo especifico
        if ($actividad->objetivos_especificos->get(0) == null) {
            $actividad->objetivos_especificos()->create([
                'objetivo' => $row['primer_objetivo'] == null ? 'No registra' : $row['primer_objetivo'],
                'cumplido' => $row['cumplio_primer_objetivo'] == 'SI' ? 1 : 0
            ]);
        } else {
            $actividad->objetivos_especificos->get(0)->update([
                'objetivo' => $row['primer_objetivo'] == null ? 'No registra' : $row['primer_objetivo'],
                'cumplido' => $row['cumplio_primer_objetivo'] == 'SI' ? 1 : 0
            ]);
        }

        // Segundo objetivo específico
        if ($actividad->objetivos_especificos->get(1) == null) {
            $actividad->objetivos_especificos()->create([
                'objetivo' => $row['segundo_objetivo'] == null ? 'No registra' : $row['segundo_objetivo'],
                'cumplido' => $row['cumplio_segundo_objetivo'] == 'SI' ? 1 : 0
                ]);
        } else {
            $actividad->objetivos_especificos->get(1)->update([
                'objetivo' => $row['segundo_objetivo'] == null ? 'No registra' : $row['segundo_objetivo'],
                'cumplido' => $row['cumplio_segundo_objetivo'] == 'SI' ? 1 : 0
            ]);
        }

        // Tercer objetivo específico
        if ($actividad->objetivos_especificos->get(2) == null) {
            $actividad->objetivos_especificos()->create([
                'objetivo' => $row['tercer_objetivo'] == null ? 'No registra' : $row['tercer_objetivo'],
                'cumplido' => $row['cumplio_tercer_objetivo'] == 'SI' ? 1 : 0
                ]);
        } else {
            $actividad->objetivos_especificos->get(2)->update([
                'objetivo' => $row['tercer_objetivo'] == null ? 'No registra' : $row['tercer_objetivo'],
                'cumplido' => $row['cumplio_tercer_objetivo'] == 'SI' ? 1 : 0
            ]);
        }

        // Cuarto objetivo específico
        if ($actividad->objetivos_especificos->get(3) == null) {
            $actividad->objetivos_especificos()->create([
                'objetivo' => $row['cuarto_objetivo'] == null ? 'No registra' : $row['cuarto_objetivo'],
                'cumplido' => $row['cumplio_cuarto_objetivo'] == 'SI' ? 1 : 0
                ]);
        } else {
            $actividad->objetivos_especificos->get(3)->update([
                'objetivo' => $row['cuarto_objetivo'] == null ? 'No registra' : $row['cuarto_objetivo'],
                'cumplido' => $row['cumplio_cuarto_objetivo'] == 'SI' ? 1 : 0
            ]);
        }

        $actividad->articulacion_proyecto->proyecto->users_propietarios()->detach();
        $actividad->articulacion_proyecto->proyecto->empresas()->detach();
        $actividad->articulacion_proyecto->proyecto->gruposinvestigacion()->detach();

        $users_propietarios = array();
        $users_propietarios = $this->obtenerUsersPropietarios($row['talento_duenho']);
        $actividad->articulacion_proyecto->proyecto->users_propietarios()->attach($users_propietarios);

        $empresas_propietarias = array();
        $empresas_propietarias = $this->obtenerEmpresasPropietarias($row['empresa_duenha']);
        $actividad->articulacion_proyecto->proyecto->empresas()->attach($empresas_propietarias);
          
        $grupos_duenhos = array();
        $grupos_duenhos = $this->obtenerGruposPropietarios($row['grupo_investigacion_duenho']);
        $actividad->articulacion_proyecto->proyecto->gruposinvestigacion()->attach($grupos_duenhos);
    }
}
