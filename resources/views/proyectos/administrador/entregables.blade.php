    @extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
    <main class="mn-inner inner-active-sidebar">
        <div class="content">
            <div class="row no-m-t no-m-b m-r-lg m-l-lg">
                <div class="left left-align">
                    <h5 class="left-align primary-text">
                        <a class="footer-text left-align" href="{{route('proyecto')}}">
                            <i class="material-icons arrow-l">arrow_back</i>
                        </a>Proyectos de Base Tecnológica
                    </h5>
                </div>
                <div class="right right-align show-on-large hide-on-med-and-down">
                    <ol class="breadcrumbs">
                        <li><a href="{{ route('home') }}">Inicio</a></li>
                        <li><a href="{{route('proyecto')}}">Proyectos</a></li>
                        <li class="active">Entregables</li>
                    </ol>
                </div>
            </div>
            <div class="row no-m-t no-m-b">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s12 m12 l12">
                                @include('proyectos.form_entregables')
                                @include('proyectos.archivos_table')
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
        datatableArchivosDeUnProyecto();
        function datatableArchivosDeUnProyecto() {
            $('#archivosDeUnProyecto').DataTable({
                language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                order: false,
                ajax:{
                    url: "{{route('proyecto.files', $proyecto->id)}}",
                    type: "get",
                },
                columns: [
                {
                    data: 'file',
                    name: 'file',
                    orderable: false,
                },
                {
                    data: 'fase',
                    name: 'fase',
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
