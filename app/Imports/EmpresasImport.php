<?php

namespace App\Imports;

use App\Models\{Empresa, Entidad, Ciudad, Sector, TamanhoEmpresa, TipoEmpresa};
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\{DB};
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmpresasImport implements ToCollection, WithHeadingRow
{
    public $validaciones;
    public $hoja = 'Empresas';

    public function __construct()
    {
        $this->validaciones = new ValidacionesImport;
    }
    public function collection(Collection $rows)
    {
        
        // El encabezado para migrar las empresas debe ser el siguiente
        // NIT(SIN PUNTOS NI CODIGO DE VERIFICACIÓN) - CÓDIGO CIIU - NOMBRE - FECHA DE CREACIÓN - SECTOR DE LA EMPRESA - TAMAÑO EMPRESA - TIPO EMPESA - CORREO EMPRESA - DEPARTAMENTO - CIUDAD - DIRECCION
        // Entidades: ciudad_id, nombre, slug, email_entidad
        DB::beginTransaction();
        try {
            foreach ($rows as $key => $row)
            {
                $nit = str_replace(' ', '', $row['nit']);
                $queryCiudad = Ciudad::where('nombre', $row['ciudad'])->first();
                $querySector = Sector::where('nombre', $row['sector'])->first();
                $queryTipo = TipoEmpresa::where('nombre', $row['tipo'])->first();
                $queryTamanho = TamanhoEmpresa::where('nombre', $row['tamanho'])->first();

                $queryTipo = $queryTipo == null ? null : $queryTipo->id;
                $queryTamanho = $queryTamanho == null ? null : $queryTamanho->id;
                
                $vCiudad = $this->validarCiudad($queryCiudad, $row['ciudad'], $key);
                if (!$vCiudad) {
                    return $vCiudad;
                }
                $vSector = $this->validarSector($querySector, $row['sector'], $key);
                if (!$vSector) {
                    return $vSector;
                }
                $validacion = $this->validaciones->validarFecha($row['fecha_creacion'], $key, 'Fecha de creación', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }
                $validacion = $this->validaciones->validarTamanhoCelda($row['direccion'], $key, 'Dirección de la empresa', 100, $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }
                // $vTipo = $this->validarTipo($queryTipo, $row['tipo'], $key);
                // if (!$vTipo) {
                //     return $vTipo;
                // }
                // $vTamanho = $this->validarTamanho($queryTamanho, $row['tamanho'], $key);
                // if (!$vTamanho) {
                //     return $vTamanho;
                // }
                
                $empresa = Empresa::where('nit', $nit)->first();
                if ($empresa == null) {
                    $this->registrarNuevaEmpresa($row, $queryCiudad, $querySector, $queryTipo, $queryTamanho, $nit);
                } else {
                    $this->actualizarEmpresaExistente($empresa, $row, $queryCiudad, $querySector, $queryTipo, $queryTamanho);
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

    private function actualizarEmpresaExistente($empresa, $row, $queryCiudad, $querySector, $queryTipo, $queryTamanho)
    {
        $empresa->update([
            'sector_id' => $querySector->id,
            'tipoempresa_id' => $queryTipo,
            'tamanhoempresa_id' => $queryTamanho,
            'direccion' => $row['direccion'],
            'fecha_creacion' => $row['fecha_creacion'],
            'codigo_ciiu' => $row['ciiu']
        ]);
        $empresa->entidad()->update([
            'ciudad_id' => $queryCiudad->id,
            'nombre' => $row['nombre'],
            'email_entidad' => $row['correo']
        ]);
    }

    private function registrarNuevaEmpresa($row, $queryCiudad, $querySector, $queryTipo, $queryTamanho, $nit)
    {
        $entidad = Entidad::create([
            'ciudad_id' => $queryCiudad->id,
            'nombre' => $row['nombre'],
            'slug' => str()->slug($row['nombre'] . str()->random(7), '-'),
            'email_entidad' => $row['correo']
        ]);
        Empresa::create([
            'entidad_id' => $entidad->id,
            'sector_id' => $querySector->id,
            'tipoempresa_id' => $queryTipo,
            'tamanhoempresa_id' => $queryTamanho,
            'nit' => $nit,
            'direccion' => $row['direccion'],
            'fecha_creacion' => $row['fecha_creacion'],
            'codigo_ciiu' => $row['ciiu']
        ]);
    }

    private function validarCiudad($queryCiudad, $nombre_ciudad, $i)
    {
        if ($queryCiudad == null) {
            session()->put('errorMigracion', 'Error en la hoja de "Empresas": La ciudad ' . $nombre_ciudad . ' en el registro de la fila #' . ($i+2) . ' no existe en la base de datos');
            return false;
        }
        return true;
    }

    private function validarSector($querySector, $nombre_sector, $i)
    {
        if ($querySector == null) {
            session()->put('errorMigracion', 'Error en la hoja de "Empresas": El sector ' . $nombre_sector . ' en el registro de la fila #' . ($i+2) . ' no existe en la base de datos');
            return false;
        }
        return true;
    }
}
