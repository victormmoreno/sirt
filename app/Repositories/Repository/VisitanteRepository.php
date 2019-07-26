<?php

namespace App\Repositories\Repository;

use App\Models\{Visitante};
use Illuminate\Support\Facades\{DB};

class VisitanteRepository
{

  /**
   * undocumented function summary
   *
   * Undocumented function long description
   *
   * @param type var Description
   * @return return type
   */
  public function consultarVisitante($id)
  {
    return Visitante::select('nombres',
    'documento',
    'tipovisitante_id',
    'tipodocumento_id',
    'contacto',
    'email',
    'visitantes.id',
    'apellidos')
    ->join('tiposvisitante', 'tiposvisitante.id', '=', 'visitantes.tipovisitante_id')
    ->join('tiposdocumentos', 'tiposdocumentos.id', '=', 'visitantes.tipodocumento_id')
    ->where('visitantes.id', $id)
    ->first();
  }

  /**
   * Modifica los datos de un visitante por su ID
   * @param Request $request
   * @param int $id Id del visitante
   * @return array
   */
  public function updateVisitanteRepository($request, $id)
  {
    DB::beginTransaction();
    try {
      $visitante = Visitante::findOrFail($id);
      $visitante->update([
        'documento' => $request->txtdocumento,
        'tipodocumento_id' => $request->txttipodocumento_id,
        'tipovisitante_id' => $request->txttipovisitante_id,
        'nombres' => $request->txtnombres,
        'apellidos' => $request->txtapellidos,
        'email' => $request->txtemail,
        'contacto' => $request->txtcontacto,
      ]);
      DB::commit();
      return array('update' => true, 'visitante' => $visitante);
    } catch (\Exception $e) {
      DB::rollback();
      return array('update' => false, 'visitante' => "");
    }

  }

  /**
   * Registra un visitante en la base de datos
   * @param Request $request
   * @return array
   */
  public function storeVisitanteRepository($request)
  {
    DB::beginTransaction();
    try {
      $visitante = Visitante::create([
        'documento' => $request->txtdocumento,
        'tipodocumento_id' => $request->txttipodocumento_id,
        'tipovisitante_id' => $request->txttipovisitante_id,
        'nombres' => $request->txtnombres,
        'apellidos' => $request->txtapellidos,
        'email' => $request->txtemail,
        'contacto' => $request->txtcontacto,
        'estado' => Visitante::IsActive()
      ]);
      DB::commit();
      return array('reg' => true, 'visitante' => $visitante);
    } catch (\Exception $e) {
      DB::rollback();
      return array('reg' => false, 'visitante' => "");
    }
  }
  /**
   * Consulta todos los visitantes de tecnoparque
   * @return Collection
   */
  public function visitantesRedTecnoparque()
  {
    return Visitante::select('documento',
    'contacto',
    'tiposdocumentos.nombre AS tipo_documento',
    'tiposvisitante.nombre AS tipo_visitante',
    'visitantes.id',
    'email')
    ->selectRaw('concat(nombres, " ", apellidos) AS visitante')
    ->join('tiposvisitante', 'tiposvisitante.id', '=', 'visitantes.tipovisitante_id')
    ->join('tiposdocumentos', 'tiposdocumentos.id', '=', 'visitantes.tipodocumento_id')
    ->get();
  }
}
