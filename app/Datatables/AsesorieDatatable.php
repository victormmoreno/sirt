<?php

namespace App\Datatables;

class AsesorieDatatable
{
    /**
     * retorna datatables con las asesorias.
     * @param $asesorias
     * @return \Illuminate\Http\Response
     */
    public function indexDatatable($asesorias)
    {
        return datatables()->of($asesorias)
            ->editColumn('codigo', function ($data) {
                return $data->codigo;
            })
            ->editColumn('fecha', function ($data) {
                return optional($data->fecha)->format('Y-m-d');
            })
            ->editColumn('asesorable', function ($data) {
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
            ->addColumn('asesores', function ($data) {
                return $data->asesores;
            })
            ->addColumn('detail', function ($data) {
                return '<a class="btn tooltipped bg-info m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver detalle" href="' . route("asesorias.show", $data->codigo) . '" ><i class="material-icons">visibility</i></a>';
            })
            ->rawColumns(['codigo','fecha','tipo_asesoria', 'asesorable', 'asesores', 'fase', 'asesoria_directa', 'asesoria_indirecta', 'detail'])
            ->make(true);
    }

    public function indexDatatableUsosProyectos($asesorias)
    {
        return datatables()->of($asesorias)
            ->editColumn('fecha', function ($data) {
                return $data->present()->fechaUsoInfraestructura();
            })
            ->editColumn('asesorable', function ($data) {
                return $data->present()->asesorable();
            })
            ->editColumn('tipo_asesoria', function ($data) {
                return $data->present()->tipoUsoInfraestructura();
            })
            ->editColumn('fase', function ($data) {
                return $data->present()->asesorablePhase();
            })
            ->editColumn('asesoria_directa', function ($data) {
                return $data->present()->asesoriaDirecta();
            })
            ->editColumn('asesoria_indirecta', function ($data) {
                return $data->present()->asesoriaIndirecta();
            })
            ->addColumn('expertoEncargado', function ($data) {
                return $data->present()->asesor();
            })
            ->addColumn('detail', function ($data) {
                $button = '<a class="btn tooltipped green-complement  m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver detalle" href="' . route("asesorias.show", $data->codigo) . '" ><i class="material-icons">visibility</i></a>';
                return $button;
            })
            ->rawColumns(['fecha','tipo_asesoria', 'asesorable', 'expertoEncargado', 'fase', 'asesoria_directa', 'asesoria_indirecta', 'detail'])
            ->make(true);
    }
}
