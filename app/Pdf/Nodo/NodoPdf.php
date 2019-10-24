<?php

namespace App\Pdf\Nodo;

use App\Models\Nodo;
use PDF;
use Repositories\Repository\NodoRepository;

class NodoPdf{

	private $nodoRepository;

    public function __construct(NodoRepository $nodoRepository)
    {
        $this->setNodoRepository($nodoRepository);
    }

    /**
     * setter: Asigna un valor a $nodoRepository
     * @param object $nodoRepository
     * @return void
     * @author devjul
     */
    private function setNodoRepository($nodoRepository)
    {
        $this->nodoRepository = $nodoRepository;
    }

    /**
     * getter: Retorna el valor de $nodoRepository
     * @return object
     * @author devjul
     */
    private function getNodoRepository()
    {
        return $this->nodoRepository;
    }

	/**
     * descargar pdf equipo tecnoparque
     * @return object
     * @author devjul
     */
    public function downloadPdfEquipoNodo($extennsion = '.pdf', $orientacion = 'portrait')
    {
        $nodo = Nodo::first()->id;
        $nodo = $this->getNodoRepository()->getTeamTecnoparque()->findOrFail($nodo);
        // return $nodo;


        $pdf = PDF::loadView('pdf.nodo.reportEquipoNodo', [
        	'nodo' => $nodo
        ]);

        $pdf->setPaper(strtolower('LETTER'), $orientacion = 'landscape');

        return $pdf->stream("certificado  " . config('app.name') . $extennsion);
    }
}