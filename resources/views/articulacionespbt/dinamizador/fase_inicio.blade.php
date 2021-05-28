@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')


<main class="mn-inner">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s8 m8 l5">
            <h5 class="left-align orange-text text-darken-3">
                <i class="material-icons left">
                  autorenew
                </i>
                Articulaciones PBT
            </h5>
        </div>
        <div class="col s4 m4 l5 offset-l2  rigth-align show-on-large hide-on-med-and-down">
            <ol class="breadcrumbs">
                <li><a href="{{route('home')}}">Inicio</a></li>
                <li ><a href="{{route('articulaciones.index')}}">Articulaciones PBT</a></li>
                <li ><a href="{{route('articulaciones.show', $actividad->articulacionpbt->id)}}">detalle</a></li>
                <li class="active">Inicio</li>
            </ol>
        </div>
    </div>
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12 no-p-h">
            <div class="card mailbox-content">
                <div class="card-content">
                    <div class="row no-m-t no-m-b">
                        <div class="col s12 m12 l12">
                            <div class="mailbox-options">
                              <ul>
                                <li class="text-mailbox active">Inicio</li>
                                <li class="text-mailbox">Ejecución</li>
                                <li class="text-mailbox">Cierre</li>
                                <div class="right">
                                    <li class="text-mailbox "> Fase actual: {{$actividad->articulacionpbt->present()->articulacionPbtNameFase()}}</li>
                                    <li class="text-mailbox">Fecha Inicio: {{$actividad->present()->startDate()}}</li>   
                                </div>
                            </ul>
                            </div>
                            <div class="mailbox-view no-s">
                                <div class="mailbox-view-header no-m-b no-m-t">
                                    <div class="right mailbox-buttons no-s">
                                      @if ($actividad->articulacionpbt->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio()))
                                        @if ($ultimo_movimiento != null && $ultimo_movimiento->role->name == App\User::IsTalento() && $ultimo_movimiento->movimiento->movimiento == App\Models\Movimiento::IsAprobar())
                                          <form action="{{route('articulacion.aprobacion', [$actividad->articulacionpbt->id, 'Inicio'])}}" method="POST" name="frmInicioDinamizador">
                                              {!! method_field('PUT')!!}
                                              @csrf
                                              <input type="hidden" type="text" name="motivosNoAprueba" id="motivosNoAprueba">
                                              <input type="hidden" type="text" name="decision" id="decision">
                                              <button type="submit" onclick="preguntaInicio(event)" class="waves-effect deep-orange darken-1 btn center-aling">
                                                <i class="material-icons right">done</i>
                                                Aprobar fase de inicio
                                              </button>
                                              <button type="submit" onclick="preguntaInicioRechazar(event)" class="waves-effect  btn center-aling">
                                                <i class="material-icons right">close</i>
                                                No aprobar la fase de Inicio
                                              </button>
                                            </form>
                                          @endif
                                      @endif
                                    </div>
                                </div>
                                <div class="mailbox-view-header">
                                    <div class="left">
                                        <span class="mailbox-title p-v-lg">{{$actividad->present()->actividadCode()}} - {{$actividad->present()->actividadName()}}</span>
                                        
                                        <div class="left">
                                            <span class="mailbox-title">{{$actividad->present()->actividadUserAsesor()}}</span>
                                            <span class="mailbox-author">{{$actividad->present()->actividadUserRolesAsesor()}} </span>
                                        </div>
                                    </div>
                                    <div class="right mailbox-buttons p-v-lg">
                                        <div class="right">
                                            <span class="mailbox-title">{{$actividad->present()->actividadNode()}}</span>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="divider mailbox-divider"></div>
                               
                                <div class="mailbox-text">
                                    <div class="row">
                                        <div class="col s12">
                                            @include('articulacionespbt.history-change')
                                        </div>
                                        @include('articulacionespbt.detail.detail-fase-inicio')
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
  
  @include('ideas.modals')
</main>
@endsection
@push('script')
<script>

datatableArchiveArticulacion_inicio();
  function preguntaInicioRechazar(e){
    e.preventDefault();
    Swal.fire({
    title: '¿Está seguro(a) de no aprobar la fase de inicio de esta articulación?',
    input: 'text',
    type: 'warning',
    inputValidator: (value) => {
      if (!value) {
        return 'Las observaciones deben ser obligatorias!'
      } else {
        $('#decision').val('rechazado');
        $('#motivosNoAprueba').val(value);
      }
    },
    inputAttributes: {
      maxlength: 100
    },
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Enviar observaciones!'
    }).then((result) => {
      if (result.value) {
        document.frmInicioDinamizador.submit();
      }
    })
  }

  function preguntaInicio(e){
    e.preventDefault();
    Swal.fire({
    title: '¿Está seguro(a) de aprobar la fase de inicio de esta articulación?',
    // text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Sí!'
    }).then((result) => {
      if (result.value) {
        $('#decision').val('aceptado');
        document.frmInicioDinamizador.submit();
      }
    })
  }
  


  function changeToInicio() {
    window.location.href = "{{ route('articulacion.inicio', $actividad->articulacionpbt->id) }}";
  }



  function datatableArchiveArticulacion_inicio() {
  $('#archivosArticulacion').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: false,
    ajax:{
        url: "{{route('articulacion.files', [$actividad->articulacionpbt->id, 'Inicio'])}}",
        type: "get",
    },
    columns: [
      {
        data: 'file',
        name: 'file',
        orderable: false,
      },
      {
        data: 'download',
        name: 'download',
        orderable: false,
      },
    ],
  });
}
</script>
@endpush