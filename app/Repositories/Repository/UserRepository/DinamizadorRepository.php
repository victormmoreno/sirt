<?php

namespace App\Repositories\Repository\UserRepository;

use App\Models\Dinamizador;
use App\Models\Eps;
use App\Models\Nodo;
use App\Models\Rols;
use App\User;

class DinamizadorRepository
{
    /*=============================================================
    =            metodo para consultar todos los nodos            =
    =============================================================*/

    public function getAllNodos()
    {
        return Nodo::selectNodo()->get();
    }

    /*=====  End of metodo para consultar todos los nodos  ======*/

    /*===============================================================================
    =            metodo para constultar todos los dinamizadores por nodo            =
    ===============================================================================*/

    public function getAllDinamizadoresPorNodo($nodo)
    {
        return User::select('users.id', 'tiposdocumentos.nombre as tipodocumento', 'users.documento', 'rols.nombre as rol', 'users.email', 'users.direccion', 'users.celular', 'users.telefono', 'users.estado')
            ->selectRaw("CONCAT(users.nombres,' ',users.apellidos) as nombre")
            ->Join('tiposdocumentos', 'tiposdocumentos.id', '=', 'users.tipodocumento_id')
            ->Join('dinamizador', 'dinamizador.user_id', '=', 'users.id')
            ->Join('nodos', 'nodos.id', '=', 'dinamizador.nodo_id')
            ->Join('rols', 'rols.id', '=', 'users.rol_id')
            ->role(User::IsDinamizador())
            ->where('nodos.id', '=', $nodo)
            ->orderby('users.created_at', 'desc')
            ->get();

    }

    /*=====  End of metodo para constultar todos los dinamizadores por nodo  ======*/

    /*=============================================================
    =            metodo para consultar todos los nodos            =
    =============================================================*/

    public function getAllNodosPluck()
    {
        return Nodo::selectNodo()->pluck('nodos', 'id');
    }

    /*=====  End of metodo para consultar todos los nodos  ======*/

    /*==========================================================
    =            metodo para guardar un dinamizador            =
    ==========================================================*/
    public function Store($request, $password)
    {

        $user = User::create([
            "rol_id"              => Rols::where('nombre', '=', Rols::IsDinamizador())->first()->id,
            "tipodocumento_id"    => $request->input('txttipo_documento'),
            "gradoescolaridad_id" => $request->input('txtgrado_escolaridad'),
            "gruposanguineo_id"   => $request->input('txtgruposanguineo'),
            "eps_id"              => $request->input('txteps'),
            "ciudad_id"           => $request->input('txtciudad'),
            "nombres"             => $request->input('txtnombres'),
            "apellidos"           => $request->input('txtapellidos'),
            "documento"           => $request->input('txtdocumento'),
            "email"               => $request->input('txtemail'),
            "barrio"              => $request->input('txtbarrio'),
            "direccion"           => $request->input('txtdireccion'),
            "celular"             => $request->input('txtcelular'),
            "telefono"            => $request->input('txttelefono'),
            "fechanacimiento"     => $request->input('txtfecha_nacimiento'),
            "genero"              => $request->input('txtgenero') == 'on' ? $request['txtgenero'] = 0 : $request['txtgenero'] = 1,
            "otra_eps"            => $request->input('txteps') == Eps::where('nombre', Eps::OTRA_EPS)->first()->id ? $request->input('txtotraeps') : null,
            "estado"              => User::IsInactive(),
            "password"            => $password,
            "estrato"             => $request->input('txtestrato'),
        ]);

        $dinamizador = Dinamizador::create([
            'nodo_id' => $request->get('txtnodo'),
            'user_id' => $user->id,
        ]);

        $user->ocupaciones()->sync($request->get('txtocupaciones'));

        // $user->dinamizador()->save($request->get('txtnodo'));

        $user->assignRole(config('laravelpermission.roles.roleDinamizador'));

        return $user;

    }

    /*=====  End of metodo para guardar un dinamizador  ======*/

    /*=============================================================
    =            metodo para actializar un dinamizador            =
    =============================================================*/
    public function Update($request, $user)
    {
        $user->tipodocumento_id    = $request->input('txttipo_documento');
        $user->gradoescolaridad_id = $request->input('txtgrado_escolaridad');
        $user->gruposanguineo_id   = $request->input('txtgruposanguineo');
        $user->eps_id              = $request->input('txteps');
        $user->ciudad_id           = $request->input('txtciudad');
        $user->nombres             = $request->input('txtnombres');
        $user->apellidos           = $request->input('txtapellidos');
        $user->documento           = $request->input('txtdocumento');
        $user->email               = $request->input('txtemail');
        $user->barrio              = $request->input('txtbarrio');
        $user->direccion           = $request->input('txtdireccion');
        $user->celular             = $request->input('txtcelular');
        $user->telefono            = $request->input('txttelefono');
        $user->fechanacimiento     = $request->input('txtfecha_nacimiento');
        $user->genero              = $request->input('txtgenero') == 'on' ? $request['txtgenero']              = 0 : $request['txtgenero']              = 1;
        $user->otra_eps            = $request->input('txteps') == Eps::where('nombre', Eps::OTRA_EPS)->first()->id ? $request->input('txtotraeps') : null;
        $user->estrato             = $request->input('txtestrato');
        $user->update();

        $dinamizador = Dinamizador::where('user_id', $user->id)->first();
        $dinamizador->nodo_id = $request->get('txtnodo');
        $dinamizador->update();

        $user->ocupaciones()->sync($request->get('txtocupaciones'));

        return $user;
    }
    
    
    /*=====  End of metodo para actializar un dinamizador  ======*/
    

}
