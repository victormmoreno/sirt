<?php

namespace App\Presenters;

use App\User;
use App\Models\{Eps, TipoTalento};

class UserPresenter extends Presenter
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function userFullName()
    {
        return "{$this->user->nombres} {$this->user->apellidos}";
    }

    public function userGenero()
    {
        return $this->user->genero == User::IsNoBinario() ? 'No binario' :
        ($this->user->genero == User::IsMasculino() ? 'Masculino' :'Femenino');
    }

    public function userMujerCabezaFamilia(){
        return $this->user->mujerCabezaFamilia == 1 ? 'Si' : 'No';
    }

    public function userDesplazadoPorViolencia(){
        return $this->user->desplazadoPorViolencia == 1 ? 'Si' : 'No';
    }

    public function userTipoDocuento()
    {
        return $this->user->has('tipodocumento') ? $this->user->tipodocumento->nombre : 'No se encontraron resultados';
    }

    public function userLugarExpedicionDocumento()
    {
        return $this->user->ciudadexpedicion != null ? "{$this->user->ciudadexpedicion->nombre} - {$this->user->ciudadexpedicion->departamento->nombre}" : 'No se encontraron resultados';
    }

    public function userFechaNacimiento()
    {
        return isset($this->user->fechanacimiento) ? optional($this->user->fechanacimiento)->isoFormat('LL') : 'No Registra';
    }

    public function userEps()
    {
        return $this->user->has('eps') ? $this->user->eps->nombre : 'No Registra';
    }

    public function userOtraEps()
    {
        return $this->user->has('eps') && $this->user->eps->nombre == Eps::OTRA_EPS ? $this->user->otra_eps : 'No Aplica';
    }

    public function userGradoDiscapacidad()
    {
        return  $this->user->grado_discapacidad == 1 ? 'Si' : 'No';
    }

    public function userDescripcionGradoDiscapacidad()
    {
        return  $this->user->grado_discapacidad == 1 && $this->user->descripcion_grado_discapacidad !== null ? $this->user->descripcion_grado_discapacidad : 'No Registra';
    }

    public function userEmail()
    {
        return  $this->user->email ?: 'No Registra';
    }

    public function userDocumento()
    {
        return  $this->user->documento ?: 'No Registra';
    }

    public function userGrupoSanguineo()
    {
        return $this->user->has('grupoSanguineo') ? $this->user->grupoSanguineo->nombre : 'No Registra';
    }

    public function userEstrato()
    {
        return  $this->user->estrato ?: 'No Registra';
    }

    public function userEtnia()
    {
        if($this->user->has('etnia') && isset($this->user->etnia)){
            return $this->user->etnia->nombre;
        }
        return 'No Registra';
    }

    public function userAcceso()
    {
        return $this->user->estado == User::IsActive() && $this->user->deleted_at == null ? '<span class="badge bg-success  white-text">Habilitado</span>' : '<span class="badge bg-danger  white-text">Inhabilitado desde:'.  optional($this->user->deleted_at)->isoFormat('DD/MM/YYYY').'</span>';
    }

    public function userDireccion()
    {
        return  $this->user->direccion && $this->user->direccion != null ? $this->user->direccion : 'No Registra';
    }

    public function userLugarResidencia()
    {
        return $this->user->ciudad != null ? "{$this->user->ciudad->nombre} - {$this->user->ciudad->departamento->nombre}" : 'No Registra';
    }

    public function userBarrio()
    {
        return  $this->user->barrio && $this->user->barrio != null ? $this->user->barrio  : 'No Registra';
    }

    public function userTelefono()
    {
        return  $this->user->telefono && $this->user->telefono != null ? $this->user->telefono : 'No Registra';
    }

    public function userCelular()
    {
        return  $this->user->celular && $this->user->celular != null ? $this->user->celular : 'No Registra';
    }

    public function userOcupacionesNames()
    {
        return  $this->user->getOcupacionesNames()->implode(', ') ?: 'No registra';
    }

    public function userInstitucion()
    {
        return  $this->user->institucion && $this->user->institucion != null ? $this->user->institucion  : 'No Registra';
    }

    public function userTituloObtenido()
    {
        return  $this->user->titulo_obtenido && $this->user->titulo_obtenido != null ? $this->user->titulo_obtenido : 'No Registra';
    }

    public function userGradoEscolaridad()
    {
        if($this->user->has('gradoescolaridad') && isset($this->user->gradoescolaridad)){
            return $this->user->gradoescolaridad->nombre;
        }
        return  'No Registra';
    }

    public function userFechaTerminacion()
    {
        return  $this->user->fecha_terminacion != null ? optional($this->user->fecha_terminacion)->isoFormat('LL')  : 'No Registra';
    }

    public function userRolesNames()
    {
        return $this->user->getRoleNames()->implode(', ');
    }

    public function userCreatedAtFormat()
    {
        return isset($this->user->created_at) ? optional($this->user->created_at)->isoFormat('LL') : '';
    }

    public function userYearOld()
    {
        return isset($this->user->fechanacimiento) ? optional($this->user->fechanacimiento)->age . ' años' : '';
    }

    public function userProfileUserImage()
    {
        if ($this->user->genero == User::IsMasculino()) {
            return "<img alt=\"{$this->user->nombres}\" class=\"circle mailbox-profile-image z-depth-1\" src=\"" . asset('img/profile-image-masculine.png') . "\"></img>";
        } elseif ($this->user->genero == User::IsFemenino()) {
            return "<img alt=\"{$this->user->nombres}\" class=\"circle mailbox-profile-image z-depth-1\" src=\"" . asset('img/profile-image-female.png') . "\"></img>";
        } else {
            return "<img alt=\"{$this->user->nombres}\" class=\"circle mailbox-profile-image z-depth-1\" src=\"" . asset('img/profile-img-default.png') . "\"></img>";
        }
    }

    public function userNombreTipoTalento()
    {
        if (isset($this->user->talento->tipotalento) && $this->user->has('talento.tipotalento')) {
            return $this->user->talento->tipotalento->nombre;
        }
        return $this->message('Información no disponible');
    }

    public function userChangeAccess(): bool
    {
        return $this->user->hasAnyRole([
            User::IsDinamizador(),
            User::IsActivador(),
            User::IsAdministrador(),
            User::IsInfocenter(),
            User::IsArticulador(),
            User::IsIngreso(),
            User::IsDesarrollador(),
            User::IsExperto(),
            User::IsApoyoTecnico(),
            User::IsUsuario()
        ]) ? true : false;
    }

    public function userNode()
    {
        if($this->user->has('dinamizador') && isset($this->user->dinamizador->nodo)){
            return;
        }

        if($this->user->has('experto') && isset($this->user->experto->nodo)){
            return;
        }

        if($this->user->has('articulador') && isset($this->user->articulador->nodo)){
            return;
        }

        if($this->user->has('infocenter') && isset($this->user->infocenter->nodo)){
            return;
        }

        if($this->user->has('apoyotecnico') && isset($this->user->apoyotecnico->nodo)){
            return;
        }

        if($this->user->has('ingreso') && isset($this->user->ingreso->nodo)){
            return;
        }

    }
}
