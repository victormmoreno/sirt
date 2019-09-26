@extends('layouts.app')
@section('meta-title', 'Laboratorio Tecnopaque nodo ' )
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s8 m8 l10">
                        <h5 class="left-align">

                            <a class="footer-text left-align" href="{{route('laboratorio.index')}}">
                                <i class="material-icons arrow-l">
                                    arrow_back
                                </i>
                            </a>
                            Costos Administrativos
                            <i class="material-icons">
                                settings_input_svideo
                            </i>
                        </h5>
                    </div>
                    <div class="col s4 m4 l2 rigth-align">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li class="active">Costos Administrativos</li>
                        </ol>
                      </div>
                </div>
                <div class="card ">
                    
                    <div class="card-content">
                    @if(session()->has('login_role') && session()->get('login_role') == App\User::IsAdministrador())
                        <div class="row">
                            <div class="row">
                                <div class="col s12 m12 l10">
                                    <div class="center-align">
                                        <span class="card-title center-align">
                                            Costos Administrativo {{config('app.name')}}
                                        </span>
                                        <i class="material-icons">
                                            settings_input_svideo
                                        </i>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="divider">
                            </div>
                            <div class="row">
                                    <div class="col s12 m12 l12">
                                        <label class="active" for="selectnodo">Nodo <span class="red-text">*</span></label>
                                        <select class="js-states browser-default select2 " onchange="selectLaboratorioNodo.selectLaboraotrioForNodo()" tabindex="-1" style="width: 100%" id="selectnodo" >
                                            <option value="">Seleccione nodo</option>
                                            @foreach($nodos as $nodo)
                                              <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                                            @endforeach
                                        </select>
                                        
                                    </div>
                                </div>
                                <br>
                                <table class="display responsive-table" id="costoadministrativo_administrador_table">
                                    <thead>
                                        <th>Nombre</th>
                                        <th>Linea</th>
                                        <th>Costo Administrativo</th>
                                        <th>Estado</th>
                                        <th>Materiales de formación</th>
                                        <th>Editar</th>                                        
                                    </thead>
                    
                                </table>
                        </div>
                    @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsDinamizador())
                        <div class="row">
                            <div class="row">
                                <div class="col s12 m12 l10">
                                    <div class="center-align">
                                        <span class="card-title center-align">
                                            Costos Administrativos Tecnopaque Nodo {{\NodoHelper::returnNameNodoUsuario()}}
                                        </span>
                                        <i class="material-icons">
                                            settings_input_svideo
                                        </i>
                                    </div>
                                </div>
                               
                            </div>
                            <div class="divider">
                            </div>
                                                       
                                <br>
                                <table class="display responsive-table" id="costoadministrativo_dinamizador_table">
                                    <thead>
                                        <th>Nombre</th>
                                        <th>Linea</th>
                                        <th>Costo Administrativo</th>
                                        <th>Estado</th>
                                        <th>Materiales de formación</th>
                                        <th>Editar</th>  
                                    </thead>
                    
                                </table>
                        </div>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<div  class="modal detalleUsers">
  <div class="modal-content">
    <center><h4 class="center-aling"></h4></center>
    <div class="divider"></div>
    <div class="titulo_users"></div>
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-action modal-close waves-effect waves-yellow btn-flat ">Cerrar</a>
  </div>
</div>
@endsection