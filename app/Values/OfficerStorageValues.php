<?php

namespace App\Values;

use App\Strategies\User\OfficerStorage\ActivatorOfficerStorage;
use App\Strategies\User\OfficerStorage\AdministratorOfficerStorage;
use App\Strategies\User\OfficerStorage\DynamizerOfficerStorage;
use App\Strategies\User\OfficerStorage\ExpertOfficerStorage;

final  class OfficerStorageValues
{
    const OFFICER = [
        'administrador' => ActivatorOfficerStorage::class,
        'activador' => AdministratorOfficerStorage::class,
        'dinamizador' => DynamizerOfficerStorage::class,
        'experto' => ExpertOfficerStorage::class,
    ];
}
