<?php

namespace App\Strategies\User\OfficerStorage;

use Illuminate\Http\Request;
use App\Contracts\User\OfficerStorage;


class AdministratorOfficerStorage implements OfficerStorage
{
    public function buildStorageRecord(Request $request)
    {
        return [];
    }

    public function buildResponse(array $data)
    {

    }
}
