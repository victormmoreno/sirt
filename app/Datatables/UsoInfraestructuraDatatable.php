<?php

namespace App\Datatables;

class UsoInfraestructuraDatatable
{
    /**
     * retorna datatables con los usos de infraestructura para el controlador UsoInfraestrucutra::index().
     * @param $usoinfraestructura
     * @return \Illuminate\Http\Response
     */
    public function indexDatatable($usoinfraestructura)
    {
        return datatables()->of($usoinfraestructura)
            ->editColumn('fecha', function ($data) {
                return $data->fecha->isoFormat('LL');
            })
            ->editColumn('actividad', function ($data) {
                return $data->actividad->codigo_actividad . ' - ' . $data->actividad->nombre;
            })
            ->editColumn('fase', function ($data) {
                if (isset($data->actividad->articulacion_proyecto->proyecto->fase)) {
                    return $data->actividad->articulacion_proyecto->proyecto->fase->nombre;
                } else {
                    return 'No registra';
                }
            })
            ->editColumn('asesoria_directa', function ($data) {

                if ($data->usogestores->isEmpty()) {
                    return 'No registra';
                } else {
                    if ($data->usogestores->sum('pivot.asesoria_directa') == 1) {
                        return $data->usogestores->sum('pivot.asesoria_directa') . ' hora';
                    }
                    return $data->usogestores->sum('pivot.asesoria_directa') . ' horas';
                }
            })
            ->editColumn('asesoria_indirecta', function ($data) {
                if ($data->usogestores->isEmpty()) {
                    return 'No registra';
                } else {
                    if ($data->usogestores->sum('pivot.asesoria_indirecta') == 1) {
                        return $data->usogestores->sum('pivot.asesoria_indirecta') . ' hora';
                    }
                    return $data->usogestores->sum('pivot.asesoria_indirecta') . ' horas';
                }
            })
            ->addColumn('detail', function ($data) {

                $button = '<a class="btn tooltipped green-complement  m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver detalle" href="' . route("usoinfraestructura.show", $data->id) . '" ><i class="material-icons">visibility</i></a>';

                return $button;
            })
            ->rawColumns(['fecha', 'actividad', 'fase', 'asesoria_directa', 'asesoria_indirecta', 'detail'])
            ->make(true);
    }

    /**
     * retorna datatables con los usos de infraestructura para el controlador UsoInfraestrucutra::getUsoInfraestructuraForNodo().
     * @param $usoinfraestructura
     * @return \Illuminate\Http\Response
     */
    public function getUsoInfraestructuraForNodoDatatables($usoinfraestructura)
    {
        return datatables()->of($usoinfraestructura)
            ->editColumn('fecha', function ($data) {
                return $data->fecha->isoFormat('LL');
            })
            ->editColumn('actividad', function ($data) {
                return $data->actividad->codigo_actividad . ' - ' . $data->actividad->nombre;
            })
            ->editColumn('asesoria_directa', function ($data) {
                if ($data->usogestores->isEmpty()) {
                    return 'No registra';
                } else {
                    if ($data->usogestores->sum('pivot.asesoria_directa') == 1) {
                        return $data->usogestores->sum('pivot.asesoria_directa') . ' hora';
                    }
                    return $data->usogestores->sum('pivot.asesoria_directa') . ' horas';
                }
            })
            ->editColumn('asesoria_indirecta', function ($data) {
                if ($data->usogestores->isEmpty()) {
                    return 'No registra';
                } else {
                    if ($data->usogestores->sum('pivot.asesoria_indirecta') == 1) {
                        return $data->usogestores->sum('pivot.asesoria_indirecta') . ' hora';
                    }
                    return $data->usogestores->sum('pivot.asesoria_indirecta') . ' horas';
                }
            })
            ->addColumn('detail', function ($data) {

                $button = '<a class="  btn tooltipped blue-grey m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver detalle" href="' . route("usoinfraestructura.show", $data->id) . '"><i class="material-icons">info_outline</i></a>';

                return $button;
            })

            ->rawColumns(['fecha', 'actividad', 'asesoria_directa', 'asesoria_indirecta', 'detail'])
            ->make(true);
    }
}
