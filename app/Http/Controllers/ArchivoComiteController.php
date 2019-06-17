<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Comite;
use App\Models\Nodo;
use App\Models\ArchivoComite;
use Carbon\Carbon;
use App\Repositories\Repository\ArchivoComiteRepository;
use Alert;

class ArchivoComiteController extends Controller
{

  public $archivoComiteRepository;
  // Constructor de la clase
  public function __construct(ArchivoComiteRepository $archivoComiteRepository)
  {
    $this->archivoComiteRepository = $archivoComiteRepository;
  }


  // Guarda el archivo que se envia por ajax
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
      $fileUrl = request()->file('nombreArchivo')->store(auth()->user()->infocenter->nodo_id . '\\'.Carbon::now()->format('Y').'\CSIBT\\' . $id);
      // $fileUrl
      $this->archivoComiteRepository->store($id, Storage::url($fileUrl));
    }
  }
}
