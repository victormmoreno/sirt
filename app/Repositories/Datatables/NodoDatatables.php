<?php

namespace App\Repositories\Datatables;

class NodoDatatables
{

    /**
     * retorna datatables con los nodos para el controlador NodoController::index().
     * @param $nodos
     * @return \Illuminate\Http\Response
     */
    public function indexDatatable($nodos)
    {
        return datatables()->of($nodos)
            ->addColumn('detail', function ($data) {
                $button = '<a href="' . route("nodo.show", $data->slug) . '" class="waves-effect waves-light btn tooltipped blue-grey m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver Nodo"  data-tooltip-id="b24478ad-402e-0583-7a3a-de01b3861e9a"><i class="material-icons">info_outline</i></a>';

                return $button;
            })
            ->addColumn('edit', function ($data) {
                $button = '<a href="' . route("nodo.edit", $data->slug) . '" class="waves-effect waves-light btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';

                return $button;
            })
            ->rawColumns(['detail', 'edit'])
            ->make(true);
    }

}
