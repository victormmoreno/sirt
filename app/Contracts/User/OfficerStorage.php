<?php
namespace App\Contracts\User;
use Illuminate\Http\Request;
use App\User;

interface OfficerStorage
{
    public function buildStorageRecord(Request $request);

    public function buildResponse(array $data);

    public function propertiesArray(array $infoContract);

    public function save(Request $request, User $user);
}
