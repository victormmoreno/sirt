@extends('layouts.app')

@section('meta-title', 'Roles |' . $user->nombres. ' '. $user->apellidos)

@section('content')
    <main class="mn-inner inner-active-sidebar">
        <div class="content">
            <div class="row no-m-t no-m-b m-r-lg m-l-lg">
                <div class="left left-align">
                    <h5 class="left-align primary-text">
                        <i class="material-icons left">supervised_user_circle</i>Usuarios | Perfil
                    </h5>
                </div>
                <div class="right right-align show-on-large hide-on-med-and-down">
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li class="active">Perfil</li>
                    </ol>
                </div>
            </div>
            <div class="row no-m-t no-m-b">
                <div class="col s12 m12 l12">
                    <div class="card mailbox-content">
                        <div class="card-content">
                            <div class="row no-m-t no-m-b">
                                <div class="col s12 m5 l3">
                                    <div class="row">
                                        @include('users.profile.nav.nav-profile')
                                    </div>
                                </div>
                                <div class="col s12 m7 l9">
                                    @include('users.profile.nav.navbar')
                                    <div class="mailbox-view">
                                        <div class="mailbox-view-header">
                                            @include('users.profile.nav.header')
                                            <div class="right mailbox-buttons">
                                                    <span class="mailbox-title">
                                                        <p class="center">Roles</p>
                                                    </span>
                                            </div>
                                        </div>
                                        <div class="divider mailbox-divider">
                                        </div>
                                        <div class="mailbox-text">
                                            <div class="row">
                                                <div class="col s12 m6 l6 offset-l3 m3 ">
                                                    <ul class="collection">
                                                        @forelse($user->roles as $role)
                                                            <li class="collection-item avatar">
                                                                <i class="material-icons circle bg-primary">beenhere</i>
                                                                <span class="title">{{$role->name}}</span>
                                                            </li>
                                                        @empty
                                                            <div class="center">
                                                                <i class="large material-icons center">pan_tool</i>
                                                                <p class="center-align">No tienes roles asignados</p>
                                                            </div>
                                                        @endforelse
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
