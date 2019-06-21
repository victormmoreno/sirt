<?php

namespace App\Repositories\Repository;

use App\Models\Empresa;
use App\Models\Sector;
use App\Models\Entidad;

class EmpresaRepository
{

  // Modifica los datos de una empresa
  public function update($request, $empresa)
  {
    $empresa->entidad->ciudad_id = $request->input('txtciudad_id');
    $empresa->entidad->nombre = $request->input('nombre');
    $empresa->entidad->email_entidad = $request->input('email_entidad');
    $empresa->entidad->update();
    $empresa->sector_id = $request->input('txtsector');
    $empresa->nit = $request->input('nit');
    $empresa->direccion = $request->input('direccion');
    $empresa->nombre_contacto = $request->input('nombre_contacto');
    $empresa->correo_contacto = $request->input('email_contacto');
    $empresa->telefono_contacto = $request->input('telefono_contacto');
    $empresa->update();
    return $empresa;
  }

  // Registra una empresa en la base de datos
  public function store($request)
  {
     $entidad = Entidad::create([
      'ciudad_id' => $request->input('txtciudad_id'),
      'nombre' => $request->input('nombre'),
      'email_entidad' => $request->input('email_entidad'),
    ]);

    return Empresa::create([
      'entidad_id' => $entidad->id,
      'sector_id' => $request->input('txtsector'),
      'nit' => $request->input('nit'),
      'direccion' => $request->input('direccion'),
      'nombre_contacto' => $request->input('nombre_contacto'),
      'correo_contacto' => $request->input('email_contacto'),
      'telefono_contacto' => $request->input('telefono_contacto'),
    ]);
  }

  // Consulta las empresas de la red de tecnoparque
  public function consultarEmpresasDeRedTecnoparque()
  {
    return Empresa::select('nit', 'direccion', 'entidades.nombre AS nombre_empresa', 'empresas.id', 'sectores.nombre AS sector_empresa')
    ->selectRaw('CONCAT(ciudades.nombre, " - ", departamentos.nombre) AS ciudad')
    ->join('entidades', 'entidades.id', '=', 'empresas.entidad_id')
    ->join('sectores', 'sectores.id', '=', 'empresas.sector_id')
    ->join('ciudades', 'ciudades.id', '=', 'entidades.ciudad_id')
    ->join('departamentos', 'departamentos.id', '=', 'ciudades.departamento_id')
    ->get();
  }

  // Consulta los detalles de una empresa
  public function consultarDetallesDeUnaEmpresa($id)
  {
    return Empresa::select('nit', 'direccion', 'entidades.nombre AS nombre_empresa', 'empresas.id', 'nombre_contacto', 'correo_contacto', 'telefono_contacto', 'email_entidad')
    ->selectRaw('CONCAT(ciudades.nombre, " - ", departamentos.nombre) AS ciudad')
    ->join('entidades', 'entidades.id', '=', 'empresas.entidad_id')
    ->join('sectores', 'sectores.id', '=', 'empresas.sector_id')
    ->join('ciudades', 'ciudades.id', '=', 'entidades.ciudad_id')
    ->join('departamentos', 'departamentos.id', '=', 'ciudades.departamento_id')
    ->where('empresas.id', $id)
    ->get()
    ->last();
  }

}
