<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\{Comite, Nodo, RutaModel};
use Carbon\Carbon;
use App\Repositories\Repository\ArchivoComiteRepository;
use Alert;
Use App\User;

class ArchivoComiteController extends Controller
{

  private $archivoComiteRepository;
  // Constructor de la clase
  public function __construct(ArchivoComiteRepository $archivoComiteRepository)
  {
    $this->archivoComiteRepository = $archivoComiteRepository;
  }


  public function destroy($idfile)
  {
    $file = RutaModel::find($idfile);
    $file->delete();
    $filePath = str_replace('storage', 'public', $file->ruta);
    Storage::delete($filePath);
    toast('El Archivo se ha eliminado con éxito!','success')->autoClose(2000)->position('top-end');
    return back();
  }

  /**
   * Descargar el archivo del servidor
   * @param int $idFile Id del archivo
   * @return Response
   * @author Victor Manuel Moreno Vega
   */
  public function downloadFile($idFile)
  {
    $ruta = $this->archivoComiteRepository->consultarRutaDeArchivoPorId($idFile);
    $path = str_replace('storage', 'public', $ruta->ruta);
    return Storage::download($path);
  }


  /**
   * Guarda el archivo de un comité que se envia por ajax
   * @param object $comite
   * @param int $id Id del comité
   * @return void
   * @author Victor Manuel Moreno Vega
   */
  public function store(Comite $comite, $id)
  {
    if (request()->ajax()) {
      $this->validate(request(), [
        'nombreArchivo' => 'max:50000|mimes:jpeg,png,jpg,docx,doc,pdf,exe,xlsl,xls,pptx,sldx,ppsx,exe,zip',
      ],
      [
        'nombreArchivo.mimes' => 'El tipo de archivo no es permitido',
        'nombreArchivo.max' => 'El tamaño del archivo no puede superar las 50MB'
      ]);
      $file = request()->file('nombreArchivo');
      $idmax = RutaModel::selectRaw('MAX(id+1) AS max')->get()->last();
      $idmax = $idmax->max;
      $fileName = $idmax . '_' . $file->getClientOriginalName();
      $fileUrl = $file->storeAs("public/" . auth()->user()->infocenter->nodo_id . '/'.Carbon::now()->format('Y').'/CSIBT//' . $id, $fileName);
      $this->archivoComiteRepository->store($id, Storage::url($fileUrl));
    }
  }
}
