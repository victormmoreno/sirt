<?php
namespace App\Contracts\User;
use Illuminate\Http\Request;

interface TalentStorage
{
    public function buildStorageRecord(Request $request);
}
