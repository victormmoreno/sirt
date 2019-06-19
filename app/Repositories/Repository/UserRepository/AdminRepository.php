<?php

namespace App\Repositories\Repository\UserRepository;

use App\Models\Rols;
use App\User;
use Session;

class AdminRepository
{


    /*=======================================================================
    =            metodo para consultar todos los administradores            =
    =======================================================================*/

    public function getAllAdministradores()
    {
        return User::select('users.id', 'tiposdocumentos.nombre as tipodocumento', 'users.documento', 'rols.nombre as rol', 'users.email', 'users.direccion', 'users.celular', 'users.telefono', 'users.estado')
            ->selectRaw("CONCAT(users.nombres,' ',users.apellidos) as nombre")
            ->Join('tiposdocumentos', 'tiposdocumentos.id', '=', 'users.rol_id')
            ->Join('rols', 'rols.id', '=', 'users.rol_id')
            ->where('rols.nombre', '=', Rols::IsAdministrador())
            ->orderby('users.created_at', 'desc')
            ->get();

        // return User::select('users.id', 'tiposdocumentos.nombre as tipodocumento', 'users.documento', 'users.email', 'users.direccion', 'users.celular', 'users.telefono', 'users.estado')
        //     ->selectRaw("CONCAT(users.nombres,' ',users.apellidos) as nombre")
        //     ->Join('tiposdocumentos', 'tiposdocumentos.id', '=', 'users.rol_id')
        //     ->role('administrador')
        //     ->orderby('users.created_at','desc')
        //     ->get();
    }

    /*=====  End of metodo para consultar todos los administradores  ======*/

    /*==================================================================
    =            metodo para consultar todo el detalle del usuario por su id            =
    ==================================================================*/

    public function getFindDetailByid($id)
    {

        return User::select('users.id', 'tiposdocumentos.nombre as tipodocumento', 'users.documento', 'rols.nombre as rol', 'users.email', 'users.direccion', 'users.celular', 'users.telefono', 'users.estado')
            ->selectRaw("CONCAT(users.nombres,' ',users.apellidos) as nombre")
            ->Join('tiposdocumentos', 'tiposdocumentos.id', '=', 'users.rol_id')
            ->Join('rols', 'rols.id', '=', 'users.tipodocumento_id')
            ->findOrFail($id);

    }

    /*=====  End of metodo para consultar todo el detalle del usuario por su id  ======*/

    /*===============================================================
    =            metodo para consultar el usuario por id            =
    ===============================================================*/

    public function findById($id)
    {
        return User::findOrFail($id);
    }

    /*=====  End of metodo para consultar el usuario por id  ======*/

    /*=======================================================================================
    =            metodo para consultar toda la infomcacion del usuario por el id            =
    =======================================================================================*/

    public function findInfoUserById($id)
    {
        return User::select('users.id', 'users.rol_id', 'users.tipodocumento_id', 'users.gradoescolaridad_id', 'users.gruposanguineo_id', 'users.eps_id', 'users.ciudad_id', 'users.nombres', 'users.apellidos', 'users.documento', 'users.email', 'users.barrio', 'users.direccion', 'users.celular', 'users.telefono', 'users.fechanacimiento', 'users.genero', 'users.estado', 'users.estrato', 'ciudades.id as idciudad', 'ciudades.nombre as nombreciudad', 'departamentos.id as iddepartamento', 'departamentos.nombre as nombredepartamento')
            ->join('ciudades', 'ciudades.id', '=', 'users.ciudad_id')
            ->join('departamentos', 'departamentos.id', '=', 'ciudades.departamento_id')
            ->findOrFail($id);
    }

    /*=====  End of metodo para consultar toda la infomcacion del usuario por el id  ======*/

    /*==================================================================
    =            metodo para guardar un nuevo administrador            =
    ==================================================================*/
    public function Store($request, $password)
    {
        $user = User::create([
            "rol_id"              => Rols::where('nombre', '=', Rols::IsAdministrador())->first()->id,
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
            "estado"              => User::IsInactive(),
            "password"            => $password,
            "estrato"             => $request->input('txtestrato'),
        ]);

        $ocupaciones = \Session::has('ocupacion') ? \Session::get('ocupacion') : null;
        foreach ($ocupaciones->items as  $value) {
            $user->ocupaciones()->attach($value['item']->id);
        }
        \Session::forget('ocupacion');
        // $userAdmin->ocupaciones()->attach($ocupaciones);

        $user->assignRole(config('laravelpermission.roles.roleAdministrador'));

        return $user;

    }

    /*=====  End of metodo para guardar un nuevo administrador  ======*/

    /*=============================================================
    =            meotod para actualizar un dinamizador            =
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
        $user->estrato             = $request->input('txtestrato');
        $user->update();

        return $user;
    }

    /*=====  End of meotod para actualizar un dinamizador  ======*/

}
