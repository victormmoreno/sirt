<?php

namespace App\Http\Traits\Idea;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\{IdeaFormRequest, EmpresaFormRequest};
use App\Http\Traits\Idea\CompleteIdeaInformationTrait;
use App\Models\{Idea, EstadoIdea};
use App\Events\Idea\IdeaHasReceived;
use App\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Idea\{IdeaReceived};
use App\Models\Movimiento;

// use App\Http\Requests\UsersRequests\CompletiesTalentInformationRequest;
// use App\Http\Controllers\User\RolesPermissions;

trait EnviarPostulacionIdeaTrait
{

    public function updateToPostulado(Idea $idea) {
        $idea->update(['estadoidea_id' => EstadoIdea::where('nombre', EstadoIdea::IsPostulado())->first()->id]);
    }

    // public function sendEmailToUser(Idea $idea) {
    //     event(new IdeaHasReceived($idea));
    // }

    public function sendNotificationToArticuladores(Idea $idea) {
        $users = User::ConsultarFuncionarios($idea->nodo_id, User::IsArticulador())->get();
        // Envia un correo a los articuladores del nodo
        if (!$users->isEmpty()) {
            Notification::send($users, new IdeaReceived($idea));
        }
    }

    public function registerHistory(Idea $idea) {
        $idea->registrarHistorialIdea(Movimiento::IsPostular(), session()->get('login_role'), null, 'al nodo ' . $idea->nodo->entidad->nombre);
    }

}