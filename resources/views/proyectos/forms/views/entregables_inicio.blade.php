@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
        <h5 class="primary-text">
            <a class="footer-text left-align" href="{{ route('proyecto.inicio', $proyecto->id) }}">
            <i class="left material-icons">arrow_back</i>
            </a> Proyectos de Desarrollo Tecnológico
        </h5>
        <div class="card">
            <div class="card-content">
            <div class="row">
                <h5 class="center">Entregables de la fase de inicio.</h5>
            </div>
            <div class="row">
                <div class="col s12 m12 l12">
                <form action="{{route('proyecto.update.entregables.inicio', $proyecto->id)}}" method="POST" onsubmit="return checkSubmit()">
                    @include('proyectos.forms.entregables.inicio')
                    @include('proyectos.archivos_table_fase', ['fase' => 'inicio'])
                    <div class="divider"></div>
                    <div class="center">
                        <button type="submit" class="waves-effect bg-secondary btn center-aling"><i class="material-icons right">send</i>Modificar</button>
                        <a href="{{ route('proyecto.inicio', $proyecto->id) }}" class="waves-effect bg-danger btn center-align"><i class="material-icons left">backspace</i>Cancelar</a>
                    </div>
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
    datatableArchivosDeUnProyecto_inicio();
    var Dropzone = new Dropzone('#fase_inicio_proyecto', {
        url: '{{ route('proyecto.files.upload', $proyecto->id) }}',
        headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        dictDefaultMessage: 'Arrastra los archivos aquí para subirlos.',
        params: {
        fase: 'Inicio'
        },
        paramName: 'nombreArchivo'
    });

    Dropzone.on('success', function (res) {
        $('#archivosDeUnProyecto').dataTable().fnDestroy();
        datatableArchivosDeUnProyecto_inicio();
        Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        type: 'success',
        title: 'El archivo se ha subido con éxito!'
        });
    })

    Dropzone.on('error', function (file, res) {
        var msg = res.errors.nombreArchivo[0];
        $('.dz-error-message:last > span').text(msg);
        Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        type: 'error',
        title: 'El archivo no se ha podido subir!'
        });
    })
    Dropzone.autoDiscover = false;

    function datatableArchivosDeUnProyecto_inicio() {
        $('#archivosDeUnProyecto').DataTable({
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
            @can('delete_files', [$proyecto, $proyecto->IsInicio()])
            {
                data: 'delete',
                name: 'delete',
                orderable: false,
            },
            @endcan
            ],
        });
    }
</script>
@endpush
