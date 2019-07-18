@extends('layouts.app')
@section('meta-title', 'Dinamizadores')
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
                            Usuarios | Dinamizadores
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
                                            Dinamizadores {{config('app.name')}}
                                        </span>
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
                            <div class="divider">
                            </div>
                            

                            <div class="row">

                                    <div class="col s12 m12 l12">
                                        <div class="file-field input-field">

                                            <div class="file-path-wrapper">
                                                <select class="js-states browser-default select2 " tabindex="-1" style="width: 100%" id="selectnodo" onchange="UserAdministradorDinamizador.selectDinamizadoresPorNodo()">
                                                    <option value="">Seleccione nodo</option>
                                                    @foreach($nodos as $nodo)
                                                      <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                                                    @endforeach
                                                </select>
                                                <label class="active" for="selectnodo">Nodo <span class="red-text">*</span></label>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            
                                <br>
                                <table class="display responsive-table" id="dinamizador_table">
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
</main>
<div id="detalledinamizador" class="modal">
  <div class="modal-content">
    <center><h4 id="titulo_dinamizador" class="center-aling"></h4></center>
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-action modal-close waves-effect waves-yellow btn-flat ">Cerrar</a>
  </div>
</div>

@endsection