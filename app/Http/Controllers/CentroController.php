<?php

namespace App\Http\Controllers;

use App\Repositories\Repository\CentroRepository;
use Illuminate\Http\Request;

class CentroController extends Controller
{
    public $centroRepository;

    public function __construct(CentroRepository $centroRepository)
    {
        $this->centroRepository = $centroRepository;
    }

    public function getAllCentrosForRegional($regional)
    {
        $centros = $this->centroRepository->getAllCentrosRegional($regional);

        return response()->json([
            'centros' =>  $centros,
        ]);
    }
}
