<?php

namespace App\Repositories\Decorator\UserDecorador;

use App\Repositories\Interfaces\UserInterface\InfocenterInterface;
use Illuminate\Support\Facades\Cache;

class InfocenterCache implements InfocenterInterface
{

    protected $infocenterRepository;

    public function __construct(InfocenterRepository $infocenterRepository)
    {
        $this->infocenterRepository = $infocenterRepository;
    }

    public function getAllInfocentersForNodo($nodo)
    {
        return Cache::rememberForever('infocenterfornodo.all', function () use ($nodo) {
            return $this->infocenterRepository->getAllInfocentersForNodo($nodo);
        });
    }

}
