@extends('layouts.app')
@section('meta-title', 'Tecnoparque nodo '. $nodo->entidad->nombre)

@section('content')

<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s12 m6 l6">
                        <h5 class="left-align">
                            
                            Tecnoparque Nodo {{$nodo->entidad->nombre}}
                        </h5>
                    </div>
                    <div class="col s12 m4 l4 offset-l2 m-2 rigth-align">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li><a href="{{route('nodo.index')}}">Nodos</a></li>
                            <li class="active">Tecnoparque Nodo {{$nodo->entidad->nombre}}</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m12 l12">
                        <div class="card mailbox-content">
                            <div class="card-content">
                                <div class="row no-m-t no-m-b">
                                    <div class="col s12 m12 l12">
                                        <div class="mailbox-view">
                                            <div class="mailbox-view-header">
                                                <div class="left">
                                                    <div class="left">
                                                        <i class="material-icons fas fa-building"></i>
                                                    </div>
                                                    <div class="left">
                                                        <span class="mailbox-title">
                                                         Tecnoparque nodo {{$nodo->entidad->nombre}} - 
                                                        {{$nodo->entidad->ciudad->nombre}} ({{$nodo->entidad->ciudad->departamento->nombre}})
                                                    </span>
                                                    <span class="mailbox-author">
                                                        <b>Dirección: </b> {{$nodo->direccion}}<br/>
                                                        <b>Correo Electrónco: </b>
                                                        {{isset($nodo->entidad->email_entidad) ? $nodo->entidad->email_entidad : 'No registra'}}<br/>
                                                        <b>Teléfono: </b> 
                                                        {{isset($nodo->telefono) ? $nodo->telefono : 'No registra'}}<br/>
                                                    </span>
                                                    </div>
                                                    
                                                </div>
                                                <div class="right mailbox-buttons">
                                                    <span class="mailbox-title">
                                                        <p class="center">Información Tecnoparque Nodo {{$nodo->entidad->nombre}}</p><br/>
                                                        <p class="center">{{isset($nodo->centro->entidad->nombre) ? $nodo->centro->entidad->nombre : ''}} - {{isset($nodo->centro->entidad->ciudad->nombre) ? $nodo->centro->entidad->ciudad->nombre : ''}} ({{ isset($nodo->centro->entidad->ciudad->departamento->nombre) ? $nodo->centro->entidad->ciudad->departamento->nombre : ''}})</p>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="right">
                                                <small class="green-text text-darken-2">
                                                    <a class="waves-effect waves-red btn-flat">
                                                        <i class="fas fa-file-excel   fa-lg"></i>Exportar a PDF 
                                                    </a>
                                                    
                                                </small>
                                                <small class="green-text text-darken-2">
                                                    <a class="waves-effect waves-green btn-flat">
                                                        <i class="material-icons left">cloud</i>Exportar a Excel  
                                                    </a>
                                                </small>
                                            </div>
                                            <div class="divider mailbox-divider"></div>
                                            <div class="mailbox-text">
                                                <div class="row">
                                                    <div class="col s12 m3 l3  push-l1 push-m1">
                                    
                                                        <ul class="collection with-header">
                                                            <li class="collection-header center">
                                                                <h5><b>Lineas Tecnológicas ({{$nodo->lineas->count()}})</b></h5>
                                                            </li>
                                                          
                                                            @forelse($lineatecnologicas as $value)
                                                                <li class="collection-item">
                                                                    <span class="title">
                                                                        {{$value->abreviatura}} - {{$value->nombre}}
                                                                    </span>
                                                                    <p>Porcentaje: {{$value->pivot->porcentaje_linea}} %</p>
                                                                    
                                                                </li>   
                                                            @empty
                                                            <div class="center">
                                                               <i class="large material-icons center">
                                                                    block
                                                                </i>
                                                                <p class="center-align">No tienes lineas tecnológicas registradas aún.</p>
                                                            </div>
                                                            @endforelse                    
                                                        </ul>
                                                         @if(isset($lineatecnologicas))
                                                            <div class="center">
                                                                {{ $lineatecnologicas->links() }}
                                                            </div>
                                                        @endif
                                                        
                                    
                                                        <ul class="collection with-header">
                                                            <li class="collection-header center">
                                                                <h5><b>Equipos ({{$nodo->equipos->count()}})</b></h5>
                                                            </li>
                                                          
                                                            @forelse($equipos as $value)
                                                                <li class="collection-item">
                                                                    
                                                                    <span class="title">
                                                                        {{$value->nombre}}
                                                                    </span>
                                                                    <p class="p-v-xs">
                                                                        {{$value->lineatecnologica->abreviatura}} - {{$value->lineatecnologica->nombre}}
                                                                    </p>
                                                                </li>
                                                            @empty
                                                            <div class="center">
                                                               <i class="large material-icons center">
                                                                    block
                                                                </i>
                                                                <p class="center-align">No tienes equipos registrados aún.</p>
                                                            </div>
                                                            @endforelse                    
                                                        </ul>
                                                         @if(isset($equipos))
                                                            <div class="center">
                                                                {{ $equipos->links() }}
                                                            </div>
                                                        @endif 
                                                        
                                                        <div class="divider mailbox-divider"></div>
                                                    </div>
                                                    <div class="col s12 m8 l8 push-l1 push-m1 pull-l1 pull-m1">
                                                        <div class="center">
                                                            <span class="mailbox-title">
                                                                {{-- <i class="material-icons fas fa- user-friends"></i> --}}
                                                                <i class="material-icons    fas fa-user-friends"></i>
                                                                Equipo Tecnoparque Nodo {{$nodo->entidad->nombre}}
                                                            </span>
                                                        </div>
                                                        <div class="divider mailbox-divider"></div>
                                                        <div class="row">
                                                            <div class="col s12 m6 l6">
                                                                <div class="center">
                                                                   <span><b>{{App\User::IsDinamizador()}} </b></span> 
                                                                </div>
                                                                <ul class="collection">
                                                                    @if(isset($nodo->dinamizador->user))
                                                                        <li class="collection-item">
                                                                            
                                                                            <span class="title">
                                                                                {{$nodo->dinamizador->user->documento}} - {{$nodo->dinamizador->user->nombres}} {{$nodo->dinamizador->user->apellidos}} 
                                                                            </span>
                                                                            <p>
                                                                               <b>Correo Electrónco:</b> {{$nodo->dinamizador->user->email}}<br/>
                                                                               <b>Teléfono:</b> {{isset($nodo->dinamizador->user->telefono) ? $nodo->dinamizador->user->telefono : 'No registra'}}<br/>
                                                                               <b>Celular: </b>
                                                                               {{isset($nodo->dinamizador->user->celular)  ? $nodo->dinamizador->user->celular : 'No registra'}}<br/>
                                                                                
                                                                            </p>
                                                                        </li>    
                                                                    @else
                                                                        <div class="center">
                                                                           <i class="large material-icons center">
                                                                                block
                                                                            </i>
                                                                            <p class="center-align">Tecnoparque Nodo {{$nodo->entidad->nombre}} no cuenta con un {{App\User::IsDinamizador()}} aún</p> 
                                                                        </div>
                                                                    @endif
                                                                </ul>
                                                            </div>
                                                            <div class="col s12 m6 l6">
                                                                <div class="center">
                                                                   <span><b>{{App\User::IsInfocenter()}} ({{$nodo->infocenter->count()}})</b></span> 
                                                                </div>
                                                                <ul class="collection">
                                                                    @forelse($nodo->infocenter as $infocenter)
                                                                        <li class="collection-item">
                                                                            
                                                                            <span class="title">
                                                                                {{$infocenter->user->documento}} - {{$infocenter->user->nombres}} {{$infocenter->user->apellidos}}
                                                                            </span>
                                                                            <p>
                                                                                <b>Correo Electrónco:</b> {{$nodo->dinamizador->user->email}}<br/>
                                                                               <b>Teléfono:</b> {{isset($infocenter->user->telefono) ? $infocenter->user->telefono : 'No registra'}}<br/>
                                                                               <b>Celular: </b>
                                                                               {{isset($infocenter->user->celular)  ? $infocenter->user->celular : 'No registra'}}<br/>
                                                                               Telefono (extensión):{{$nodo->telefono}} ({{$infocenter->extension}})
                                                                                
                                                                            </p>
                                                                        </li>
                                                                    @empty
                                                                        <div class="center">
                                                                           <i class="large material-icons center">
                                                                                block
                                                                            </i>
                                                                            <p class="center-align">Tecnoparque Nodo {{$nodo->entidad->nombre}} no cuenta con un {{App\User::IsInfocenter()}} aún</p> 
                                                                        </div>
                                                                    @endforelse
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            
                                                            <div class="center">
                                                                <span><b>Gestores ({{$nodo->gestores->count()}})</b></span> 
                                                            </div>
                                                            <div class="divider mailbox-divider">
                                                            </div>
                                                            @forelse($nodo->gestores as $gestor)
                                                                <div class="col s12 m6 l6">
                                                                    <ul class="collection">
                                                                        <li class="collection-item">
                                                                            
                                                                            <span class="title">
                                                                                {{$gestor->user->documento}} - {{$gestor->user->nombres}} {{$gestor->user->apellidos}}
                                                                            </span>
                                                                            <p>
                                                                                <b>Correo Electrónco:</b> {{$nodo->dinamizador->user->email}}<br/>
                                                                               <b>Teléfono:</b> {{isset($gestor->user->telefono) ? $gestor->user->telefono : 'No registra'}}<br/>
                                                                               <b>Celular: </b>
                                                                               {{isset($gestor->user->celular)  ? $gestor->user->celular : 'No registra'}}<br/>
                                                                               <b>Honorarios: </b>
                                                                               ${{isset($gestor->honorarios)  ? $gestor->honorarios : 0}}<br/>
                                                                               <b>Linea Tecnológica: </b>
                                                                               {{isset($gestor->lineatecnologica->nombre)  ? $gestor->lineatecnologica->nombre : 'No registra'}}<br/>
                                                                              
                                                                            </p>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            @empty
                                                                <div class="col s12 m6 l6 offset-l3 m3">
                                                                    
                                                                    <ul class="collection">
                                                                        <div class="center">
                                                                           <i class="large material-icons center">
                                                                                block
                                                                            </i>
                                                                            <p class="center-align">Tecnoparque Nodo {{$nodo->entidad->nombre}} no cuenta con un {{App\User::IsGestor()}} aún</p> 
                                                                        </div>
                                                                    </ul>
                                                                </div>
                                                                
                                                            @endforelse
                                                                
                                                        </div>
                                                        <div class="row">
                                                            
                                                            <div class="center">
                                                                <span><b>Ingreso {{$nodo->entidad->nombre}} ({{$nodo->ingresos->count()}})</b></span> 
                                                            </div>
                                                            <div class="divider mailbox-divider">
                                                            </div>
                                                            @forelse($nodo->ingresos as $ingreso)
                                                                <div class="col s12 m6 l6">
                                                                    <ul class="collection">
                                                                        <li class="collection-item ">
                                                                            
                                                                            <span class="title">
                                                                                {{$ingreso->user->documento}} - {{$ingreso->user->nombres}} {{$ingreso->user->apellidos}}
                                                                            </span>
                                                                            <p>
                                                                                <b>Correo Electrónco:</b> {{$nodo->dinamizador->user->email}}<br/>
                                                                               <b>Teléfono:</b> {{isset($ingreso->user->telefono) ? $ingreso->user->telefono : 'No registra'}}<br/>
                                                                               <b>Celular: </b>
                                                                               {{isset($ingreso->user->celular)  ? $ingreso->user->celular : 'No registra'}}<br/>
                                                                              
                                                                            </p>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            @empty
                                                                <div class="col s12 m6 l6 offset-l3 m3">
                                                                    <ul class="collection">
                                                                        <div class="center">
                                                                           <i class="large material-icons center">
                                                                                block
                                                                            </i>
                                                                            <p class="center-align">Tecnoparque Nodo {{$nodo->entidad->nombre}} no cuenta con un usuario {{App\User::IsIngreso()}} aún</p> 
                                                                        </div>
                                                                    </ul>
                                                                </div>
                                                                
                                                            @endforelse
                                                                
                                                        </div>
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
</main>
@endsection