<?php
namespace App\Contracts\Idea;
use Illuminate\Http\Request;

interface CompleteIdeaInformation
{
    public function buildStorageRecord(Request $request);

    public function buildSedeIdea(Request $request);

    public function buildCodigoIdea(string $nodo);

    public function buildResponse(array $data);

}
