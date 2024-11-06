<?php
namespace App\Contracts\Idea;
use Illuminate\Http\Request;
use App\Models\Idea;

interface EnviarPostulacionIdea
{

    public function updateToPostulado(Idea $idea);

    // public function sendEmailToUser(Idea $idea);

    public function sendNotificationToArticuladores(Idea $idea);

    public function registerHistory(Idea $idea);
}
