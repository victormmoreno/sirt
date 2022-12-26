<?php

namespace App\Datatables;

use App\Models\LineaTecnologica;
use DataTables;

class LineaTecnologicaDatatable
{
    /**
     * retorna datatables con las linea tecnologicas para el controlador LineaController::index().
     * @return \Illuminate\Http\Response
     */
    public function indexDatatable()
    {
        return DataTables::eloquent(LineaTecnologica::select(['id', 'nombre', 'slug', 'abreviatura']))

            ->addColumn('action', function ($data) {
                $button = '<a href="' . route("lineas.edit", $data->slug) . '" class="waves-effect waves-light btn bg-warning tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';
                return $button;
            })
            ->addColumn('show', function ($data) {
                $button = '<a href="' . route("lineas.show", $data->slug) . '" class="  btn tooltipped bg-info m-b-xs" data-position="bottom" data-delay="50" data-tooltip="ver más"><i class="material-icons">info_outline</i></a>';
                return $button;
            })
            ->rawColumns(['action', 'show'])
            ->toJson();
    }
}
