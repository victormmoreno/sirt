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
          </a> Proyectos de Base Tecnologica
        </h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
                <div class="col s12">
                  <ul class="tabs">
                    <li class="tab col s3"><a class="active" href="#inicio">Inicio</a></li>
                    <li class="tab col s3"><a href="#planeacion">Planeación</a></li>
                    <li class="tab col s3"><a href="#ejecucion">Ejecución</a></li>
                    <li class="tab col s3"><a href="#cierre">Cierre</a></li>
                  </ul>
                  <div class="divider"></div>
                </div>
                <div class="col s12 m12 l12">
                    @include('proyectos.historial_cambios')
                </div>
                <div class="col s12 m12 l12">
                    @if ($proyecto->fase->nombre == 'Cierre' || $proyecto->fase->nombre == 'Suspendido')
                        @if(Session::get('login_role') == App\User::IsAdministrador())
                        <div class="col s12 m3 l3">
                            <form action="{{route('proyecto.reversar', [$proyecto->id, 'Inicio'])}}" method="POST" name="frmReversarFase">
                                {!! method_field('PUT')!!}
                                @csrf
                                <button type="submit" onclick="preguntaReversar(event)" value="send" class="btn-flat">
                                    Reversar fase del proyecto a Inicio.
                                </button>
                            </form>
                        </div>
                        <div class="col s12 m3 l3">
                            <form action="{{route('proyecto.reversar', [$proyecto->id, 'Planeación'])}}" method="POST" name="frmReversarFasePlaneacion">
                                {!! method_field('PUT')!!}
                                @csrf
                                <button type="submit" onclick="preguntaReversarPlaneacion(event)" value="send" class="btn-flat">
                                    Reversar fase del proyecto a Planeación.
                                </button>
                            </form>
                        </div>
                        <div class="col s12 m3 l3">
                            <form action="{{route('proyecto.reversar', [$proyecto->id, 'Ejecución'])}}" method="POST" name="frmReversarFaseEjecucion">
                                {!! method_field('PUT')!!}
                                @csrf
                                <button type="submit" onclick="preguntaReversarEjecucion(event)" value="send" class="btn-flat">
                                    Reversar fase del proyecto a Ejecución.
                                </button>
                            </form>
                        </div>
                        @endif
                    @endif
                </div>
                <div id="inicio" class="col s12 m12 l12">
                    @include('proyectos.detalle_fase_inicio')
                </div>
                <div id="planeacion" class="col s12 m12 l12">
                    @include('proyectos.detalle_fase_planeacion')
                </div>
                <div id="ejecucion" class="col s12 m12 l12">
                    @include('proyectos.detalle_fase_ejecucion')
                </div>
                <div id="cierre" class="col s12 m12 l12">
                    @include('proyectos.detalle_fase_cierre')
                </div>
                <center>
                    <a href="{{route('proyecto')}}" class="waves-effect red lighten-2 btn center">
                        <i class="material-icons right">backspace</i>Volver
                    </a>
                </center>
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
    datatableArchivosDeUnProyecto_inicio();
    datatableArchivosDeUnProyecto_planeacion();
    datatableArchivosDeUnProyecto_ejecucion();
    datatableArchivosDeUnProyecto_cierre();
    function datatableArchivosDeUnProyecto_inicio() {
        $('.inicio').DataTable({
            language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            order: false,
            ajax:{
            url: "{{route('proyecto.files', [$proyecto->id, 'Inicio'])}}",
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
    function datatableArchivosDeUnProyecto_planeacion() {
        $('.planeacion').DataTable({
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
    function datatableArchivosDeUnProyecto_ejecucion() {
        $('.ejecucion').DataTable({
            language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            order: false,
            ajax:{
            url: "{{route('proyecto.files', [$proyecto->id, 'Ejecución'])}}",
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
    function datatableArchivosDeUnProyecto_cierre() {
        $('.cierre').DataTable({
            language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            order: false,
            ajax:{
            url: "{{route('proyecto.files', [$proyecto->id, 'Cierre'])}}",
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