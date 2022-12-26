@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
            <h5>
            <a class="footer-text left-align" href="{{route('proyecto.ejecucion', $proyecto->id)}}">
                <i class="material-icons arrow-l left">arrow_back</i>
            </a> Proyectos de Base Tecnológica
            </h5>
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        @include('proyectos.titulo')
                        <form method="POST" action="{{route('proyecto.update.ejecucion', $proyecto->id)}}">
                            @include('proyectos.gestor.forms.form_ejecucion')
                            @include('proyectos.archivos_table_fase', ['fase' => 'ejecucion'])
                            <center>
                            <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done</i>Modificar</button>
                            <a href="{{ route('proyecto.ejecucion', $proyecto->id) }}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
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
    datatableArchivosDeUnProyecto_ejecucion();

    var Dropzone = new Dropzone('#fase_ejecucion_proyecto', {
        url: '{{ route('proyecto.files.upload', $proyecto->id) }}',
        headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        dictDefaultMessage: 'Arrastra los archivos aquí para subirlos.',
        params: {
        fase: 'Ejecución'
        },
        paramName: 'nombreArchivo'
    });

    Dropzone.on('success', function (res) {
        $('#archivosDeUnProyecto').dataTable().fnDestroy();
        datatableArchivosDeUnProyecto_ejecucion();
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
    function datatableArchivosDeUnProyecto_ejecucion() {
        $('#archivosDeUnProyecto').DataTable({
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
            @if ($proyecto->present()->proyectoFase() == 'Ejecución')
            {
                data: 'delete',
                name: 'delete',
                orderable: false,
            },
            @endif
            ],
        });
    }
</script>
@endpush
