<?php

namespace App\Repositories\Datatables;

class EquipoDatatables
{
    /**
     * retorna datatables con los los equipos para el controlador EquipoController::index().
     * @param $equipos
     * @return \Illuminate\Http\Response
     */
    public function indexDatatable($equipos)
    {
        return datatables()->of($equipos)
            ->addColumn('edit', function ($data) {
                $button = '<a href="' . route("equipo.edit", $data->id) . '" class=" btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';

                return $button;
            })
            ->addColumn('anio_fin_depreciacion', function ($data) {
                return $data->vida_util + $data->anio_compra;
            })
            ->addColumn('depreciacion_por_anio', function ($data) {
                if ($data->vida_util > 0) {
                    return '$ ' . number_format(round($data->costo_adquisicion) / $data->vida_util, 0);
                }

                return '$ ' . number_format(round($data->costo_adquisicion), 0);
            })
            ->editColumn('costo_adquisicion', function ($data) {
                return '$ ' . number_format(round($data->costo_adquisicion), 0);
            })
            ->editColumn('nombrelinea', function ($data) {
                return $data->lineatecnologica->abreviatura . ' - ' . $data->lineatecnologica->nombre;
            })

            ->rawColumns(['edit', 'nombrelinea', 'costo_adquisicion', 'anio_fin_depreciacion'])
            ->make(true);
    }

    public function getEquiposPorNodoDatatables($equipos)
    {
        return datatables()->of($equipos)
            ->addColumn('edit', function ($data) {
                $button = '<a href="' . route("equipo.edit", $data->id) . '" class=" btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';

                return $button;
            })
            ->addColumn('anio_fin_depreciacion', function ($data) {
                return $data->vida_util + $data->anio_compra;
            })
            ->addColumn('depreciacion_por_anio', function ($data) {
                if ($data->vida_util > 0 || $data->costo_adquisicion >= 0) {
                    return '$ ' . number_format(round($data->costo_adquisicion) / $data->vida_util, 0);
                }

                return '$ ' . number_format(round($data->costo_adquisicion), 0);
            })
            ->editColumn('costo_adquisicion', function ($data) {
                return '$ ' . number_format(round($data->costo_adquisicion), 0);
            })
            ->editColumn('nombrelinea', function ($data) {
                return $data->lineatecnologica->abreviatura . ' - ' . $data->lineatecnologica->nombre;
            })

            ->rawColumns(['edit', 'nombrelinea', 'costo_adquisicion', 'anio_fin_depreciacion'])
            ->make(true);
    }
}
