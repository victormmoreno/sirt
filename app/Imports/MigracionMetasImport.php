<?php

namespace App\Imports;

use App\Models\{MetaNodo, Entidad};
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\{DB};
use Maatwebsite\Excel\Concerns\ToCollection;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\{WithHeadingRow, WithCalculatedFormulas};
use Maatwebsite\Excel\Imports\HeadingRowFormatter;


HeadingRowFormatter::default('slug');

class MigracionMetasImport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements ToCollection, WithHeadingRow, WithCalculatedFormulas
{
    public $validaciones;
    public $hoja = 'Metas';

    public function __construct()
    {
        $this->validaciones = new ValidacionesImport;
    }


    public function collection(Collection $rows)
    {
        DB::beginTransaction();
        try {
            $year = Carbon::now()->format('Y');
            foreach ($rows as $key => $row) {
                // $validacion = true;
                $nodo = Entidad::where('nombre', $row['tecnoparque'])->first();
                $validacion = $this->validar($nodo, $row, $key);
                if (!$validacion) {
                    return $validacion;
                }
                
                $meta = $nodo->nodo->metas_nodo()->where('anho', $year)->first();
                if ($meta == null) {
                    // Hace el registra de la meta
                    $nodo->nodo->metas_nodo()->create([
                        'anho' => $year,
                        'articulaciones' => $row['articulaciones'],
                        'trl6' => $row['meta_de_trl6'],
                        'trl7_trl8' => $row['meta_de_trl7_y_trl8']
                    ]);
                } else {
                    // Solo hace un update a las metas
                    $meta->update([
                        'articulaciones' => $row['articulaciones'],
                        'trl6' => $row['meta_de_trl6'],
                        'trl7_trl8' => $row['meta_de_trl7_y_trl8']
                    ]);
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

    private function validar($nodo, $row, $key)
    {
        $validacion = $this->validaciones->validarQuery($nodo, $row['tecnoparque'], $key, 'Nodo', $this->hoja);
        if (!$validacion) {
            return $validacion;
        }
        $validacion = $this->validaciones->validarCelda($row['tecnoparque'], $key, 'Nodo', $this->hoja);
        if (!$validacion) {
            return $validacion;
        }
        $validacion = $this->validaciones->validarCelda($row['metas_pbts_finalizados'], $key, 'Meta de pbts finalizados', $this->hoja);
        if (!$validacion) {
            return $validacion;
        }
        $validacion = $this->validaciones->validarCelda($row['articulaciones'], $key, 'Meta de articulaciones', $this->hoja);
        if (!$validacion) {
            return $validacion;
        }
        $validacion = $this->validaciones->validarCelda($row['meta_de_trl6'], $key, 'Meta de TRL6', $this->hoja);
        if (!$validacion) {
            return $validacion;
        }
        $validacion = $this->validaciones->validarCelda($row['meta_de_trl7_y_trl8'], $key, 'Meta de TRL7 y TRL8', $this->hoja);
        if (!$validacion) {
            return $validacion;
        }
        return true;
    }
}
