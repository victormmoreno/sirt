@extends('layouts.app')

@section('content')

@section('meta-title', 'Linea Tecnologica '. $linea->nombre)
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b m-r-lg m-l-lg">
            <div class="left left-align">
                <h5 class="left-align primary-text">
                    <a class="footer-text left-align" href="{{route('lineas.index')}}">
                        <i class="material-icons arrow-l left">
                            arrow_back
                        </i>
                    </a>
                    Linea Tecnologica | {{$linea->nombre}}
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li><a href="{{route('lineas.index')}}">Lineas</a></li>
                    <li class="active">{{$linea->nombre}}</li>
                </ol>
            </div>
        </div>
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="card mailbox-content">
                        <div class="card-content">
                            <div class="mailbox-view">
                                <div class="mailbox-view-header">
                                    <div class="left">
                                        <span class="mailbox-title primary-text">
                                            <i class="material-icons left">
                                                linear_scale
                                            </i>
                                            {{$linea->abreviatura}} - {{$linea->nombre}}
                                        </span>
                                        <span class="mailbox-author secondary-text">
                                            Linea registrada el {{$linea->created_at->isoFormat('LL')}}
                                        </span>
                                    </div>
                                </div>
                                <div class="divider mailbox-divider"></div>
                                <div class="mailbox-text">
                                    <div class="row">
                                        <div class="col s12 m6 l6">
                                            <div class="row">
                                                <div class="center-align">
                                                    <span class="mailbox-title center">
                                                        <i class="material-icons left">
                                                            info
                                                        </i>
                                                        Información Linea Tecnologica
                                                    </span>
                                                </div>
                                                
                                                <div class="divider mailbox-divider">
                                                </div>
                                            
                                                <ul class="collection">
                                                    
                                                    <li class="collection-item avatar">
                                                        <i class="material-icons circle bg-primary">
                                                            dns
                                                        </i>
                                                        <span class="title">
                                                            Abreviatura
                                                        </span>
                                                        <p>
                                                           {{$linea->abreviatura}} 
                                                        </p>
                                                    </li>
                                                    <li class="collection-item avatar">
                                                        <i class="material-icons circle bg-primary">
                                                            dns
                                                        </i>
                                                        <span class="title">
                                                            Nombre
                                                        </span>
                                                        <p>
                                                           {{$linea->nombre}} 
                                                        </p>
                                                    </li>
                                                    <li class="collection-item avatar">
                                                        <i class="material-icons circle bg-primary">
                                                            speaker_notes
                                                        </i>
                                                        <span class="title">
                                                            Descripción
                                                        </span>
                                                        <p>
                                                           {{!empty($linea->descripcion) ? $linea->descripcion : 'No registra' }} 
                                                        </p>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="row">
                                                <div class="center-align">
                                                    <span class="mailbox-title center">
                                                        <i class="material-icons left">
                                                            info
                                                        </i>
                                                        Sublineas de la linea de {{$linea->nombre}}
                                                    </span>
                                                </div>
                                                
                                                <div class="divider mailbox-divider"></div>
                                            
                                                <ul class="collection">
                                                    @forelse($linea->sublineas as $sublinea)
                                                    <li class="collection-item avatar">
                                                        <i class="material-icons circle bg-primary">
                                                            linear_scale
                                                        </i>
                                                        <span class="title">
                                                            {{$sublinea->nombre}} 
                                                        </span>
                                                        
                                                    </li>
                                                    @empty
                                                        <span class="title">
                                                            No hay sublineas asociadas a la linea de {{$linea->nombre}}
                                                        </span>
                                                    @endforelse
                                                    
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col s12 m6 l6">
                                            <div class="center-align">
                                                <span class="mailbox-title center">
                                                    <i class="material-icons left">
                                                        info
                                                    </i>
                                                    Tecnoparques con la linea de {{$linea->nombre}}
                                                </span>
                                            </div>
                                            
                                            <div class="divider mailbox-divider">
                                            </div>
                                        
                                            <ul class="collection">
                                                @forelse($linea->nodos as $nodo)
                                                <li class="collection-item avatar">
                                                    <i class="material-icons circle bg-primary">
                                                        domain
                                                    </i>
                                                    <span class="title">
                                                        Tecnoparque {{$nodo->entidad->nombre}} 
                                                    </span>
                                                    <p>
                                                       <b>Correo electónico: </b>{{!empty($nodo->entidad->email_entidad) ? $nodo->entidad->email_entidad : 'No registra' }}
                                                    </p>
                                                    <p>
                                                       <b>Telefono: </b>{{!empty($nodo->telefono) ? $nodo->telefono : 'No registra' }}
                                                    </p>
                                                    <p>
                                                       <b>Dirección: </b> {{$nodo->direccion}} | {{$nodo->entidad->ciudad->nombre}} ({{$nodo->entidad->ciudad->departamento->nombre}})
                                                    </p>
                                                    <p>
                                                       <a href="{{route("nodo.show", $nodo->entidad->slug)}}" target="_blank" class="info">Ver más información</a>
                                                    </p>
                                                </li>
                                                @empty
                                                <li class="collection-item avatar">
                                                    <i class="material-icons circle bg-primary">
                                                        info
                                                    </i>
                                                    <span class="title">
                                                        No hay tecnoparques asociados a la linea de {{$linea->nombre}}
                                                    </span>
                                                    
                                                </li>
                                                @endforelse
                                                
                                            </ul>
                                        </div>
                                    </div>
                                   
                                <div class="divider mailbox-divider"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
