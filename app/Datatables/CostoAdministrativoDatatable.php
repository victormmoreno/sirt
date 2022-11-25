<?php

namespace App\Datatables;

use App\Models\CostoAdministrativo;

class CostoAdministrativoDatatable
{

    /**
     * retorna datatables con los costos administrativos para el controlador CostoAdministrativoController::getCostoAdministrativoPorNodo().
     * @param $costos
     * @return \Illuminate\Http\Response
     */
    public function getCostoAdministrativoPorNodoDatatables($costos, $nodo)
    {
        return datatables()->of($costos)
            ->addColumn('edit', function ($data) use ($nodo) {

                $button = '<a href="' . route("costoadministrativo.edit", [$data->id, $nodo]) . '" class="btn bg-warning tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';

                return $button;
            })
            ->editColumn('valor', function ($data) {
                return '$ ' . number_format($data->valor);
            })
            ->addColumn('costosadministrativosporhora', function ($data) {
                return '$ ' . number_format(round(($data->valor / CostoAdministrativo::DIAS_AL_MES) / CostoAdministrativo::HORAS_AL_DIA, 2));
            })
            ->addColumn('costosadministrativospordia', function ($data) {

                return '$ ' . number_format(round($data->valor / CostoAdministrativo::DIAS_AL_MES, 2));
            })
            ->rawColumns(['edit', 'costosadministrativospordia', 'costosadministrativosporhora'])
            ->make(true);
    }
}
