@extends('layouts.app')
@section('meta-title', 'Articulaciones G.I')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5>
          <a class="footer-text left-align" href="{{route('articulacion')}}">
            <i class="material-icons arrow-l left">arrow_back</i>
          </a> Articulaciones con Grupos de Investigación
        </h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              @include('articulaciones.navegacion_fases')
              <div class="divider"></div>
              <br />
              <form action="{{route('articulacion.update.suspendido', $articulacion->id)}}" method="POST" name="frmSuspendidoDinamizador">
                {!! method_field('PUT')!!}
                @csrf
                @include('articulaciones.detalle_fase_suspendido')
                <div class="divider"></div>
                <center>
                  <button type="submit" onclick="preguntaSuspendido(event)" value="send" {{$articulacion->articulacion_proyecto->aprobacion_dinamizador_suspendido == 0 ? '' : 'disabled'}}
                    class="waves-effect cyan darken-1 btn center-aling">
                    <i class="material-icons right">done</i>
                    {{$articulacion->articulacion_proyecto->aprobacion_dinamizador_suspendido == 0 ? 'Aprobar suspensión de la articulación' : 'Esta articulación ya se ha suspendido'}}
                  </button>
                  <a href="{{route('articulacion')}}" class="waves-effect red lighten-2 btn center-aling">
                    <i class="material-icons right">backspace</i>Cancelar
                  </a>
                </center>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection
@push('script')
    <script>
          $( document ).ready(function() {
    datatableArchivosDeUnaArticulacion_suspendido();
  });

  function preguntaSuspendido(e){
    e.preventDefault();
    Swal.fire({
    title: '¿Está seguro(a) de aprobar la suspensión de esta articulación?',
    // text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Sí!'
    }).then((result) => {
      if (result.value) {
        document.frmSuspendidoDinamizador.submit();
      }
    })
  }
  function datatableArchivosDeUnaArticulacion_suspendido() {
  $('#archivosDeUnaArticulacion').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: false,
    ajax:{
      url: "{{route('articulacion.files', [$articulacion->id, 'Suspendido'])}}",
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