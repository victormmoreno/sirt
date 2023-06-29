<?php

namespace App\Http\Controllers\Excel;

use App\Http\Controllers\Controller;
use App\Repositories\Repository\UserRepository\UserRepository;
use App\User;
use App\Exports\User\UserExport;
use Illuminate\Http\Request;
use App\Helpers\AuthRoleHelper;

class UserExportController extends Controller
{
    /**
     * export the list resources
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|Response|\Illuminate\View\View
     */
    public function __invoque(Request $request, $extension = 'xlsx')
    {
        ini_set('memory_limit', '-1');
        set_time_limit('3000000');
        if (request()->user()->cannot('export', User::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $node = AuthRoleHelper::checkRoleAuth(['node' => $request->filter_nodo])['node'];
        $users = [];
        if (($request->filled('filter_nodo') || $request->filter_nodo == null) && ($request->filled('filter_role') || $request->filter_role == null) && $request->filled('filter_state') && ($request->filled('filter_year') || $request->filter_year == null)) {
            $users = User::query()
                ->select('users.id', 'tiposdocumentos.nombre as tipodocumento', 'users.fechanacimiento', 'users.documento', 'users.email', 'users.celular', 'users.telefono', 'gruposanguineos.nombre as grupo_sanguineo', 'users.estrato', 'users.direccion', 'etnias.nombre as etnia', 'users.descripcion_grado_discapacidad', 'eps.nombre as eps', 'users.otra_eps', 'users.institucion', 'users.titulo_obtenido', 'users.fecha_terminacion', 'users.ultimo_login', 'users.estado', 'users.deleted_at', 'gradosescolaridad.nombre as grado_escolaridad')
                ->selectRaw('concat(users.nombres, " ",users.apellidos) as usuario, concat(expedition_city.nombre, " (",expedition_depart.nombre,")") as expedicion, concat(residency_city.nombre, " (",residency_depart.nombre,")") as residencia, GROUP_CONCAT(DISTINCT roles.name SEPARATOR ", ") as roles, GROUP_CONCAT(DISTINCT ocupaciones.nombre SEPARATOR ", ") as ocupaciones')
                ->selectRaw("if(entidades.nombre is null, 'No Aplica', entidades.nombre) as nodo")
                ->selectRaw("if(users.genero = 1, 'Masculino', 'Femenino') as genero, if(users.grado_discapacidad = 1, 'Si', 'No') as grado_discapacidad")
                ->leftJoin('ciudades as expedition_city', 'expedition_city.id', '=', 'users.ciudad_expedicion_id')
                ->leftJoin('departamentos as expedition_depart', 'expedition_depart.id', '=', 'expedition_city.departamento_id')
                ->leftJoin('gruposanguineos', 'gruposanguineos.id', '=', 'users.gruposanguineo_id')
                ->leftJoin('gradosescolaridad', 'gradosescolaridad.id', '=', 'users.gradoescolaridad_id')
                ->leftJoin('ciudades as residency_city', 'residency_city.id', '=', 'users.ciudad_id')
                ->leftJoin('departamentos as residency_depart', 'residency_depart.id', '=', 'residency_city.departamento_id')
                ->leftJoin('etnias', 'etnias.id', '=', 'users.etnia_id')
                ->leftJoin('eps', 'eps.id', '=', 'users.eps_id')
                ->leftJoin('ocupaciones_users', 'ocupaciones_users.user_id', '=', 'users.id')
                ->leftJoin('ocupaciones', 'ocupaciones.id', '=', 'ocupaciones_users.ocupacion_id')
                ->userQuery()
                ->nodeQuery($request->filter_role, $node)
                ->roleQuery($request->filter_role)
                ->stateDeletedAt($request->filter_state)
                ->groupBy('users.id')
                ->orderBy('users.created_at', 'desc')
                ->get();
        }
        return (new UserExport($request, $users))->download("Usuarios - " . config('app.name') . ".{$extension}");
    }
}
