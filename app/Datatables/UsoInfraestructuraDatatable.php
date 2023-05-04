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
                // return [
                //     'display' => e($data->fecha->format('d-m-Y')),
                //     'timestamp' => $data->fecha->timestamp
                // ];
                return $data->fecha->format('Y-m-d');
            })

            ->editColumn('actividad', function ($data) {
                return $data->nombre;
            })
            ->editColumn('tipo_asesoria', function ($data) {
                return $data->tipo_asesoria;
            })
            ->editColumn('fase', function ($data) {
                return $data->fase;
            })
            ->editColumn('asesoria_directa', function ($data) {
                return $data->aseseria_directa;
            })
            ->editColumn('asesoria_indirecta', function ($data) {
                return $data->asesoria_indirecta;
            })
            ->addColumn('gestorEncargado', function ($data) {
                return $data->asesores;
            })
            ->addColumn('detail', function ($data) {
                return '<a class="btn tooltipped bg-info m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver detalle" href="' . route("usoinfraestructura.show", $data->id) . '" ><i class="material-icons">visibility</i></a>';
            })
            // ->filterColumn('fecha', function ($query, $keyword) {
            //     $query->whereRaw("DATE_FORMAT(fecha,'%m-%d-%Y') LIKE ?", ["%$keyword%"]);
            // })
            ->rawColumns(['fecha','tipo_asesoria', 'actividad', 'gestorEncargado', 'fase', 'asesoria_directa', 'asesoria_indirecta', 'detail'])

            ->make(true);
    }

    public function indexDatatableUsosProyectos($usoinfraestructura)
    {
        return datatables()->of($usoinfraestructura)
            ->editColumn('fecha', function ($data) {
                return $data->present()->fechaUsoInfraestructura();
            })
            ->editColumn('actividad', function ($data) {
                return $data->present()->actividadUsoInfraestructura();
            })
            ->editColumn('tipo_asesoria', function ($data) {
                return $data->present()->tipoUsoInfraestructura();
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
                return $data->present()->asesor();
            })
            ->addColumn('detail', function ($data) {
                $button = '<a class="btn tooltipped green-complement  m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver detalle" href="' . route("usoinfraestructura.show", $data->id) . '" ><i class="material-icons">visibility</i></a>';
                return $button;
            })
            ->rawColumns(['fecha','tipo_asesoria', 'actividad', 'gestorEncargado', 'fase', 'asesoria_directa', 'asesoria_indirecta', 'detail'])
            ->make(true);
    }
}
