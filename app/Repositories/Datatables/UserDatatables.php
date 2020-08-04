<?php

namespace App\Repositories\Datatables;

use App\User;

class UserDatatables
{

    public function datatableUsers($users)
    {
        return datatables()->of($users)
            ->addColumn('detail', function ($data) {
                $button = '<a href="' . route("usuario.usuarios.show", $data->documento) . '" class=" btn tooltipped green-complement  m-b-xs " data-position="bottom" data-delay="50" data-tooltip="Detalles"><i class="material-icons">visibility</i></a>';
                return $button;
            })
            ->editColumn('tipodocumento', function ($data) {
                return !empty($data->tipodocumento) ? $data->tipodocumento->nombre : 'No registra';
            })
            ->editColumn('nombrecompleto', function ($data) {
                return "{$data->nombres} {$data->apellidos}";
            })
            ->editColumn('celular', function ($data) {
                return !empty($data->celular) ? $data->celular : !empty($data->telefono) ?  $data->telefono : 'No Registra';
            })
            ->editColumn('roles', function ($data) {
                return $data->getRoleNames()->implode(', ');
            })
            ->editColumn('login', function ($data) {
                return isset($data->ultimo_login) ? $data->ultimo_login->isoFormat('DD/MM/YYYY') : 'No Registra';
            })
            ->editColumn('state', function ($data) {
                return $this->columnStateEdit($data);
            })
            ->rawColumns(['tipodocumento', 'nombrecompleto', 'detail', 'celular', 'roles', 'login', 'state'])
            ->make(true);
    }

    /*=====  End of metodo para mostrar todos los usuarios en datatables  ======*/

    private function columnStateEdit($data)
    {
        return $data->estado == User::IsActive() && $data->deleted_at === null  ? "Habilitado" : "Inhabilitado desde: " . optional($data->deleted_at)->isoFormat('DD/MM/YYYY');
    }
}
