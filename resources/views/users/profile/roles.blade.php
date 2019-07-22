@extends('layouts.app')

@section('meta-title', 'Roles |' . $user->nombres. ' '. $user->apellidos)

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
                                                                    <i class="material-icons circle teal darken-2">
                                                                        credit_card
                                                                    </i>
                                                                    <span class="title">
                                                                        {{$role->name}}
                                                                    </span>
                                                                    <p>
                                                                       @if($role->permissions->count())
                                                                        <small>{{$role->permissions->pluck('name')->implode(', ')}}</small>
                                                                      @endif
                                                                        
                                                                    </p>
                                                                </li>
                                                            @empty
                                                            <p>No tienes roles asignados</p>
                                                            @endforelse
                                                            
    
                                                        </ul>
                                                    </div>
                                                    
                                                </div>
                                                <div class="divider mailbox-divider">
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
