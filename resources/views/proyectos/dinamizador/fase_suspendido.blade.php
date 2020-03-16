@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5>
          <a class="footer-text left-align" href="{{route('proyecto')}}">
            <i class="material-icons arrow-l left">arrow_back</i>
          </a> Proyectos de Base Tecnológica
        </h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              @include('proyectos.navegacion_fases')
              <div class="divider"></div>
              <br />
              <form action="{{route('proyecto.update.suspendido', $proyecto->id)}}" method="POST" name="frmSuspendidoDinamizador">
                {!! method_field('PUT')!!}
                @csrf
                @include('proyectos.detalle_fase_suspendido')
                <div class="divider"></div>
                <center>
                  <button type="submit" onclick="preguntaSuspendido(event)" value="send" {{$proyecto->articulacion_proyecto->aprobacion_dinamizador_suspendido == 0 ? '' : 'disabled'}}
                    class="waves-effect cyan darken-1 btn center-aling">
                    <i class="material-icons right">done</i>
                    {{$proyecto->articulacion_proyecto->aprobacion_dinamizador_suspendido == 0 ? 'Aprobar suspensión del proyecto' : 'Este proyecto ya se ha suspendido'}}
                  </button>
                  <a href="{{route('proyecto')}}" class="waves-effect red lighten-2 btn center-aling">
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
    datatableArchivosDeUnProyecto_suspendido();
  });

  function preguntaSuspendido(e){
    e.preventDefault();
    Swal.fire({
    title: '¿Está seguro(a) de aprobar la suspensión de este proyecto?',
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
  function datatableArchivosDeUnProyecto_suspendido() {
  $('#archivosDeUnProyecto').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: false,
    ajax:{
      url: "{{route('proyecto.files', [$proyecto->id, 'Suspendido'])}}",
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