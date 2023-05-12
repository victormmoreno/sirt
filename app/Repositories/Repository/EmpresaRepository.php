<?php

namespace App\Repositories\Repository;

use App\Models\{Empresa, Sede, Proyecto};
use Illuminate\Support\Facades\{DB, Session};
use App\User;

class EmpresaRepository
{

    // Modifica los datos de una empresa
    public function update($request, $empresa)
    {
        DB::beginTransaction();
        try {
            $empresa->update([
                'sector_id' => $request->input('txtsector_empresa'),
                'tipoempresa_id' => $request->input('txttipoempresa_id_empresa'),
                'tamanhoempresa_id' => $request->input('txttamanhoempresa_id_empresa'),
                'nombre' => $request->input('txtnombre_empresa'),
                'email' => $request->input('txtemail_empresa'),
                'nit' => $request->input('txtnit_empresa'),
                'fecha_creacion' => $request->input('txtfecha_creacion_empresa'),
                'codigo_ciiu' => $request->input('txtcodigo_ciiu_empresa')
            ]);
            DB::commit();
            return [
                'state' => true,
                'msg' => 'Los datos de la empresa se han modificado exitosamente!',
                'title' => 'Modificación exitosa!',
                'type' => 'success'
            ];
            return $empresa;
        } catch (\Exception $e) {
            DB::rollback();
            return [
                'state' => false,
                'msg' => 'Los datos de la empresa no se han modificado!',
                'title' => 'Modificación errónea!',
                'type' => 'error'
        ];
        }

    }

    // Modifica los datos de una sede
    public function updateSedes($request, $sede)
    {
        DB::beginTransaction();
        try {
            $sede->update([
                'ciudad_id' => $request->input('txtciudad_id_sede'),
                'nombre_sede' => $request->input('txtnombre_sede'),
                'direccion' => $request->input('txtdireccion_sede')
            ]);
            DB::commit();
            return [
                'state' => true,
                'msg' => 'Los datos de la sede se han modificado exitosamente!',
                'title' => 'Modificación exitosa!',
                'type' => 'success'
            ];
        } catch (\Exception $e) {
            DB::rollback();
            return [
                'state' => false,
                'msg' => 'Los datos de la sede no se han modificado!',
                'title' => 'Modificación errónea!',
                'type' => 'error'
            ];
        }

    }

    public function storeSede($request, $empresa)
    {
        DB::beginTransaction();
        try {
            $empresa->sedes()->create([
                'ciudad_id' => $request->input('txtciudad_id_sede'),
                'nombre_sede' => $request->input('txtnombre_sede'),
                'direccion' => $request->input('txtdireccion_sede')
            ]);
            DB::commit();
            return [
                'state' => true,
                'msg' => 'Los datos de la sede se han registrado exitosamente!',
                'title' => 'Registro exitoso!',
                'type' => 'success'
            ];
        } catch (\Exception $e) {
            DB::rollback();
            return [
                'state' => false,
                'msg' => 'Los datos de la sede no se han registrado!',
                'title' => 'Registro erróneo!',
                'type' => 'error'
            ];
        }
    }

    // Modifica los datos de una sede
    public function update_responsable($request, $empresa)
    {
        DB::beginTransaction();
        try {
        $user = null;
        if ($request->input('txttype_search') == 1) {
            $user = User::withTrashed()->where('documento', 'LIKE', "%" . $request->input('txtsearch_user') . "%")->first();
        } else {
            $user = User::withTrashed()->where('email', 'LIKE', "%" . $request->input('txtsearch_user') . "%")->first();
        }

        if ($user == null) {
            return [
                'state' => false,
                'msg' => 'El usuario no existe!',
                'title' => 'Modificación errónea!',
                'type' => 'error'
            ];
        }

        $empresa->update([
            'user_id' => $user->id
        ]);
        DB::commit();
            return [
                'state' => true,
                'msg' => 'El responsable de la empresa se ha modificado exitosamente!',
                'title' => 'Modificación exitosa!',
                'type' => 'success'
            ];
        } catch (\Exception $e) {
        DB::rollback();
            return [
                'state' => false,
                'msg' => 'El responsable de la empresa no se ha modificado!',
                'title' => 'Modificación errónea!',
                'type' => 'error'
            ];
        }

    }

    // Registra una empresa en la base de datos
    public function store($request)
    {
        DB::beginTransaction();
        try {
            $user_id = null;
            if (Session::get('login_role') == User::IsTalento()) {
                $user_id = auth()->user()->id;
            }

            $empresa = Empresa::create([
                'sector_id' => $request->input('txtsector_empresa'),
                'user_id' => $user_id,
                'tipoempresa_id' => $request->input('txttipoempresa_id_empresa'),
                'tamanhoempresa_id' => $request->input('txttamanhoempresa_id_empresa'),
                'nombre' => $request->input('txtnombre_empresa'),
                'email' => $request->input('txtemail_empresa'),
                'nit' => $request->input('txtnit_empresa'),
                'fecha_creacion' => $request->input('txtfecha_creacion_empresa'),
                'codigo_ciiu' => $request->input('txtcodigo_ciiu_empresa')
            ]);

            $sede = Sede::create([
                'empresa_id' => $empresa->id,
                'ciudad_id' => $request->input('txtciudad_id_sede'),
                'nombre_sede' => $request->input('txtnombre_sede'),
                'direccion' => $request->input('txtdireccion_sede')
            ]);

            DB::commit();
            return [
                'state' => true,
                'empresa' => $empresa,
                'sede' => $sede
            ];
        } catch (\Exception $e) {
            DB::rollback();
            return [
                'state' => false,
                'empresa' => null,
                'sede' => null
            ];
        }

    }

    // Consulta las empresas de la red de tecnoparque
    public function consultarEmpresas()
    {
        return Empresa::select('nit',
        'empresas.id',
        'empresas.nombre AS nombre_empresa',
        'sectores.nombre AS sector_empresa')
        ->join('sectores', 'sectores.id', '=', 'empresas.sector_id')
        ->leftJoin('users', 'users.id', '=', 'empresas.user_id');
    }

    public function consultarSedeRepository($id)
    {
        return Sede::where('id', $id)->with('empresa', 'ciudad', 'ciudad.departamento');
    }

    public function consultarEmpresaParams(string $field, string $value)
    {
        return Empresa::where($value, $field)->with('sector', 'tipoempresa', 'tamanhoempresa', 'sedes', 'sedes.ciudad', 'sedes.ciudad.departamento');
    }

    /**
        * Consulta los detalles de una empresa
        * @param $param Valor del parámetro por el que se va a filtrar
        * @param $field Nombre del campo por el que se va a filtrar
        * @return Builder
        * @author dum
        */
    public function consultarDetallesDeUnaEmpresa($id)
    {
        return Empresa::find($id);
    }

}
