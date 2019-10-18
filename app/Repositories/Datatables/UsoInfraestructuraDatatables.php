<?php

namespace App\Repositories\Datatables;

use App\Models\Articulacion;
use App\Models\Edt;
use App\User;

class UsoInfraestructuraDatatables
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

                $button = '<a class="  btn tooltipped blue-grey m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver detalle" href="' . route("usoinfraestructura.show", $data->id) . '" ><i class="material-icons">info_outline</i></a>';

                return $button;
            })
            ->addColumn('edit', function ($data) {


            	if (isset($data->actividad->articulacion_proyecto->proyecto->estadoproyecto) && $data->actividad->articulacion_proyecto->proyecto->estadoproyecto->nombre == 'Ejecutado') {
            		return '<span class="new badge" data-badge-caption="Proyecto Ejecutado"></span>';
            		return $data->actividad->articulacion_proyecto->proyecto->estadoproyecto->id;
            	}else if(isset($data->actividad->articulacion_proyecto->proyecto->estadoproyecto) && $data->actividad->articulacion_proyecto->proyecto->estadoproyecto->nombre == 'Cierre PMV'){
            		return '<span class="new badge" data-badge-caption="Proyecto Cierre PMV"></span>';
            	}else if(isset($data->actividad->articulacion_proyecto->proyecto->estadoproyecto) && $data->actividad->articulacion_proyecto->proyecto->estadoproyecto->nombre == 'Cierre PF'){
            		return '<span class="new badge" data-badge-caption="Proyecto Cierre PF"></span>';
            	}else if(isset($data->actividad->articulacion_proyecto->proyecto->estadoproyecto) && $data->actividad->articulacion_proyecto->proyecto->estadoproyecto->nombre == 'Finalizado'){
            		return '<span class="new badge" data-badge-caption="Proyecto Finalizado"></span>';
            	}else if(isset($data->actividad->articulacion_proyecto->proyecto->estadoproyecto) && $data->actividad->articulacion_proyecto->proyecto->estadoproyecto->nombre == 'Suspendido'){
            		return '<span class="new badge" data-badge-caption="Proyecto Suspendido"></span>';
            	}elseif(isset($data->actividad->articulacion_proyecto->articulacion) && $data->actividad->articulacion_proyecto->articulacion->estado == Articulacion::IsCierre()) {
            		return '<span class="new badge" data-badge-caption="Articulacion Cerrada"></span>';
            	}elseif(isset($data->actividad->edt) && $data->actividad->edt->estado == Edt::IsInactive()){
            		return '<span class="new badge" data-badge-caption="EDT Cerrada"></span>';
            	}elseif ((!$data->usogestores->isEmpty()) && session()->has('login_role') && session()->get('login_role') == User::IsTalento()) {
                    return '<span class="new badge" data-badge-caption="SOLO EL GESTOR"></span>';
                }

                $button = '<a href="' . route("usoinfraestructura.edit", $data->id) . '" class=" btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';

                return $button;
            })
            ->rawColumns(['fecha', 'actividad', 'asesoria_directa', 'asesoria_indirecta', 'detail', 'edit'])
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
