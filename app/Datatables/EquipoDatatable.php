<?php

namespace App\Datatables;

class EquipoDatatable
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
                $button = '<a href="' . route("equipo.edit", $data->id) . '" class=" btn bg-warning tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';

                return $button;
            })
            ->addColumn('changeState', function ($data) {
                $button = '<a href="#" class=" btn bg-danger lighten-3 m-b-xs" onclick="equipo.changeState(' . $data->id . ')" data-position="bottom" data-delay="50" data-tooltip="Cambiar Estado"><i class="material-icons">autorenew</i></a>';

                return $button;
            })
            ->addColumn('destacar', function ($data) {
                if ($data->destacado == 0) {
                    $button = '<a href="#" class="btn green accent-2 m-b-xs" data-position="bottom" onclick="equipo.destacarEquipo(' . $data->id . ', '.$data->destacado.', '.config('app.equipos.num_destacados').')"><i class="material-icons">stars</i></a>';
                } else {
                    $button = '<a href="#" class="btn yellow accent-2 m-b-xs" data-position="bottom" onclick="equipo.destacarEquipo(' . $data->id . ', '.$data->destacado.', '.config('app.equipos.num_destacados').')"><i class="material-icons">stars</i></a>';
                }
                return $button;
            })
            ->addColumn('detail', function ($data) {
                $button = '
                    <a class="btn bg-info m-b-xs modal-trigger" href="#" onclick="equipo.detail(' . $data->id . ')">
                        <i class="material-icons">info</i>
                    </a>
                    ';
                return $button;
            })
            ->addColumn('anio_fin_depreciacion', function ($data) {
                return $data->present()->equipoAnioDepreciacion();
            })
            ->addColumn('state', function ($data) {
                return $data->present()->equipoState();
            })
            ->addColumn('depreciacion_por_anio', function ($data) {
                return $data->present()->equipoDepreciacionPorAnio();
            })
            ->editColumn('costo_adquisicion', function ($data) {
                return $data->present()->equipoCostoAdquisicion();
            })
            ->editColumn('nombrelinea', function ($data) {
                return $data->present()->equipoLinea();
            })

            ->rawColumns(['edit', 'changeState', 'detail', 'state', 'nombrelinea', 'costo_adquisicion', 'anio_fin_depreciacion', 'destacar'])
            ->make(true);
    }
}
