@extends('layouts.app')
@section('meta-title', 'Mantenimientos | '. $material->nombre)

@section('content')

<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s12 m8 l8">
                        <h5 class="left-align hand-of-Sean-fonts orange-text text-darken-3">
                            <a class="footer-text left-align" href="{{route('material.index')}}">
                                <i class="material-icons arrow-l">
                                    arrow_back
                                </i>
                            </a>
                            Material {{$material->nombre}}
                        </h5>
                    </div>
                    <div class="col s12 m4 l4 rigth-align  show-on-large hide-on-med-and-down ">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li><a href="{{route('material.index')}}">Materiales</a></li>
                            <li class="active">{{$material->nombre}}</li>
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
                                                            <span class="mailbox-title green-complement-text">
                                                                <i class="material-icons fas fa-building"></i> 
                                                                Tecnoparque nodo {{$material->nodo->entidad->nombre}}
                                                            </span>
                                                            <span class="mailbox-author show-on-large hide-on-med-and-down ">
                                                                <b>Dirección: </b> {{$material->nodo->direccion}}<br/>
                                                                <b>Correo Electrónco: </b>
                                                                {{isset($material->nodo->entidad->email_entidad) ? $material->nodo->entidad->email_entidad : 'No registra'}}<br/>
                                                                <b>Teléfono: </b>
                                                                {{isset($material->nodo->telefono) ? $material->nodo->telefono : 'No registra'}}<br/>
                                                            </span>
                                                        </div>

                                                   
                                                    <div class="right mailbox-buttons">
                                                        <span class="mailbox-title">
                                                            <p class="center">Información Materiales de Formación {{$material->nombre}} </p><br/>
                                                            <p class="center">Linea Tecnológica: {{$material->lineatecnologica->abreviatura}} - {{$material->lineatecnologica->nombre}} </p>
                                                        </span>

                                                    </div>
                                            </div>
                                            <div class="right">
                                                <small>
                                                    <b>Fecha de registro material: </b> {{optional($material->created_at)->isoFormat('LL')}}
                                                </small>
                                            </div>
                                            <div class="divider mailbox-divider">
                                            </div>
                                            <div class="mailbox-text">
                                                <div class="row">

                                                    <div class="col s12 m8 l8 offset-l2 offset-m2">
                                                        <div class="center">
                                                            <span class="mailbox-title hand-of-Sean-fonts orange-text text-darken-3">
                                                                Información Material de Formación {{$material->nombre}}
                                                            </span>
                                                        </div>
                                                        <div class="divider mailbox-divider"></div>
                                                            <div class="row">
                                                                <div class="col s12 m6 l6">
                                                                    <ul class="collection">
                                                                        <li class="collection-item">
                                                                            <span class="title cyan-text text-darken-3">
                                                                                Linea Tecnológica
                                                                            </span>
                                                                            <p>
                                                                              {{$material->lineatecnologica->nombre}}
                                                                            </p>
                                                                        </li>

                                                                        <li class="collection-item">
                                                                            <span class="title cyan-text text-darken-3">
                                                                                Tipo Material
                                                                            </span>
                                                                            <p>
                                                                              {{$material->tipomaterial->nombre}}
                                                                            </p>
                                                                        </li>
                                                                        <li class="collection-item">
                                                                            <span class="title cyan-text text-darken-3">
                                                                                Presentación
                                                                            </span>
                                                                            <p>
                                                                              {{$material->presentacion->nombre}}
                                                                            </p>
                                                                        </li>
                                                                        <li class="collection-item">
                                                                            <span class="title cyan-text text-darken-3">
                                                                                Cantidad
                                                                            </span>
                                                                            <p>
                                                                              {{$material->cantidad}}
                                                                            </p>
                                                                        </li>
                                                                        <li class="collection-item">
                                                                            <span class="title cyan-text text-darken-3">
                                                                                Valor Total Compra
                                                                            </span>
                                                                            <p>
                                                                              ${{number_format($material->valor_compra,0)}}
                                                                            </p>
                                                                        </li>
                                                                        <li class="collection-item">
                                                                            <span class="title cyan-text text-darken-3">
                                                                                Marca
                                                                            </span>
                                                                            <p>
                                                                              ${{$material->marca}}
                                                                            </p>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="col s12 m6 l6">
                                                                    <ul class="collection">
                                                                        <li class="collection-item">
                                                                            <span class="title cyan-text text-darken-3">
                                                                                Fecha Adquisición
                                                                            </span>
                                                                            <p>
                                                                              {{$material->fecha->isoFormat('LL')}}
                                                                            </p>
                                                                        </li>
                                                                        <li class="collection-item">
                                                                            <span class="title cyan-text text-darken-3">
                                                                                Categoria Material
                                                                            </span>
                                                                            <p>
                                                                              {{$material->categoriamaterial->nombre}}
                                                                            </p>
                                                                        </li>
                                                                        <li class="collection-item">
                                                                            <span class="title cyan-text text-darken-3">
                                                                                Medida
                                                                            </span>
                                                                            <p>
                                                                               {{$material->medida->nombre}}
                                                                            </p>
                                                                        </li>
                                                                        <li class="collection-item">
                                                                            <span class="title cyan-text text-darken-3">
                                                                                Nombre de Material
                                                                            </span>
                                                                            <p>
                                                                               {{$material->nombre}}
                                                                            </p>
                                                                        </li>

                                                                        <li class="collection-item">
                                                                            <span class="title cyan-text text-darken-3">
                                                                                Proveedor
                                                                            </span>
                                                                            <p>
                                                                               {{$material->proveedor}}
                                                                            </p>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                <div class="divider mailbox-divider">
                                                </div>
                                                @if(session()->has('login_role') && (session()->get('login_role') == App\User::IsDinamizador() || session()->get('login_role') == App\User::IsGestor()))
                                                
                                                    <div class="row">
                                                    <div class="col s6 ">
                                                        <div class="right">
                                                        <a href="{{route('material.edit',$material->id)}}" class="waves-effect waves-teal darken-2 btn-flat m-t-xs center-aling">
                                        
                                                            Cambiar Información
                                                        </a>
                                                        </div>
                                                    </div>
                                                    <div class="col s6 ">
                                                        <div class="left">
                                                        <a href="javascript:void(0)"  class="waves-effect red lighten-3 btn 2 btn-flat m-t-xs center-aling" onclick="materialFormacion.destroyMaterial({{$material->id}})">
                                                            <i class="material-icons right">
                                                                delete_sweep
                                                            </i>
                                                            Eliminar
                                                        </a>
                                                    </div>
                                                    </div>
                                                </div>
                                                
                                                @endif
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
