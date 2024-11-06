<?php
namespace App\Contracts\Idea;

use Illuminate\Http\Request;
use App\Models\Idea;

interface IdeaStorage
{
    public function store(Request $request);

    public function sendNotificacionPostulado(Request $request, Idea $idea);
}
