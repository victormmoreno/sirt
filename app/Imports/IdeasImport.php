<?php

namespace App\Imports;

use App\Models\{Idea, EstadoIdea};
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\{DB};
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Repositories\Repository\IdeaRepository;

class IdeasImport implements ToCollection, WithHeadingRow
{
    public $nodo;
    public $ideaRepository;
    public $validaciones;
    public $hoja = 'Ideas';

    public function __construct($nodo)
    {
        $this->nodo = $nodo;
        $this->ideaRepository = new IdeaRepository;
        $this->validaciones = new ValidacionesImport;
        // $this->hoja = 'Ideas';
    }
    /**
    * @param Collection $collection
    * Encabezado
    * nombres contacto	apellidos contacto	correo	contacto	aprendiz sena	codigo idea	nombre idea	descripcion	objetivo	alcance	convocatoria	nombre convocatoria
    */
    public function collection(Collection $rows)
    {
        DB::beginTransaction();
        try {
            foreach ($rows as $key => $row) {
                // Eliminar espacios del teléfono
                $row['contacto'] = str_replace(' ', '', $row['contacto']);
                $row['contacto'] = ltrim(rtrim($row['contacto']));
                // Se validan; nombres del contacto, apellidos del contact y nombre del proyecto
                $vNombresContacto = $this->validaciones->validarCelda($row['nombres_contacto'], $key, 'Nombres del talento', $this->hoja);
                if (!$vNombresContacto) {
                    return $vNombresContacto;
                }
                $vApellidosContacto = $this->validaciones->validarCelda($row['apellidos_contacto'], $key, 'Apellidos del talento', $this->hoja);
                if (!$vApellidosContacto) {
                    return $vApellidosContacto;
                }
                $vNombreIdea = $this->validaciones->validarCelda($row['nombre_idea'], $key, 'Nombre de la idea de proyecto', $this->hoja);
                if (!$vNombreIdea) {
                    return $vNombreIdea;
                }
                // Validar tamaño del número de teléfono
                $vTamannhoTelefono = $this->validaciones->validarTamanhoCelda($row['contacto'], $key, 'Teléfono de contacto', 11, $this->hoja);
                if (!$vTamannhoTelefono) {
                    return $vTamannhoTelefono;
                }
                // Validar tamaño del nombre de la idea de proyecto
                $vTamannhoNombreIdea = $this->validaciones->validarTamanhoCelda($row['nombre_idea'], $key, 'Nombre de la idea de proyecto', 200, $this->hoja);
                if (!$vTamannhoNombreIdea) {
                    return $vTamannhoNombreIdea;
                }
                // Validar tamaño de la descripción de la idea de proyecto
                $vTamannhoDescripcion = $this->validaciones->validarTamanhoCelda($row['descripcion'], $key, 'Descripción de la idea de proyecto', 2000, $this->hoja);
                if (!$vTamannhoDescripcion) {
                    return $vTamannhoDescripcion;
                }
                // Validar tamaño del objetivo de la idea de proyecto
                $vTamannhoObjetivo = $this->validaciones->validarTamanhoCelda($row['objetivo'], $key, 'Objetivo de la idea de proyecto', 2000, $this->hoja);
                if (!$vTamannhoObjetivo) {
                    return $vTamannhoObjetivo;
                }
                // Validar tamaño del alcance de la idea de proyecto
                $vTamannhoAlcance = $this->validaciones->validarTamanhoCelda($row['alcance'], $key, 'Objetivo de la idea de proyecto', 2000, $this->hoja);
                if (!$vTamannhoAlcance) {
                    return $vTamannhoAlcance;
                }

                $idea = Idea::where('codigo_idea', $row['codigo_idea'])->first();
                if ($idea == null) {
                    // Registra la idea de proyecto
                    $codigo_idea = $this->ideaRepository->generarCodigoIdea(Idea::IsEmprendedor(), $this->nodo);
                    $this->registrarNuevaIdeaDeProyecto($codigo_idea, $row);
                } else {
                    // Actualizar información de la idea de proyecto
                    $this->actualizarIdeaDeProyecto($row, $idea);
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

    private function actualizarIdeaDeProyecto($row, $idea)
    {
        $idea->update([
            "nombres_contacto" => $row['nombres_contacto'],
            "apellidos_contacto" => $row['apellidos_contacto'],
            "correo_contacto" => $row['correo'],
            "telefono_contacto" => $row['contacto'],
            "nombre_proyecto" => $row['nombre_idea'],
            "aprendiz_sena" => $row['aprendiz_sena'] == 'SI' ? 1 : 0,
            "descripcion" => $row['descripcion'],
            "objetivo" => $row['objetivo'],
            "alcance" => $row['alcance'],
            "viene_convocatoria" => $row['convocatoria'] == 'SI' ? 1 : 0,
            "convocatoria" => $row['nombre_convocatoria']
        ]);
    }

    private function registrarNuevaIdeaDeProyecto($codigo, $row)
    {
        Idea::create([
            "nodo_id" => $this->nodo,
            "nombres_contacto" => $row['nombres_contacto'],
            "apellidos_contacto" => $row['apellidos_contacto'],
            "correo_contacto" => $row['correo'],
            "telefono_contacto" => $row['contacto'],
            "nombre_proyecto" => $row['nombre_idea'],
            "codigo_idea" => $codigo,
            "aprendiz_sena" => $row['aprendiz_sena'] == 'SI' ? 1 : 0,
            "descripcion" => $row['descripcion'],
            "objetivo" => $row['objetivo'],
            "alcance" => $row['alcance'],
            "viene_convocatoria" => $row['convocatoria'] == 'SI' ? 1 : 0,
            "convocatoria" => $row['nombre_convocatoria'],
            "tipo_idea" => Idea::IsEmprendedor(),
            "estadoidea_id" => EstadoIdea::where('nombre', '=', EstadoIdea::IsProyecto())->first()->id
        ]);
    }

}
