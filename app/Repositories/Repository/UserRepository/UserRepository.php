<?php

namespace App\Repositories\Repository\UserRepository;

use App\Models\ActivationToken;
use App\Models\Ciudad;
use App\Models\Departamento;
use App\Models\Eps;
use App\Models\GradoEscolaridad;
use App\Models\GrupoSanguineo;
use App\Models\Ocupacion;
use App\Models\TipoDocumento;
use App\User;
use Carbon\Carbon;

class UserRepository
{
	/*===========================================================================
    =            metodo para consultar todos los tipos de documentos            =
    ===========================================================================*/

    public function getAllTipoDocumento()
    {
        return TipoDocumento::allTipoDocumento()->get();
    }

    /*=====  End of metodo para consultar todos los tipos de documentos  ======*/

    /*=====================================================================
    =            metodo para consultar todos los departamentos            =
    =====================================================================*/

    public function getAllDepartamentos()
    {
        return Departamento::allDepartamentos()->get();
    }

    /*=====  End of metodo para consultar todos los departamentos  ======*/

    /*=================================================================
    =            metodo para consultar todoas las ciudades            =
    =================================================================*/

    public function getAllCiudades()
    {
        return Ciudad::all();
    }

    /*=====  End of metodo para consultar todoas las ciudades  ======*/

    /*============================================================================
    =            metodo para consultar las ciudades por departmamento            =
    ============================================================================*/

    public function getAllCiudadDepartamento($departamento)
    {
        return Ciudad::allCiudadDepartamento($departamento)->get();
    }

    /*=====  End of metodo para consultar las ciudades por departmamento  ======*/

    
    /*=============================================================================
    =            metodo para consultar todos los grados de escolaridad            =
    =============================================================================*/

    public function getSelectAllGradosEscolaridad()
    {
        return GradoEscolaridad::allGradosEscolaridad()->orderby('gradosescolaridad.id')->get();
    }

    /*=====  End of metodo para consultar todos los grados de escolaridad  ======*/

    /*=========================================================================
    =            metodo para consultar todos los grupos sanguineos            =
    =========================================================================*/

    public function getAllGrupoSanguineos()
    {
        return GrupoSanguineo::allGrupoSanguineos('gruposanguineos.nombre')->get();
    }

    /*=====  End of metodo para consultar todos los grupos sanguineos  ======*/

    /*===========================================================================
    =            metodo para consultar todos las eps segun su estado            =
    ===========================================================================*/

    public function getAllEpsActivas()
    {
        return Eps::allEps(Eps::IsActive(), 'eps.nombre')->get();
    }

    /*=====  End of metodo para consultar todos las eps segun su estado  ======*/

    /*===============================================
    =            metodod para registrar  token de activacion           =
    ===============================================*/

    public function activationToken($user)
    {
        return ActivationToken::create([
            'user_id'    => $user,
            'token'      => str_random(60),
            'created_at' => Carbon::now(),
        ]);
    }

    /*=====  End of metodod para registrar   ======*/


    /*====================================================================
    =            metodo para  consultar todas las ocupaciones            =
    ====================================================================*/
    
    public function getAllOcupaciones()
    {
        return Ocupacion::allOcupaciones()->orderBy('nombre')->get();
    }
    
    /*=====  End of metodo para  consultar todas las ocupaciones  ======*/

     /*===============================================================
    =            metodo para consultar el usuario por id            =
    ===============================================================*/

    public function findById($id)
    {
        return User::findOrFail($id);
    }

    /*=====  End of metodo para consultar el usuario por id  ======*/

    /*========================================================================
    =            metodo para consultar la informacion del usuario            =
    ========================================================================*/
    
    public function account($documento)
    {
        return User::where('documento',$documento)->firstOrFail();
    }
    
    /*=====  End of metodo para consultar la informacion del usuario  ======*/
    
    

}