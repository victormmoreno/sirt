<?php

namespace App\Http\Traits\Encuesta;


use App\Models\Proyecto;
use App\Models\Articulation;
use App\Models\EncuestaToken;
use App\Notifications\Encuesta\EnviarEncuesta as EncuestaNotification;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

trait HasEnvioEncuesta {

    public $user = null;
    public $query = null;
    // public $expires = 60 * 60; //1hora
    public $expires = '*'; //1hora

    /**
     * consultarInformacion.
     *
     * @param  string  $token
     * @return void
     */
    public function interlocutor($query)
    {
        $this->query = $query;
        if(class_basename($query) == class_basename(Proyecto::class)){
            $this->user = $query->getLeadTalent();
        }else if(class_basename($query) == class_basename(Articulation::class)){
            $this->user = $query->articulationstage->interlocutor;
        }else {
            $this->user = null;
        }
        return $this->user;
    }

    /**
     * enviar la notificacion con la encuesta.
     *
     * @param  string  $token
     * @return void
     */
    public function enviarNotificacionEncuesta($token)
    {
        $this->user->notify(new EncuestaNotification($this->query, $token));
        return EncuestaToken::ENVIAR_ENCUESTA;
    }
    /**
     * enviar la notificacion con la encuesta.
     *
     * @param  string  $token
     * @return void
     */
    public function obtenerEmailParaEnviarEncuesta()
    {
        return $this->user->email;
    }

    /**
     * Create a new token record.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @return string
     */
    public function createToken()
    {
        $email = $this->obtenerEmailParaEnviarEncuesta();

        $this->deleteExisting();

        $token = $this->createNewToken();

        EncuestaToken::create($this->getPayload($email, $token));

        return $token;
    }

    /**
     * Create a new token for the user.
     *
     * @return string
     */
    public function createNewToken()
    {
        return Str::random(60);
    }

    /**
     * Delete all existing reset tokens from the database.
     *
     */
    protected function deleteExisting()
    {
        return EncuestaToken::where('email', $this->obtenerEmailParaEnviarEncuesta())->delete();
    }

    /**
     * Build the record payload for the table.
     *
     * @param  string  $email
     * @param  string  $token
     * @return array
     */
    protected function getPayload($email, $token)
    {
        return ['email' => $email, 'token' => bcrypt($token), 'created_at' => new Carbon];
    }

    protected function checkToken($token)
    {
        $encriptToken = EncuestaToken::where('email', $this->obtenerEmailParaEnviarEncuesta())->first()->token;
        if (!Hash::check($token, $encriptToken)) {
            return false;
        }
        return true;
    }

    /**
     * Determine if a token record exists and is valid.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $token
     * @return bool
     */
    public function exists($token)
    {
        $record = EncuestaToken::where(
            'email', $this->obtenerEmailParaEnviarEncuesta()
        )->first();

        return $record &&
                ! $this->tokenExpired($record->created_at) &&
                $this->checkToken($token);
    }

    /**
     * Determine if the token has expired.
     *
     * @param  string  $createdAt
     * @return bool
     */
    protected function tokenExpired($createdAt)
    {
        if($this->expires == '*'){
            return false;
        }
        return Carbon::parse($createdAt)->addSeconds($this->expires)->isPast();

    }

    /**
     * Delete a token record by user.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @return void
     */
    public function delete()
    {
        $this->deleteExisting();
    }

    /**
     * Delete expired tokens.
     *
     * @return void
     */
    public function deleteExpired()
    {
        if($this->expires != '*'){
            $expiredAt = Carbon::now()->subSeconds($this->expires);
            EncuestaToken::where('created_at', '<', $expiredAt)->delete();
        }
    }

}
