@extends('layouts.app')
@section('meta-title', 'Talentos')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s10 m10 l10">
                        <h5 class="left-align">
                            <a class="footer-text left-align" href="{{route('usuario.index')}}">
                                <i class="material-icons arrow-l">
                                    arrow_back
                                </i>
                            </a>
                            Usuarios | Talentos
                            <i class="material-icons">
                                supervised_user_circle
                            </i>
                        </h5>
                    </div>
                </div>
                <div class="card ">
                    <div class="card-content">
                        <div class="row">
                            <div class="row">
                                <div class="col s12 m12 l10">
                                    <div class="center-align">
                                        <span class="card-title center-align">
                                            Talentos {{config('app.name')}}
                                        </span>
                                        <i class="material-icons">
                                            supervised_user_circle
                                        </i>
                                    </div>
                                </div>
                                <div class="col s12 l2">
                                    <div class="click-to-toggle show-on-large hide-on-med-and-down">
                                        <a class="btnregister btn btn-floating btn-large tooltipped green" data-delay="50" data-position="button" data-tooltip="Nuevo Usuario" href="{{route('usuario.usuarios.create')}}">
                                            <i class="material-icons">
                                                how_to_reg
                                            </i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <ul class="tabs tab-demo z-depth-1" style="width: 100%;">
                              <li class="tab col s3"><a href="#historialTalento" class="active">Talentos {{config('app.name')}}</a></li>
                              <li class="tab col s3"><a href="#TalentoProyectoNodo" >Talentos con proyectos realizados en {{config('app.name')}}</a></li>
                              <div class="indicator" style="right: 580.5px; left: 0px;"></div>
                            </ul>
                            <div class="divider">
                            </div>
                            <div id="historialTalento">
                                <h5 class="center-align">Talentos {{config('app.name')}}</h5>
                                <div class="divider">
                            </div>
                                <table class="display responsive-table" id="talento_history_table">
                                <thead>
                                    <th>Tipo Documento</th>
                                    <th>Docuemento</th>
                                    <th>Usuario</th>
                                    <th>Correo</th>
                                    <th>Telefono</th>
                                    <th>Estado Sistema</th>
                                    <th>Detalles</th>
                                </thead>
                
                            </table>
                            </div>
                            <div id="TalentoProyectoNodo">
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <div class="file-field input-field">
                                        <div class="file-path-wrapper">
                                            <select class="js-states browser-default select2 " tabindex="-1" style="width: 100%" id="selectnodo" onchange="UserAdministradorGestor.selectGestoresPorNodo()">
                                                <option value="">Seleccione nodo</option>
                                                @foreach($nodos as $id => $nodo)
                                                  <option value="{{$id}}">{{$nodo}}</option>
                                                @endforeach
                                            </select>
                                            <label class="active" for="selectnodo">Nodo <span class="red-text">*</span></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table class="display responsive-table" id="talento_proyecto_table">
                                <thead>
                                    <th>Tipo Documento</th>
                                    <th>Docuemento</th>
                                    <th>Usuario</th>
                                    <th>Correo</th>
                                    <th>Telefono</th>
                                    <th>Estado Sistema</th>
                                    <th>Detalles</th>
                                    <th>Editar</th>
                                </thead>
                
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<div  class="modal detalleUsers">
  <div class="modal-content">
    <div class="titulo_users"></div>
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-action modal-close waves-effect waves-yellow btn-flat ">Cerrar</a>
  </div>
</div>

@endsection