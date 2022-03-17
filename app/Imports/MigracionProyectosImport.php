<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Facades\DB;

class MigracionProyectosImport implements WithMultipleSheets
{
    public $nodo;
    public function __construct($nodo)
    {
        $this->nodo = $nodo;
    }
    public function sheets(): array
    {
        // DB::beginTransaction();
        // try {
            $resp = [
                // 'Ideas' => new IdeasImport($this->nodo),
                // 'Empresas' => new EmpresasImport(),
                // 'Talentos' => new TalentosImport(),
                'Funcionarios' => new FuncionarioImport($this->nodo),
                'Materiales' => new MaterialImport($this->nodo),
                'Equipos' => new EquipoImport($this->nodo),
                // 'Grupos' => new GruposInvestigacionImport(),
                // 'Gestores' => new GestoresImport($this->nodo),
                // 'Proyectos' => new ProyectosImport($this->nodo)
            ];
            // DB::commit();
            return $resp;
        // } catch (\Throwable $th) {
        //     DB::rollBack();
        //     return false;
        // }
    }
}
