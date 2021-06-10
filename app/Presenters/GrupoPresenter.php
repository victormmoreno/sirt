<?php

namespace App\Presenters;

use App\Models\{GrupoInvestigacion};

class GrupoPresenter extends Presenter
{
    protected $grupo;

    public function __construct(GrupoInvestigacion $grupo)
    {
        $this->grupo = $grupo;
    }

    public function grupoTipo()
    {
        if ($this->grupo->tipogrupo == GrupoInvestigacion::IsInterno()) {
            return 'SENA';
        } else {
            return 'Externo';
        }
    }
}