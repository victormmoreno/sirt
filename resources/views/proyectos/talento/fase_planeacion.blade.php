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
                    </a> Proyectos
                </h5>
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            @include('proyectos.navegacion_fases')
                            <div class="divider"></div>
                            <br />
                            <form action="{{route('proyecto.update.planeacion', $proyecto->id)}}" method="POST">
                                {!! method_field('PUT')!!}
                                @csrf
                                @include('proyectos.detalle_fase_planeacion')
                                <div class="divider"></div>
                                <center>
                                  @if ($proyecto->articulacion_proyecto->talentos()->wherePivot('talento_lider', 1)->first()->id == auth()->user()->talento->id)
                                  <button type="submit" value="send"
                                      {{$proyecto->fase->nombre == 'Planeación' ? '' : 'disabled'}}
                                      class="waves-effect cyan darken-1 btn center-aling">
                                      <i class="material-icons right">done</i>
                                      {{$proyecto->fase->nombre == 'Planeación' ? 'Aprobar fase de planeación' : 'El Proyecto no se encuentra en fase de Planeación'}}
                                  </button>
                                  @else
                                  <button disabled value="send" class="waves-effect cyan darken-1 btn center-aling">
                                      <i class="material-icons right">done</i>
                                      No eres el talento interlocutor de este proyecto.
                                  </button>
                                  @endif
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
    datatableArchivosDeUnProyecto_planeacion();
  });

  function changeToPlaneacion() {
    window.location.href = "{{ route('proyecto.planeacion', $proyecto->id) }}";
  }

  function changeToInicio() {
    window.location.href = "{{ route('proyecto.inicio', $proyecto->id) }}";
  }

  function changeToEjecucion() {
    window.location.href = "{{ route('proyecto.ejecucion', $proyecto->id) }}";
  }

  function changeToCierre() {
    window.location.href = "{{ route('proyecto.cierre', $proyecto->id) }}";
  }

  function datatableArchivosDeUnProyecto_planeacion() {
  $('#archivosDeUnProyecto').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: false,
    ajax:{
      url: "{{route('proyecto.files', [$proyecto->id, 'Planeación'])}}",
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