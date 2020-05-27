<?php

namespace App\Exports\Nodo;

use App\Exports\FatherExport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\Exportable;

class NodoInfoExport implements WithMultipleSheets
{
    use Exportable;
    private $query; //info nodo
    private $queryDinamizadores;
    private $queryGestores;
    private $queryInfocenters;
    private $queryIngresos;
    private $queryLineas;


    public function __construct($query, $queryDinamizadores, $queryGestores, $queryInfocenters, $queryIngresos, $queryLineas, $queryLaboratorios)
    {
        $this->setQueryNodo($query);
        $this->setQueryDinamizadores($queryDinamizadores);
        $this->setQueryGestores($queryGestores);
        $this->setQueryInfocenters($queryInfocenters);
        $this->setQueryIngresos($queryIngresos);
        $this->setQueryLineas($queryLineas);
        $this->setQueryLaboratorios($queryLaboratorios);
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new NodoDinamizadorSheetExport($this->getQueryDinamizadores(), $this->getQueryNodo(), 'Dinamizador');
        $sheets[] = new NodoGestoresSheetExport($this->getQueryGestores(), $this->getQueryNodo(),  'Gestores');
        $sheets[] = new NodoInfocenterSheetExport($this->getQueryInfocenters(), $this->getQueryNodo(),  'Infocenter');
        $sheets[] = new NodoIngresoSheetExport($this->getQueryIngresos(), $this->getQueryNodo(),  'Ingreso');
        $sheets[] = new NodoLineaSheetExport($this->getQueryLineas(), $this->getQueryNodo(),  'Lineas');

        return $sheets;
    }

    /**
     * Asigna un valor a $queryDinamizadores
     * @param Collection $queryDinamizadores
     * @return void
     * @author devjul
     */
    private function setQueryNodo($query)
    {
        $this->query = $query;
    }

    /**
     * Retorna el valor de $queryDinamizadores
     * @author devjul
     * @return Collection
     */
    private function getQueryNodo()
    {
        return $this->query;
    }

    /**
     * Asigna un valor a $queryDinamizadores
     * @param Collection $queryDinamizadores
     * @return void
     * @author devjul
     */
    private function setQueryDinamizadores($queryDinamizadores)
    {
        $this->queryDinamizadores = $queryDinamizadores;
    }

    /**
     * Retorna el valor de $queryDinamizadores
     * @author devjul
     * @return Collection
     */
    private function getQueryDinamizadores()
    {
        return $this->queryDinamizadores;
    }

    /**
     * Asigna un valor a $queryDinamizadores
     * @param Collection $queryDinamizadores
     * @return void
     * @author devjul
     */
    private function setQueryGestores($queryGestores)
    {
        $this->queryGestores = $queryGestores;
    }

    /**
     * Retorna el valor de $queryPF
     * @author devjul
     * @return Collection
     */
    private function getQueryGestores()
    {
        return $this->queryGestores;
    }

    /**
     * Asigna un valor a $queryDinamizadores
     * @param Collection $queryDinamizadores
     * @return void
     * @author devjul
     */
    private function setQueryInfocenters($queryInfocenters)
    {
        $this->queryInfocenters = $queryInfocenters;
    }

    /**
     * Retorna el valor de $queryInfocenters
     * @author devjul
     * @return Collection
     */
    private function getQueryInfocenters()
    {
        return $this->queryInfocenters;
    }

    /**
     * Asigna un valor a $queryIngresos
     * @param Collection $queryIngresos
     * @return void
     * @author devjul
     */
    private function setQueryIngresos($queryIngresos)
    {
        $this->queryIngresos = $queryIngresos;
    }

    /**
     * Retorna el valor de $queryIngresos
     * @author devjul
     * @return Collection
     */
    private function getQueryIngresos()
    {
        return $this->queryIngresos;
    }

    /**
     * Asigna un valor a $queryLineas
     * @param Collection $queryLineas
     * @return void
     * @author devjul
     */
    private function setQueryLineas($queryLineas)
    {
        $this->queryLineas = $queryLineas;
    }

    /**
     * Retorna el valor de $queryIngresos
     * @author devjul
     * @return Collection
     */
    private function getQueryLineas()
    {
        return $this->queryLineas;
    }

    /**
     * Asigna un valor a $queryLaboratorios
     * @param Collection $queryLaboratorios
     * @return void
     * @author devjul
     */
    private function setQueryLaboratorios($queryLaboratorios)
    {
        $this->queryLaboratorios = $queryLaboratorios;
    }

    /**
     * Retorna el valor de $queryLaboratorios
     * @author devjul
     * @return Collection
     */
    private function getQueryLaboratorios()
    {
        return $this->queryLaboratorios;
    }
}
