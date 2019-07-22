@extends('layouts.app')

@section('meta-title', 'Perfil |' . $user->nombres. ' '. $user->apellidos)

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s10 m10 l10">
                        <h5 class="left-align">
                            <i class="material-icons left">
                                supervised_user_circle
                            </i>
                            Usuarios | Perfil
                        </h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m12 l12">
                        <div class="card mailbox-content">
                            <div class="card-content">
                                <div class="row no-m-t no-m-b">
                                    @include('users.profile.nav.nav-profile')
                                    <div class="col s12 m7 l9">
                                         @include('users.profile.nav.navbar')
                                        <div class="mailbox-view">
                                            <div class="mailbox-view-header">
                                                @include('users.profile.nav.header')
                                                <div class="right mailbox-buttons">
                                                    <span class="mailbox-title">
                                                       <p class="center">Información Personal
                                                            <div class="right">
                                                            <a class="waves-effect waves-light btn m-t-xs dropdown-button "  href='#' data-activates='actifiad'><i class="material-icons right" >cloud</i>Más Información</a>
                                                            <!-- Dropdown Structure -->
                                                            <ul id='actifiad' class='dropdown-content'>
                                                                <li><a href="{{route('perfil.edit')}}">Cambiar Información</a></li>
                                                                {{-- <li><a href="#!">Mis Notificaciónes</a></li> --}}
                                                                <li class="divider"></li>
                                                                <li><a href="#!">Obtener certificado de registro en el sistema</a></li>
                                                            </ul> 
                                                        </div>
                                                       </p>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="right">
                                                <small>{{{$user->genero == App\User::IsMasculino() ? 'Masculino' : 'Femenino'}}}  </small>
                                            </div>
                                            <div class="divider mailbox-divider">
                                            </div>
                                            <div class="mailbox-text">
                                                <div class="row">
                                                    <div class="col s12 m6 l6">
                                                        <ul class="collection">
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    credit_card
                                                                </i>
                                                                <span class="title">
                                                                    Tipo Documento
                                                                </span>
                                                                <p>
                                                                    {{$user->tipodocumento->nombre ? $user->tipodocumento->nombre : 'No se encontraron resultados' }}
                                                                    
                                                                </p>
                                                                
                                                                
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    folder
                                                                </i>
                                                                <span class="title">
                                                                    Fecha de Nacimiento
                                                                </span>
                                                                <p>
                                                                    {{$user->fechanacimiento->isoFormat('LL')}} 
                                                                </p>
                                                                
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    insert_chart
                                                                </i>
                                                                <div class="left">
                                                                   <span class="title">
                                                                        Eps
                                                                    </span>
                                                                    <p>
                                                                       {{$user->eps->nombre}}   
                                                                    </p> 
                                                                </div>
                                                                @if($user->eps->nombre == App\Models\Eps::OTRA_EPS)
                                                                <div class="right">
                                                                   <span class="title">
                                                                        Otra Eps
                                                                    </span>
                                                                    <p>
                                                                       {{$user->otra_eps}}   
                                                                    </p> 
                                                                </div>
                                                                @endif
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    play_arrow
                                                                </i>
                                                                <div class="left">
                                                                    <span class="title">
                                                                       Dirección
                                                                    </span>
                                                                    <p>
                                                                        {{$user->direccion}} 
                                                                    </p>
                                                                </div>
                                                                <div class="right">
                                                                    <span class="title">
                                                                       Barrio
                                                                    </span>
                                                                    <p>
                                                                        {{$user->barrio}} 
                                                                    </p>
                                                                </div>
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    play_arrow
                                                                </i>
                                                                <span class="title">
                                                                   Correo Electrónico
                                                                </span>
                                                                <p>
                                                                    {{$user->email}} 
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col s12 m6 l6">
                                                        <ul class="collection">
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    assignment_ind
                                                                </i>
                                                                <span class="title">
                                                                    Documento
                                                                </span>
                                                                <p>
                                                                    {{$user->documento}} 
                                                                </p>
                                                                
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    folder
                                                                </i>
                                                                <span class="title">
                                                                    Grupo Sanguineo
                                                                </span>
                                                                <p>
                                                                   {{$user->grupoSanguineo->nombre}}
                                                                   
                                                                </p>
                                                                
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    insert_chart
                                                                </i>
                                                                <span class="title">
                                                                    Estrato Social
                                                                </span>
                                                                <p>
                                                                    {{$user->estrato}}
                                                                    
                                                                </p>
                                                                
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    play_arrow
                                                                </i>
                                                                <span class="title">
                                                                    Lugar de Residencia
                                                                </span>
                                                                <p>
                                                                    {{$user->ciudad->nombre}} - {{$user->ciudad->departamento->nombre}}   
                                                                </p>
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                
                                                                <div class="center">
                                                                    <span class="title">
                                                                       Datos contacto
                                                                    </span>
                                                                </div>
                                                                <div class="left">
                                                                    <i class="material-icons circle teal darken-2">
                                                                    play_arrow
                                                                </i>
                                                                    <p>
                                                                        Telefono <br>
                                                                        {{$user->telefono ? $user->telefono : 'No registra'}} 
                                                                    </p>
                                                                </div>
                                                                <div class="right">
                                                                    <span class="title">
                                                                       Celular
                                                                    </span>
                                                                    <p>
                                                                        {{$user->celular ? $user->celular : 'No registra'}} 
                                                                    </p>
                                                                </div>
                                                            </li> 
                                                        </ul>
                                                    </div>
                                                </div>

                                                @if(isset($user->dinamizador) && collect($user->getRoleNames())->contains(App\User::IsDinamizador()))
                                                <div class="right">
                                                    <small>Información Dinamizador</small>
                                                </div>
                                                <div class="divider mailbox-divider"></div>
                                                <div class="row">
                                                    <div class="col s12 m6 l6 offset-l3 m-3">
                                                        <ul class="collection">
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    play_arrow
                                                                </i>
                                                                <span class="title">
                                                                    Nodo del Dinamizador
                                                                </span>
                                                                <p>
                                                                    Tecnoparque Nodo {{$user->dinamizador->nodo->entidad->nombre}}<br>
                                                                    <small><b>Dirección: </b>{{$user->dinamizador->nodo->direccion}}</small> 
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                @endif

                                                @if(isset($user->gestor) && collect($user->getRoleNames())->contains(App\User::IsGestor()))
                                                <div class="right">
                                                    <small>Información {{App\User::IsGestor()}}</small>
                                                </div>
                                                <div class="divider mailbox-divider"></div>
                                                <div class="row">
                                                    <div class="col s12 m6 l6 ">
                                                        <ul class="collection">
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    play_arrow
                                                                </i>
                                                                <span class="title">
                                                                    Nodo del {{App\User::IsGestor()}}
                                                                </span>
                                                                <p>
                                                                    Tecnoparque Nodo {{$user->gestor->nodo->entidad->nombre}}<br>
                                                                    <small><b>Dirección: </b>{{$user->gestor->nodo->direccion}}</small> 
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col s12 m6 l6 ">
                                                        <ul class="collection">
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    play_arrow
                                                                </i>
                                                                <span class="title">
                                                                    Linea {{App\User::IsGestor()}}
                                                                </span>
                                                                <p>
                                                                     {{$user->gestor}}<br>
                                                                    <small><b>Dirección: </b>{{$user->gestor->nodo->direccion}}</small> 
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                {{var_dump($user->gestor->lineatecnologica)}}
                                                @endif
                                         
                                                <div class="divider mailbox-divider">
                                                </div>
                                                
                                                <div class="right">
                                                    <a href="{{route('perfil.edit',$user->documento)}}" class="waves-effect waves-teal darken-2 btn-flat m-t-xs">
                                                        Cambiar Información Personal
                                                    </a>
                                                    <a class="waves-effect waves-red btn-flat m-t-xs">
                                                        Eliminar Usuario
                                                    </a>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
