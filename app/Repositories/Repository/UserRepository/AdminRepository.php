<?php

namespace App\Repositories\Repository\UserRepository;

use App\Models\ActivationToken;
use App\Models\GradoEscolaridad;
use App\Models\Rols;
use App\Models\TipoDocumento;
use App\User;
use Carbon\Carbon;

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
            ->get();
    }

    /*=====  End of metodo para consultar todos los administradores  ======*/

    /*===========================================================================
    =            metodo para consultar todos los tipos de documentos            =
    ===========================================================================*/

    public function getAllTipoDocumento()
    {
        return TipoDocumento::allTipoDocumento()->get();
    }

    /*=====  End of metodo para consultar todos los tipos de documentos  ======*/

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

    /*=============================================================================
    =            metodo para consultar todos los grados de escolaridad            =
    =============================================================================*/

    public function getSelectAllGradosEscolaridad()
    {
        return GradoEscolaridad::allGradosEscolaridad()->orderby('gradosescolaridad.id')->get();
    }

    /*=====  End of metodo para consultar todos los grados de escolaridad  ======*/

    /*===============================================================
    =            metodo para consultar el usuario por id            =
    ===============================================================*/

    public function findById($id)
    {
        return User::findOrFail($id);
    }

    /*=====  End of metodo para consultar el usuario por id  ======*/

    /*==================================================================
    =            metodo para guardar un nuevo administrador            =
    ==================================================================*/
    public function Store($request, $password)
    {
        return User::create([
            "rol_id"              => Rols::where('nombre', '=', Rols::IsAdministrador())->first()->id,
            "gradoescolaridad_id" => $request->input('txtgrado_escolaridad'),
            "tipodocumento_id"    => $request->input('txttipo_documento'),
            "nombres"             => $request->input('txtnombres'),
            "apellidos"           => $request->input('txtapellidos'),
            "documento"           => $request->input('txtdocumento'),
            "email"               => $request->input('txtemail'),
            "direccion"           => $request->input('txtdireccion'),
            "celular"             => $request->input('txtcelular'),
            "telefono"            => $request->input('txttelefono'),
            "fechanacimiento"     => $request->input('txtfecha_nacimiento'),
            "genero"              => $request->input('txtgenero') == 'on' ? $request['txtgenero'] = 0 : $request['txtgenero'] = 1,
            "estado"              => User::IsInactive(),
            "password"            => $password,
            "estrato"           => $request->input('txtestrato'),
        ]);

    }

    /*=====  End of metodo para guardar un nuevo administrador  ======*/

    /*===============================================
    =            metodod para registrar  token de activacion           =
    ===============================================*/
    
    public function activationToken($user)
    {
        return ActivationToken::create([
            'user_id' => $user,
            'token' =>str_random(60),
            'created_at' => Carbon::now(),
        ]);
    }
    
    
    /*=====  End of metodod para registrar   ======*/
    

}
