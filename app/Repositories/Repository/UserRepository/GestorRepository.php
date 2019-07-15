<?php

namespace App\Repositories\Repository\UserRepository;

use App\Models\Eps;
use App\Models\Gestor;
use App\Models\Rols;
use App\User;


class GestorRepository
{


	// Consulta los gestores de una línea tecnológica por nodo
	public function consultarGestoresPorLineaTecnologicaYNodoRepository($id, $idnodo)
	{
		// return User::roles('Gestor')->get();
		return User::select('gestores.id')
		->selectRaw('CONCAT(users.nombres, " ", users.apellidos) AS gestor')
		->join('gestores', 'gestores.user_id', '=', 'users.id')
		->join('nodos', 'nodos.id', '=', 'gestores.nodo_id')
		->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'gestores.lineatecnologica_id')
		->where('nodos.id', $idnodo)
		->where('lineastecnologicas.id', $id)
		->get();
	}

	public function getAllGestoresPorNodo($nodo)
    {
        return User::select('users.id', 'tiposdocumentos.nombre as tipodocumento', 'users.documento', 'rols.nombre as rol', 'users.email', 'users.direccion', 'users.celular', 'users.telefono', 'users.estado')
            ->selectRaw("CONCAT(users.nombres,' ',users.apellidos) as nombre")
            ->Join('tiposdocumentos', 'tiposdocumentos.id', '=', 'users.tipodocumento_id')
            ->Join('gestores', 'gestores.user_id', '=', 'users.id')
            ->Join('nodos', 'nodos.id', '=', 'gestores.nodo_id')
            ->Join('rols', 'rols.id', '=', 'users.rol_id')
            ->role(User::IsGestor())
            ->where('nodos.id', '=', $nodo)
            ->orderby('users.created_at', 'desc')
            ->get();

    }

    /*=================================================================
    =            metodo para registrar un usuario - gestor            =
    =================================================================*/

    public function Store($request, $password)
    {

        $user = User::create([
            "rol_id"              => Rols::where('nombre', '=', Rols::IsGestor())->first()->id,
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

        $gestor = Gestor::create([
            'user_id' => $user->id,
            'nodo_id' => $request->get('txtnodo'),
            'lineatecnologica_id' => $request->get('txtlinea'),
            'honorarios' => $request->get('txthonorario'),
        ]);

        $user->ocupaciones()->sync($request->get('txtocupaciones'));


        $user->assignRole(config('laravelpermission.roles.roleGestor'));

        return $user;

    }

    /*=====  End of metodo para registrar un usuario - gestor  ======*/


}
