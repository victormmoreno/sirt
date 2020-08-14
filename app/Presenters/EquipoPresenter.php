<?php

namespace App\Presenters;

use App\Models\Equipo;

class EquipoPresenter extends Presenter
{
    protected $equipo;

    public function __construct(Equipo $equipo)
    {
        $this->equipo = $equipo;
    }
    public function equipoNombre()
    {
        return $this->equipo->nombre;
    }

    public function equipoNodo()
    {
        return $this->equipo->has('nodo.entidad') ? $this->equipo->nodo->entidad->nombre : 'No Registra';
    }

    public function equipoLinea()
    {
        return  $this->equipo->has('lineatecnologica') ? "{$this->equipo->lineatecnologica->abreviatura} - {$this->equipo->lineatecnologica->nombre}" : 'No Registra';
    }

    public function equipoReferencia()
    {
        return $this->equipo->referencia;
    }

    public function equipoMarca()
    {
        return $this->equipo->marca;
    }

    public function equipoCostoAdquisicion()
    {
        return '$ ' . number_format(round($this->equipo->costo_adquisicion), 0);
    }

    public function equipoVidaUtil()
    {
        return $this->equipo->vida_util;
    }

    public function equipoAnioCompra()
    {
        return $this->equipo->anio_compra;
    }

    public function equipoHorasUsoAnio()
    {
        return $this->equipo->horas_uso_anio;
    }

    public function equipoAnioDepreciacion()
    {
        return $this->equipo->vida_util + $this->equipo->anio_compra;
    }

    public function equipoDepreciacionPorAnio()
    {
        if ($this->equipo->vida_util > 0 && $this->equipo->costo_adquisicion > 0) {
            return '$' .  number_format(round($this->equipo->costo_adquisicion) / $this->equipo->vida_util, 0);
        }
        return '$' .  number_format(round($this->equipo->costo_adquisicion), 0);
    }

    public function equipoState()
    {
        return $this->equipo->trashed() ? "Inhabilitado desde: " .  optional($this->equipo->deleted_at)->isoFormat('DD/MM/YYYY') : 'Habilitado';
    }
}
