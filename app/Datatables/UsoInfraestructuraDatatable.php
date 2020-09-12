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
                return $data->present()->fechaUsoInfraestructura();
            })
            ->editColumn('actividad', function ($data) {
                return $data->present()->actividadUsoInfraestructura();
            })
            ->editColumn('fase', function ($data) {
                return $data->present()->faseActividad();
            })
            ->editColumn('asesoria_directa', function ($data) {

                return $data->present()->asesoriaDirecta();
            })
            ->editColumn('asesoria_indirecta', function ($data) {
                return $data->present()->asesoriaIndirecta();
            })
            ->addColumn('gestorEncargado', function ($data) {

                return $data->present()->gestorEncargado();
            })
            ->addColumn('detail', function ($data) {

                $button = '<a class="btn tooltipped green-complement  m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver detalle" href="' . route("usoinfraestructura.show", $data->id) . '" ><i class="material-icons">visibility</i></a>';

                return $button;
            })
            ->rawColumns(['fecha', 'actividad', 'gestorEncargado', 'fase', 'asesoria_directa', 'asesoria_indirecta', 'detail'])
            ->make(true);
    }
}
