<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\ArchivoComite;
use Carbon\Carbon;

class ArchivoController extends Controller
{
    public function store(Request $request)
    {
      $this->validate(request(), [
        'nombreArchivo' => 'max:50000|mimes:jpeg,png,jpg,docx,doc,pdf,exe,xlsl,xls,pptx,sldx,ppsx,exe,zip',
      ],
    [
      'nombreArchivo.mimes' => 'El tipo de archivo no es permitido',
      'nombreArchivo.max' => 'El tamaño del archivo no puede superar las 50MB'
    ]);


      $files = request()->file('nombreArchivo');
      $fileUrl = $files->store('public\\'.Carbon::now()->format('Y').'\CSIBT\comite1');
      return $fileUrl;
      // return $files;
      // $files->store()
      // return request()->file('nombreArchivo');
    }
}
