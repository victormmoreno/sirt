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
                                    <div class="col s12 m5 l3">
                                        <div class="mailbox-list">
                                            <ul>
                                                <li>
                                                    <a href="{{{route('perfil.index',auth()->user()->documento)}}}">
                                                        <h4 class="mail-title">
                                                            Información Personal
                                                        </h4>
                                                        <p align="justify" class="hide-on-small-and-down mail-text">
                                                           En este apartado podrás ver y actualizar tu información personal.
                                                        </p>
                                                        
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{{route('perfil.roles',auth()->user()->documento)}}}">
                                                        <h4 class="mail-title">
                                                            Roles
                                                        </h4>
                                                        <p align="justify" class="hide-on-small-and-down mail-text">
                                                            En este apartado podrás ver los roles asignados.
                                                        </p>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a  href="{{{route('perfil.permisos', auth()->user()->documento)}}}">
                                                        <h4 class="mail-title">
                                                            Permisos Adicionales
                                                        </h4>
                                                        <p align="justify" class="hide-on-small-and-down mail-text">
                                                            En este apartado podrás ver los permisos adicionales que se te han asignado.
                                                        </p>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a  href="">
                                                        <h4 class="mail-title">
                                                            Cambiar Contraseña
                                                        </h4>
                                                        <p align="justify" class="hide-on-small-and-down mail-text">
                                                            En este apartado podrás ver los permisos cambiar tu contraseña de ingreso a la plataforma {{config('app.name')}}
                                                        </p>
                                                    </a>
                                                </li>
                                                
                                                
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col s12 m7 l9">
                                        <div class="mailbox-options">
                                            <ul>
                                                <li>
                                                    <a href="">
                                                        Información Personal
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="">
                                                        Roles
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="">
                                                        Permisos Adicionales
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="">
                                                        Cambiar Contraseña
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="mailbox-view">
                                            <div class="mailbox-view-header">
                                                <div class="left">
                                                    <div class="left">
                                                        <img alt="" class="circle mailbox-profile-image z-depth-1" src="{{ asset('img/profile-image-masculine.png') }}">
                                                        </img>
                                                    </div>
                                                    <div class="left">
                                                        <span class="mailbox-title">
                                                            {{auth()->check() ? auth()->user()->nombres.' '.auth()->user()->apellidos : ''}} 
                                                        </span>

                                                        <span class="mailbox-author">
                                                            
                                                            {{$user->getRoleNames()->implode(', ')}}<br>
                                                            Miembro desde {{$user->created_at->isoFormat('LL')}} <br>
                                                            {{$user->fechanacimiento->age}} años
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="right mailbox-buttons">
                                                    <span class="mailbox-title">
                                                       <p class="center">Información Personal
                                                            <div class="right">
                                                            <a class="waves-effect waves-light btn m-t-xs dropdown-button "  href='#' data-activates='actifiad'><i class="material-icons right" >cloud</i>Más Información</a>
                                                            <!-- Dropdown Structure -->
                                                            <ul id='actifiad' class='dropdown-content'>
                                                                <li><a href="{{route('perfil.edit',$user->documento)}}">Cambiar Información</a></li>
                                                                <li><a href="#!">two</a></li>
                                                                <li class="divider"></li>
                                                                <li><a href="#!">three</a></li>
                                                            </ul> 
                                                        </div>
                                                       </p>
                                                    </span>
                                                </div>

                                                <div class="right mailbox-buttons">
                                                    {{-- <a class="waves-effect waves-red btn-flat m-t-xs">
                                                        Delete
                                                    </a> --}} 
                                                </div>
                                            </div>
                                            <div class="right">
                                                <small>{{{$user->genero == 1 ? 'Masculino' : 'Femenino'}}}  </small>
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
                                                                        {{$user->telefono}} 
                                                                    </p>
                                                                </div>
                                                                <div class="right">
                                                                    <span class="title">
                                                                       Celular
                                                                    </span>
                                                                    <p>
                                                                        {{$user->celular}} 
                                                                    </p>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="divider mailbox-divider">
                                                </div>
                                                
                                                <div class="right">
                                                    <a class="waves-effect waves-teal darken-2 btn-flat m-t-xs">
                                                        Cambiar Información Personal
                                                    </a>
                                                    <a class="waves-effect waves-red btn-flat m-t-xs">
                                                        Delete
                                                    </a>
                                                    {{-- <ul class="attachment-list">
                                                        <li>
                                                            <a class="waves-effect waves-red btn-flat m-t-xs">
                                                                Delete
                                                            </a>
                                                        </li> --}}
                                                        {{-- <li>
                                                            <a class="attachment z-depth-1" href="#">
                                                                <div class="attachment-content">
                                                                    <img alt="" src="assets/images/card-image2.jpg">
                                                                    </img>
                                                                </div>
                                                                <div class="attachment-info">
                                                                    <p>
                                                                        Attachment2.jpg
                                                                    </p>
                                                                    <span>
                                                                        548 KB
                                                                    </span>
                                                                </div>
                                                            </a>
                                                        </li> --}}
                                                    {{-- </ul> --}}
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
