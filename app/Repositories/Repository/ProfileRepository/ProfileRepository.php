<?php

namespace App\Repositories\Repository\ProfileRepository;

use App\Models\Eps;

class ProfileRepository
{
	/*=====================================================================
	=            metodo para actualizar el perfil del ususario            =
	=====================================================================*/
	
	public function Update($request, $user)
    {
    	$user->update([
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
            "otra_eps"            => $request->input('txteps') == Eps::where('nombre', Eps::OTRA_EPS)->first()->id ? $request->input('txtotraeps') : null,
            "estrato"             => $request->input('txtestrato'),
    	]);

    	return $user;
    }
	
	/*=====  End of metodo para actualizar el perfil del ususario  ======*/


    /*=====================================================================
    =            metodo para actualizar la constraseña del usuario            =
    =====================================================================*/
    public function updatePassword($request, $user)
    {

        $user->update([
            "password"           => $request->input('txtnewpassword'),
        ]);

        return $user;
    }
    /*=====  End of metodo para actualizar la constraseña del usuario  ======*/


	
}