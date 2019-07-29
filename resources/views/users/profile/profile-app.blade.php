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
                                                            
        
                                                            <a class="waves-effect waves-light btn m-t-xs dropdown-button "  href='#' data-activates='actifiad'><i class="material-icons right" >cloud</i>Cambiar Información</a>
                                                            <!-- Dropdown Structure -->
                                                            <ul id='actifiad' class='dropdown-content'>
                                                                <li><a href="#!">one</a></li>
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
                                                                <span class="secondary-content">
                                                                    <i class="material-icons">
                                                                        grade
                                                                    </i>
                                                                </span>
                                                                
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
                                                                <span class="secondary-content">
                                                                    <i class="material-icons">
                                                                        grade
                                                                    </i>
                                                                </span>
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    insert_chart
                                                                </i>
                                                                <span class="title">
                                                                    Eps
                                                                </span>
                                                                <p>
                                                                   {{$user->eps->nombre}}
                                                                    
                                                                </p>
                                                                <span class="secondary-content">
                                                                    <i class="material-icons">
                                                                        grade
                                                                    </i>
                                                                </span>
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle teal darken-2">
                                                                    play_arrow
                                                                </i>
                                                                <span class="title">
                                                                   Barrio de Residencia
                                                                </span>
                                                                <p>
                                                                    {{$user->barrio}} 
                                                                    
                                                                </p>
                                                                <span class="secondary-content">
                                                                    <i class="material-icons">
                                                                        grade
                                                                    </i>
                                                                </span>
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
                                                                <span class="secondary-content">
                                                                    <i class="material-icons">
                                                                        grade
                                                                    </i>
                                                                </span>
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
                                                                <span class="secondary-content">
                                                                    <i class="material-icons">
                                                                        grade
                                                                    </i>
                                                                </span>
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle green">
                                                                    insert_chart
                                                                </i>
                                                                <span class="title">
                                                                    Estrato Social
                                                                </span>
                                                                <p>
                                                                    {{$user->estrato}}
                                                                    
                                                                </p>
                                                                <span class="secondary-content">
                                                                    <i class="material-icons">
                                                                        grade
                                                                    </i>
                                                                </span>
                                                            </li>
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle red">
                                                                    play_arrow
                                                                </i>
                                                                <span class="title">
                                                                    Lugar de Residencia
                                                                </span>
                                                                <p>
                                                                    {{$user->ciudad->nombre}} 
                                                                    
                                                                      
                                                                </p>
                                                                <a class="secondary-content" href="#!">
                                                                    <i class="material-icons">
                                                                        grade
                                                                    </i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="divider mailbox-divider">
                                                </div>
                                                <span class="attachment-info">
                                                    <i class="material-icons">
                                                        attachment
                                                    </i>
                                                    2 Attachments -
                                                    <a href="">
                                                        View all
                                                    </a>
                                                    |
                                                    <a href="">
                                                        Download all
                                                    </a>
                                                </span>
                                                <ul class="attachment-list">
                                                    <li>
                                                        <a class="attachment z-depth-1" href="#">
                                                            <div class="attachment-content">
                                                                <img alt="" src="assets/images/card-image3.jpg">
                                                                </img>
                                                            </div>
                                                            <div class="attachment-info">
                                                                <p>
                                                                    Attachment1.jpg
                                                                </p>
                                                                <span>
                                                                    444 KB
                                                                </span>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
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
                                                    </li>
                                                </ul>
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
