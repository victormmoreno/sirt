<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\{DB};
use App\Models\{GrupoInvestigacion, ClasificacionColciencias, Ciudad, Entidad};
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GruposInvestigacionImport implements ToCollection, WithHeadingRow
{
    public $hoja = 'Grupos de Investigación';
    public $validaciones;
    public function __construct()
    {
        $this->validaciones = new ValidacionesImport;
    }
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        DB::beginTransaction();
        try {
            foreach ($rows as $key => $row) {
                // Validar celda de codigo_colciencias
                $row['codigo_colciencias'] = str_replace(' ', '', $row['codigo_colciencias']);
                $row['codigo_colciencias'] = ltrim(rtrim($row['codigo_colciencias']));
                $vCodigoGrupo = $this->validaciones->validarCelda($row['codigo_colciencias'], $key, 'Código de colciencias', $this->hoja);
                if (!$vCodigoGrupo) {
                    return $vCodigoGrupo;
                }
                $vCodigoGrupo = $this->validaciones->validarTamanhoCelda($row['codigo_colciencias'], $key, 'Código de colciencias', 10, $this->hoja);
                if (!$vCodigoGrupo) {
                    return $vCodigoGrupo;
                }
                // Validar nombre
                $vNombreGrupo = $this->validaciones->validarCelda($row['nombre'], $key, 'Nombre del grupo de investigación', $this->hoja);
                if (!$vNombreGrupo) {
                    return $vNombreGrupo;
                }
                $vNombreGrupo = $this->validaciones->validarTamanhoCelda($row['nombre'], $key, 'Nombre del grupo de investigación', 300, $this->hoja);
                if (!$vNombreGrupo) {
                    return $vNombreGrupo;
                }
                // Validar correo
                $row['correo'] = str_replace(' ', '', $row['correo']);
                $row['correo'] = ltrim(rtrim($row['correo']));
                $vCorreoGrupo = $this->validaciones->validarTamanhoCelda($row['correo'], $key, 'Correo del grupo de investigación', 300, $this->hoja);
                if (!$vCorreoGrupo) {
                    return $vCorreoGrupo;
                }
                // Validar clasificación colciencias
                $queryClasificacionColciencias = ClasificacionColciencias::where('nombre', $row['clasificacion'])->first();
                $vClasificacionColciencias = $this->validaciones->validarQuery($queryClasificacionColciencias, $row['clasificacion'], $key, 'Clasificación colciencias', $this->hoja);
                if (!$vClasificacionColciencias) {
                    return $vClasificacionColciencias;
                }
                // Validar tipo de grupo de investigación
                $vTipoGrupo = $this->validarTipoGrupo($row['tipo_grupo'], $key);
                if (!$vTipoGrupo) {
                    return $vTipoGrupo;
                }
                // Validar la ciudad
                $queryCiudad = Ciudad::where('nombre', $row['ciudad'])->first();
                $vCiudad = $this->validaciones->validarQuery($queryCiudad, $row['ciudad'], $key, 'Ciudad', $this->hoja);
                if (!$vCiudad) {
                    return $vCiudad;
                }
                // Validar institucion
                $vInstitucion = $this->validaciones->validarTamanhoCelda($row['institucion'], $key, 'Institución', 200, $this->hoja);
                if (!$vInstitucion) {
                    return $vInstitucion;
                }

                $grupo = GrupoInvestigacion::where('codigo_grupo', $row['codigo_colciencias'])->first();

                if ($grupo == null) {
                    // Registrar nuevo grupo de investigacion
                    $this->registrarGrupoInvestigacion($row, $queryClasificacionColciencias, $queryCiudad);
                } else {
                    // Actualizar información
                    $this->actualizarGrupoInvestigacion($grupo, $row, $queryClasificacionColciencias, $queryCiudad);
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

    public function actualizarGrupoInvestigacion($grupo, $row, $clasificacion, $ciudad)
    {
        
        $grupo->entidad()->update([
            'ciudad_id' => $ciudad->id,
            'nombre' => $row['nombre'],
            'email_entidad' => $row['correo'],
        ]);
        $grupo->update([
            'clasificacioncolciencias_id' => $clasificacion->id,
            'codigo_grupo' => strtoupper($row['codigo_colciencias']),
            'tipogrupo' => $row['tipo_grupo'] == 'EXTERNO' ? GrupoInvestigacion::IsExterno() : GrupoInvestigacion::IsInterno(),
            'estado' => GrupoInvestigacion::IsActive(),
            'institucion' => $row['institucion'],
        ]);
    }

    private function registrarGrupoInvestigacion($row, $clasificacion, $ciudad)
    {
        $entidad = Entidad::create([
            'ciudad_id' => $ciudad->id,
            'nombre' => $row['nombre'],
            'slug' => str()->slug($row['nombre'] . str()->random(7), '-'),
            'email_entidad' => $row['correo'],
            ]);
      
            GrupoInvestigacion::create([
            'entidad_id' => $entidad->id,
            'clasificacioncolciencias_id' => $clasificacion->id,
            'codigo_grupo' => strtoupper($row['codigo_colciencias']),
            'tipogrupo' => $row['tipo_grupo'] == 'EXTERNO' ? GrupoInvestigacion::IsExterno() : GrupoInvestigacion::IsInterno(),
            'estado' => GrupoInvestigacion::IsActive(),
            'institucion' => $row['institucion'],
            ]);
    }

    private function validarTipoGrupo($tipo, $i)
    {
        if ($tipo != 'EXTERNO' && $tipo != 'SENA') {
            session()->put('errorMigracion', 'Error en la hoja de "Grupos de Investigacion": El tipo de grupo ' . $tipo . ' en el registro de la fila #' . ($i+2) . ' no es válido (SENA O EXTERNO).');
            return false;
        }
        return true;
    }
}
