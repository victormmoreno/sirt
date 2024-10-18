<?php
namespace App\Contracts\Idea;
use Illuminate\Http\Request;

interface IdeaStorage
{
    public function store(Request $request);

    // public function sendNotificacionPostulado(Request $request);
}
