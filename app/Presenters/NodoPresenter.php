<?php

namespace App\Presenters;

use App\Models\Nodo;

class NodoPresenter extends Presenter
{
    protected $node;

    public function __construct(Nodo $node)
    {
        $this->node = $node;
    }

    public function NodeName()
    {
        return isset($this->node->entidad) ? $this->node->entidad->nombre : 'No registra';
    }
}
