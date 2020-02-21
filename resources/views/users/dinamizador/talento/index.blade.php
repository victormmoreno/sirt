@extends('layouts.app')
@section('meta-title', 'Talentos')
@section('content')
@php
  $year = Carbon\Carbon::now()->year;
@endphp
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s8 m8 l10">
                        <h5 class="left-align">
                              <a class="footer-text left-align" href="{{route('usuario.index')}}">
                                  <i class="material-icons arrow-l">
                                      arrow_back
                                  </i>
                              </a>
                            Usuarios | Talentos
                        </h5>
                    </div>
                    <div class="col s4 m4 l2 rigth-align rigth-align show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li><a href="{{route('usuario.index')}}">Usuarios</a></li>
                            <li class="active">Talentos</li>
                        </ol>
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
                                        <a href="{{route('usuario.search')}}" class="waves-effect waves-light btn-large"><i class="material-icons left">add_circle</i>Nuevo Usuario</a>
                                    </div>
                                </div>
                            </div>
                            <ul class="tabs tab-demo z-depth-1" style="width: 100%;">
                              <li class="tab col s3"><a href="#historialTalento" class="active">Talentos {{config('app.name')}}</a></li>
                              <li class="tab col s3"><a href="#talentoByGestor" >Talentos por Gestor </a></li>
                              <div class="indicator" style="right: 580.5px; left: 0px;"></div>
                            </ul>

                            <div id="historialTalento">
                                <h5 class="center-align">Talentos {{config('app.name')}}</h5>
                                <div class="divider">
                            </div>
                            <div class="col s12 m12 l12">
                                <div class="input-field col s12 m12 l12">
                                    <select class="js-states"  tabindex="-1" style="width: 100%" id="anio_proyecto_talento" name="anio_proyecto_talento" onchange="user.consultarTalentosByTecnoparque();">
                                        @for ($i=2016; $i <= $year; $i++)
                                        <option value="{{$i}}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{$i}}</option>
                                        @endfor
                                    </select>
                                    <label for="anio_proyecto_talento">Seleccione el Año</label>
                                </div>
                            </div>
                            @include('users.table',['id' => 'talentoByDinamizador_table'])
                            </div>
                            <div id="talentoByGestor">
                                <h5 class="center-align">Talentos Por Gestor</h5>
                                <div class="divider"></div>
                                <div class="row">
                                    <div class="col s12 m6 l6">
                                        <div class="input-field">
                                          <select class="js-states"  tabindex="-1" style="width: 100%" id="txtanho_user_talento" name="txtanho_user_talento">
                                            @for ($i=2016; $i <= $year; $i++)
                                              <option value="{{$i}}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{$i}}</option>
                                            @endfor
                                          </select>
                                          <label for="txtanho_user_talento">Seleccione el Año</label>
                                        </div>
                                      </div>
                                      <div class="input-field col s12 m6 l6">
                                        <select class="initialized" id="txtgestor_id" name="txtgestor_id" style="width: 100%" tabindex="-1">
                                          <option value="">Seleccione un gestor del nodo * </option>
                                          @foreach($gestores as $id => $nombres_gestor)
                                            <option value="{{$id}}">{{$nombres_gestor}}</option>
                                          @endforeach
                                        </select>
                                        <label for="txtgestor_id">Gestor</label>
                                      </div>
                                </div>

                                <div class="row">
                                  <div class="col s12 m4 l4 offset-l4">
                                    <a onclick="user.getUserTalentosByGestor();" href="javascript:void(0)">
                                      <div class="card blue">
                                        <div class="card-content center flow-text">
                                          <i class="left material-icons white-text small">search</i>
                                          <span class="white-text">Consultar Talento</span>
                                        </div>
                                      </div>
                                    </a>
                                  </div>
                                  @include('users.table2')
                                </div>
                              </div>
                        </div>
                    </div>
                </div>
                <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
                    <a href="{{route('usuario.search')}}"  class="btn tooltipped btn-floating btn-large green" data-position="left" data-delay="50" data-tooltip="Nuevo Usuario">
                      <i class="material-icons">add_circle</i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>





@endsection

@push('script')
<script>
    $(document).ready(function() {

  $('#talentoByDinamizador_table').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    "lengthChange": false,
  });



});

var user = {
  consultarTalentosByTecnoparque: function (){
    let anho = $('#anio_proyecto_talento').val();

    $('#talentoByDinamizador_table').dataTable().fnDestroy();
      $('#talentoByDinamizador_table').DataTable({
        language: {
          "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false,
        processing: true,
        serverSide: true,
        order: [ 0, 'desc' ],
        ajax:{
          url: "/usuario/getuserstalentosbydatatables/"+anho,
          
        },
        columns: [{
          data: 'tipodocumento',
          name: 'tipodocumento',
      }, {
          data: 'documento',
          name: 'documento',
      }, {
          data: 'nombre',
          name: 'nombre',
      }, {
          data: 'email',
          name: 'email',
      }, {
          data: 'celular',
          name: 'celular',
      },  {
          data: 'detail',
          name: 'detail',
          orderable: false,
      },  ],
      });


  },
  getUserTalentosByGestor: function(){
    let anho = $('#txtanho_user_talento').val();
    let gestor = $('#txtgestor_id').val();

    if(gestor == '' || gestor == null){
      Swal.fire(
        'Error',
        'Por favor selecciona un gestor',
        'error'
      );
    }else if(anho == '' || anho == null){
      Swal.fire(
        'Error',
        'Por favor selecciona un gestor',
        'error'
      );
    }else{
      $('#talentoByGestor_table').dataTable().fnDestroy();
      $('#talentoByGestor_table').DataTable({
        language: {
          "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "lengthChange": false,
        processing: true,
        serverSide: true,
        order: [ 0, 'desc' ],
        ajax:{
          url: "/usuario/getuserstalentosbygestordatatables/"+gestor+"/"+anho,
          
        },
        columns: [{
          data: 'tipodocumento',
          name: 'tipodocumento',
      }, {
          data: 'documento',
          name: 'documento',
      }, {
          data: 'nombre',
          name: 'nombre',
      }, {
          data: 'email',
          name: 'email',
      }, {
          data: 'celular',
          name: 'celular',
      },  {
          data: 'detail',
          name: 'detail',
          orderable: false,
      },  ],
      });
    }


  }
}



</script>
@endpush

