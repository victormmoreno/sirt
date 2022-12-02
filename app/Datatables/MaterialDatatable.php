<?php

namespace App\Datatables;

class MaterialDatatable
{
    /**
     * retorna datatables con los materiales para el controlador MaterialController::index().
     * @param $materiales
     * @return \Illuminate\Http\Response
     */
    public function indexDatatable($materiales)
    {
        return datatables()->of($materiales)

            ->addColumn('detail', function ($data) {
                $button = '<a href="' . route("material.show", $data->id) . '" class="btn tooltipped bg-info"><i class="material-icons">info_outline</i></a>';

                return $button;
            })
            ->addColumn('valor_unitario', function ($data) {
                return '$ ' . number_format(round($data->valor_compra / $data->cantidad, 2));
            })
            ->editColumn('fecha', function ($data) {
                return $data->fecha->isoFormat('LL');
            })
            ->editColumn('valor_compra', function ($data) {
                return '$ ' . number_format($data->valor_compra);
            })
            ->editColumn('nombrelinea', function ($data) {
                return $data->lineatecnologica->abreviatura . ' - ' . $data->lineatecnologica->nombre;
            })
            ->editColumn('presentacion', function ($data) {
                return $data->presentacion->nombre;
            })
            ->editColumn('medida', function ($data) {
                return $data->medida->nombre;
            })

            ->rawColumns(['detail', 'nombrelinea', 'valor_unitario', 'valor_compra', 'presentacion', 'medida'])
            ->make(true);
    }

    /**
     * retorna datatables con los materiales por nodo para el controlador MaterialController::getMaterialesPorNodo().
     * @param $materiales
     * @return \Illuminate\Http\Response
     */
    public function getMaterialesPorNodoDatatable($materiales)
    {
        return datatables()->of($materiales)
            ->addColumn('detail', function ($data) {
                $button = '<a href="' . route("material.show", $data->id) . '" class="btn tooltipped bg-info"><i class="material-icons">info_outline</i></a>';

                return $button;
            })
            ->addColumn('valor_unitario', function ($data) {
                return '$ ' . number_format(round($data->valor_compra / $data->cantidad, 2));
            })
            ->editColumn('fecha', function ($data) {
                return $data->fecha->isoFormat('LL');
            })
            ->editColumn('valor_compra', function ($data) {
                return '$ ' . number_format($data->valor_compra);
            })
            ->editColumn('nombrelinea', function ($data) {
                return $data->linea;
            })
            ->editColumn('presentacion', function ($data) {
                return $data->presentacion;
            })
            ->editColumn('medida', function ($data) {
                return $data->medida;
            })
            ->rawColumns(['detail', 'nombrelinea', 'valor_unitario', 'valor_compra', 'presentacion', 'medida'])
            ->make(true);
    }
}
