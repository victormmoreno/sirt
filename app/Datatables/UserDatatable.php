<?php

namespace App\Datatables;

use App\User;

class UserDatatable
{
    public function datatableUsers($users)
    {
        return datatables()->of($users)
            ->addColumn('detail', function ($data) {
                $button = '<a href="' . route("usuario.show", $data->documento) . '" class="btn tooltipped bg-info m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Detalles"><i class="material-icons">visibility</i></a>';
                return $button;
            })
            ->editColumn('nodo', function ($data) {
                return $data->nodo;
            })
            ->editColumn('tipodocumento', function ($data) {
                return $data->tipodocumento;
            })
            ->editColumn('nombrecompleto', function ($data) {
                return !empty($data->usuario) ? $data->usuario : __('No register');
            })
            ->editColumn('celular', function ($data) {
                return !empty($data->celular) ? $data->celular : __('No register');
            })
            ->editColumn('rols', function ($data) {

                return !empty($data->roles) ? $data->roles : __('No register');
            })
            ->editColumn('login', function ($data) {
                return isset($data->ultimo_login) ? $data->ultimo_login->isoFormat('DD/MM/YYYY') : __('No register');
            })
            ->editColumn('state', function ($data) {
                return $data->estado == User::IsActive() && $data->deleted_at == null ? '<div class="chip bg-success  white-text">Habilitado</div>' : '<div class="chip bg-danger  white-text">Inhabilitado desde:'.  optional($data->deleted_at)->isoFormat('DD/MM/YYYY').'</div>';
            })
            ->rawColumns(['tipodocumento', 'nombrecompleto', 'detail', 'celular', 'rols', 'login', 'state'])
            ->make(true);
    }
}
