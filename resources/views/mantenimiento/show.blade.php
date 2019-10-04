@extends('layouts.app')
@section('meta-title', 'Mantenimientos | '. $mantenimiento->equipo_nombre)

@section('content')

<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s12 m8 l8">
                        <h5 class="left-align">
                            
                            Mantenimiento de equipo {{$mantenimiento->equipo_nombre}}
                        </h5>
                    </div>
                    <div class="col s12 m4 l4 ">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li><a href="{{route('mantenimiento.index')}}">Mantenimientos</a></li>
                            <li class="active">Mantenimientos de equipos</li>
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
                                                                Tecnoparque nodo {{$mantenimiento->entidad_nombre}} 
                                                            </span>
                                                            <span class="mailbox-author">
                                                                <b>Dirección: </b> {{$mantenimiento->nodo_direccion}}<br/>
                                                                <b>Correo Electrónco: </b> 
                                                                {{isset($mantenimiento->email_entidad) ? $mantenimiento->email_entidad : 'No registra'}}<br/>
                                                                <b>Teléfono: </b> 
                                                                {{isset($mantenimiento->nodo_telefono) ? $mantenimiento->nodo_telefono : 'No registra'}}<br/>
                                                            </span>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="right mailbox-buttons">
                                                        <span class="mailbox-title">
                                                            <p class="center">Información Mantenimiento de equipo {{$mantenimiento->equipo_nombre}} </p><br/>
                                                            <p class="center">Linea Tecnológica: {{$mantenimiento->lineatecnologica_abreviatura}} - {{$mantenimiento->lineatecnologica_nombre}} </p>
                                                        </span>

                                                    </div>
                                            </div>
                                            <div class="right">
                                                <small>
                                                    <b>Fecha de registro mantenimiento: </b> {{optional($mantenimiento->created_at)->isoFormat('LL')}}
                                                </small>
                                            </div>
                                            <div class="divider mailbox-divider">
                                            </div>
                                            <div class="mailbox-text">
                                                <div class="row">
                                                    <div class="col s12 m3 l3  push-l1 push-m1">
                                                        <div class="center">
                                                            <span class="mailbox-title">
                                                                <i class="material-icons fas fa-th-list"></i>
                                                                Información de Equipo 
                                                            </span>
                                                        </div>
                                                        <div class="divider mailbox-divider"></div>
                                                        <ul class="collection">
                                                            <li class="collection-item"> 
                                                                <span class="title">
                                                                    Nombre: {{$mantenimiento->equipo_nombre}}
                                                                </span>
                                                                <p>
                                                                   Referencia: {{$mantenimiento->referencia}}
                                                                </p>
                                                                <p>
                                                                   Marca: {{$mantenimiento->marca}}
                                                                </p>
                                                                <p>
                                                                   Costo Adquisición: ${{number_format($mantenimiento->costo_adquisicion,0)}} 
                                                                </p>
                                                                <p>
                                                                   Vida Util: {{$mantenimiento->vida_util}} años
                                                                </p>
                                                                <p>
                                                                   Año de compra: {{$mantenimiento->anio_compra}} 
                                                                </p>
                                                                    
                                                            </li>
                                                            
                                                            
                                                        </ul>
                                                        
                                                    </div>
                                                    <div class="col s12 m8 l8 push-l1 push-m1 pull-l1 pull-m1">
                                                        <div class="center">
                                                            <span class="mailbox-title">
                                                                {{-- <i class="material-icons fas fa- user-friends"></i> --}}
                                                                <i class="material-icons    fas fa-user-friends"></i>
                                                                Información Mantenimiento de equipo {{$mantenimiento->equipo_nombre}} 
                                                            </span>
                                                        </div>
                                                        <div class="divider mailbox-divider"></div>
                                                            <div class="row">
                                                                <div class="col s12 m6 l6">
                                                                    <ul class="collection">
                                                                        <li class="collection-item"> 
                                                                            <span class="title">
                                                                                Linea Tecnológica
                                                                            </span>
                                                                            <p>
                                                                              {{$mantenimiento->lineatecnologica_nombre}}
                                                                            </p>  
                                                                        </li>
                                                                        <li class="collection-item"> 
                                                                            <span class="title">
                                                                                Año de Mantenimiento
                                                                            </span>
                                                                            <p>
                                                                              {{$mantenimiento->anio_mantenimiento}}
                                                                            </p>  
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="col s12 m6 l6">
                                                                    <ul class="collection">
                                                                        <li class="collection-item"> 
                                                                            <span class="title">
                                                                                Equipo
                                                                            </span>
                                                                            <p>
                                                                              {{$mantenimiento->equipo_nombre}}
                                                                            </p>  
                                                                        </li>
                                                                        <li class="collection-item"> 
                                                                            <span class="title">
                                                                                Valor de Mantenimiento
                                                                            </span>
                                                                            <p>
                                                                               ${{number_format($mantenimiento->valor_mantenimiento,0)}}
                                                                            </p>    
                                                                        </li>
                                                                    </ul>
                                                                </div>
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