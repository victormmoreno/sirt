<?php

namespace App\Http\Traits\Encuesta;

use Illuminate\Support\Facades\Session;
use App\Models\Role;
use App\Models\Fase;
use App\Models\Movimiento;
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
     * consultar Informacion.
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
        $this->crearTrazabilidad($this->query);
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
     * crear el nuevo token.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @return string
     */
    public function createToken()
    {
        try{
            $email = $this->obtenerEmailParaEnviarEncuesta();

            $this->deleteExisting();

            $token = $this->createNewToken();

            EncuestaToken::create($this->getPayload($email, $token));

            return $token;
        }catch(\Exception $exception){
            return $exception->getMessage();
        }
    }

    /**
     * generate token aleatorio.
     *
     * @return string
     */
    public function createNewToken()
    {
        return Str::random(60);
    }

    /**
     * eliminar todos los token existentes del usuario.
     *
     */
    protected function deleteExisting()
    {
        return EncuestaToken::where('email', $this->obtenerEmailParaEnviarEncuesta())->delete();
    }

    /**
     * contruir los datos a insertar en la tabla
     *
     * @param  string  $email
     * @param  string  $token
     * @return array
     */
    protected function getPayload($email, $token)
    {
        return ['email' => $email, 'token' => bcrypt($token), 'created_at' => new Carbon];
    }

    /**
     * verificar el token con el token de la base de datos
     * @param  string  $token
     * @return bool
     */
    protected function checkToken($token)
    {
        $encriptToken = EncuestaToken::where('email', $this->obtenerEmailParaEnviarEncuesta())->first()->token;
        if (!Hash::check($token, $encriptToken)) {
            return false;
        }
        return true;
    }

    /**
     * Determine si existe un registro de token y si es válido.
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
     * Determine si el token ha caducado.
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
     * Eliminar un registro de token por usuario.
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @return void
     */
    public function deleteToken()
    {
        $this->deleteExisting();
    }

    /**
     * Eliminar tokens caducados
     * @return void
     */
    public function deleteExpired()
    {
        if($this->expires != '*'){
            $expiredAt = Carbon::now()->subSeconds($this->expires);
            EncuestaToken::where('created_at', '<', $expiredAt)->delete();
        }
    }

    /**
     * Crear trazabilidad al modelo cuando se envia la encuesta
     * @return void
     */
    protected function crearTrazabilidad($query){
        if(class_basename($query) == class_basename(Proyecto::class)){
            $mensaje = 'El experto solicitó realzar la encuesta de satisfacción';
            $trazabilidad = $query->movimientos()->attach(Movimiento::where('movimiento', Movimiento::IsEnviarEncuestaSatisfaccion())->first(), [
                'proyecto_id' => $query->id,
                'user_id' => auth()->user()->id,
                'fase_id' => Fase::where('nombre', Proyecto::IsEjecucion())->first()->id,
                'role_id' => Role::where('name', Session::get('login_role'))->first()->id,
                'comentarios' => $mensaje
                ]);
            return $trazabilidad;
        }
    }

}
