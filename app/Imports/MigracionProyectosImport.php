<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Facades\{DB};

class MigracionProyectosImport implements WithMultipleSheets
{
    public $nodo;
    public function __construct($nodo)
    {
        $this->nodo = $nodo;
    }
    public function sheets(): array
    {
        DB::beginTransaction();
        try {
            // $empresas = new EmpresasImport();
            $resp = [
                'Ideas' => new IdeasImport($this->nodo),
                'Empresas' => new EmpresasImport(),
                'Talentos' => new TalentosImport(),
                'Grupos' => new GruposInvestigacionImport(),
                // 'Gestores' => new FirstSheetImport(),
                // 'Proyectos' => new SecondSheetImport(),
            ];
            DB::commit();
            return $resp;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }
}
