<?php

namespace App\Repositories\Repository;

use App\Models\Empresa;
use App\Models\Sector;

class EmpresaRepository
{
  // Consulta las empresas de la red de tecnoparque
  public function consultarEmpresasDeRedTecnoparque()
  {
    return Empresa::select('nit', 'direccion', 'entidades.nombre AS nombre_empresa', 'empresas.id')
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
