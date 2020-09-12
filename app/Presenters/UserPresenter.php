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

    public function userEditLink()
    {
        return "<a href=\"" . route('usuario.usuarios.edit', $this->user->documento) . "\">
            Cambiar Información
        </a>";
    }

    public function userGenero()
    {
        return $this->user->genero == User::IsMasculino() ? 'Masculino' : 'Femenino';
    }

    public function userTipoDocuento()
    {
        return $this->user->has('tipodocumento') ? $this->user->tipodocumento->nombre : 'No se encontraron resultados';
    }

    public function userLugarExpedicionDocumento()
    {
        return $this->user->has('ciudadexpedicion') ? "{$this->user->ciudadexpedicion->nombre} - {$this->user->ciudadexpedicion->departamento->nombre}" : 'No se encontraron resultados';
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
        return $this->user->has('etnia') && $this->user->etnia->nombre != null ? $this->user->etnia->nombre : 'No Registra';
    }

    public function userAcceso()
    {
        return $this->user->estado == User::IsActive() && $this->user->deleted_at == null ? 'Habilitado' : "Inhabilitado desde: " .  optional($this->user->deleted_at)->isoFormat('DD/MM/YYYY');
    }

    public function userDireccion()
    {
        return  $this->user->direccion && $this->user->direccion != null ? $this->user->direccion : 'No Registra';
    }

    public function userLugarResidencia()
    {
        return $this->user->has('ciudad') ? "{$this->user->ciudad->nombre} ({$this->user->ciudad->departamento->nombre})" : 'No Registra';
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
        return  $this->user->has('gradoescolaridad') ? $this->user->gradoescolaridad->nombre : 'No Registra';
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

    public function userDinamizadorNombreNodo()
    {
        return $this->user->has('dinamizador.nodo.entidad') ? "Tecnoparque Nodo {$this->user->dinamizador->nodo->entidad->nombre}" : $this->message('No Registra');
    }

    public function userDinamizadorDireccionNodo()
    {
        return $this->user->has('dinamizador.nodo') ? $this->user->dinamizador->nodo->direccion : $this->message('No Registra');
    }

    public function userGestorNombreNodo()
    {
        return $this->user->has('gestor.nodo.entidad') ? "Tecnoparque Nodo {$this->user->gestor->nodo->entidad->nombre}" : $this->message('No Registra');
    }

    public function userGestorNombreLinea()
    {
        return $this->user->has('gestor.lineatecnologica') ? $this->user->gestor->lineatecnologica->nombre : $this->message('No Registra');
    }

    public function userGestorHonorarios()
    {
        return $this->user->has('gestor') ? "$ " . number_format($this->user->gestor->honorarios, 0) : $this->message('No Registra');
    }

    public function userInfocenterNombreNodo()
    {
        return $this->user->has('infocenter.nodo.entidad') ? "Tecnoparque Nodo {$this->user->infocenter->nodo->entidad->nombre}" : $this->message('No Registra');
    }

    public function userInfocenterExtension()
    {
        return $this->user->has('infocenter') ? $this->user->infocenter->extension : $this->message('No Registra');
    }

    public function userProfileUserImage()
    {
        if ($this->user->genero == User::IsMasculino()) {
            return "<img alt=\"{$this->user->nombres}\" class=\"circle mailbox-profile-image z-depth-1\" src=\"" . asset('img/profile-image-masculine.png') . "\"></img>";
        } elseif ($this->user->genero == User::IsFemenino()) {
            return "<img alt=\"{$this->user->nombres}\" class=\"circle mailbox-profile-image z-depth-1\" src=\"" . asset('img/profile-image-female.png') . "\"></img>";
        } else {
            return "<img alt=\"{$this->user->nombres}\" class=\"circle mailbox-profile-image z-depth-1\" src=\"" . asset('img/profile-image-default.png') . "\"></img>";
        }
    }

    public function userNombreTipoTalento()
    {
        if ($this->user->has('talento.tipotalento')) {
            return $this->user->talento->tipotalento->nombre;
        }
        return $this->message('Información no disponible');
    }

    public function userTipoTalento()
    {
        if ($this->user->has('talento.tipotalento')) {
            if (
                $this->user->talento->tipotalento->nombre == TipoTalento::IS_APRENDIZ_SENA_CON_APOYO ||
                $this->user->talento->tipotalento->nombre == TipoTalento::IS_APRENDIZ_SENA_SIN_APOYO
            ) {
                return $this->regionalTalento() . ' - ' . $this->centroFormacionTalento() . ' - ' . $this->programaFormacionTalento();
            } elseif ($this->user->talento->tipotalento->nombre == TipoTalento::IS_EGRESADO_SENA) {
                return $this->regionalTalento() . ' - ' . $this->centroFormacionTalento() . ' - ' . $this->programaFormacionTalento() . ' - ' . $this->tipoFormacionTalento();
            } elseif ($this->user->talento->tipotalento->nombre == TipoTalento::IS_FUNCIONARIO_SENA) {
                return $this->regionalTalento() . ' - ' . $this->centroFormacionTalento() . ' - ' . $this->dependencia();
            } elseif ($this->user->talento->tipotalento->nombre == TipoTalento::IS_INSTRUCTOR_SENA) {
                return $this->regionalTalento() . ' - ' . $this->centroFormacionTalento();
            } elseif ($this->user->talento->tipotalento->nombre == TipoTalento::IS_ESTUDIANTE_UNIVERSITARIO) {
                return $this->tipoEstudio() . ' - ' . $this->universidad() . ' - ' . $this->carreraUniversitaria();
            } elseif ($this->user->talento->tipotalento->nombre == TipoTalento::IS_FUNCIONARIO_EMPRESA) {
                return $this->empresaTalento();
            }
            return $this->message('No Registra');
        }
        return $this->message('No Registra');
    }

    public function regionalTalento()
    {
        if ($this->user->has('talento.entidad.centro.regional') && isset($this->user->talento->entidad->centro->regional->nombre)) {
            return $this->user->talento->entidad->centro->regional->nombre;
        }
        return $this->message('No Registra');
    }

    public function centroFormacionTalento()
    {
        if ($this->user->has('talento.entidad') && isset($this->user->talento->entidad)) {
            return $this->user->talento->entidad->nombre;
        }

        return $this->message('No Registra');
    }

    public function programaFormacionTalento()
    {
        if ($this->user->has('talento') && isset($this->user->talento->programa_formacion) && $this->user->talento->programa_formacion != null) {
            return $this->user->talento->programa_formacion;
        }
        return $this->message('No Registra');
    }

    public function tipoFormacionTalento()
    {
        if ($this->user->has('talento.tipoformacion')) {
            return $this->user->talento->tipoformacion->nombre;
        }
        return $this->message('No Registra');
    }

    public function dependencia()
    {
        if ($this->user->has('talento') && isset($this->user->talento->dependencia) && $this->user->talento->dependencia != null) {
            return $this->user->talento->dependencia;
        }
        return $this->message('No Registra');
    }

    public function tipoEstudio()
    {
        if ($this->user->has('talento.tipoestudio')) {
            return $this->user->talento->tipoestudio->nombre;
        }
        return $this->message('No Registra');
    }

    public function universidad()
    {
        if ($this->user->has('talento') && isset($this->user->talento->universidad) && $this->user->talento->universidad != null) {
            return $this->user->talento->universidad;
        }
        return $this->message('No Registra');
    }

    public function carreraUniversitaria()
    {
        if ($this->user->has('talento') && isset($this->user->talento->carrera_univeritaria) && $this->user->talento->carrera_univeritaria != null) {
            return $this->user->talento->carrera_univeritaria;
        }
        return $this->message('No Registra');
    }

    public function empresaTalento()
    {
        if ($this->user->has('talento') && isset($this->user->talento->empresa) && $this->user->talento->empresa != null) {
            return $this->user->talento->empresa;
        }
        return $this->message('No Registra');
    }
}
