<?php

namespace App\Helpers;

use App\User;

class AuthRoleHelper
{
    /**
     * method to validate the authenticated role
     * @return array
     */
    public static function checkRoleAuth($request): array
    {
        $talent = null;
        $node = null;
        switch (\Session::get('login_role')) {
            case User::IsAdministrador():
                if (!empty($request)) {
                    $node = $request['node'];
                }
                break;
            case User::IsActivador():
                if (!empty($request)) {
                    $node = $request['node'];
                }
                break;
            case User::IsDinamizador():
                $node = auth()->user()->dinamizador->nodo_id;
                break;
            case User::IsInfocenter():
                $node = auth()->user()->infocenter->nodo_id;
                break;
            case User::IsArticulador():
                $node = auth()->user()->articulador->nodo_id;
                break;
            case User::IsTalento():
                $node = null;
                $talent = auth()->user()->id;
                break;
            default:
                $talent = null;
                $node = null;
                break;
        }
        return ['talent' => $talent, 'node' => $node];
    }
}
