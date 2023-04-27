@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
            <h5 class="primary-text">
            <a class="footer-text left-align" href="{{route('proyecto')}}">
                <i class="material-icons arrow-l left">arrow_back</i>
            </a> Proyectos de Base Tecnológica
            </h5>
            <div class="card">
            <div class="card-content">
                <div class="row">
                    @include('proyectos.titulo')
                    <form id="frmProyectos_FasePlaneacion_Update" action="{{route('proyecto.update.planeacion', $proyecto->id)}}" method="POST">
                        {!! method_field('PUT')!!}
                        @include('proyectos.forms.form_planeacion')
                        @include('proyectos.archivos_table_fase', ['fase' => 'planeacion'])
                        <div class="center">
                            @if ($proyecto->present()->proyectoFase() == 'Planeación')
                            <button type="submit" class="waves-effect bg-secondary btn center-aling">
                                <i class="material-icons right">send</i>
                                Modificar
                            </button>
                            @endif
                            <a href="{{route('proyecto.planeacion', $proyecto->id)}}" class="waves-effect bg-danger btn center-aling">
                                <i class="material-icons left">backspace</i>Cancelar
                            </a>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>

        </div>
    </div>
</main>
@include('proyectos.modals')
@endsection
@push('script')
<script>
    datatableArchivosDeUnProyecto_planeacion();
    var Dropzone = new Dropzone('#fase_planeacion_proyecto', {
        url: '{{ route('proyecto.files.upload', $proyecto->id) }}',
        headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        dictDefaultMessage: 'Arrastra los archivos aquí para subirlos.',
        params: {
        fase: 'Planeación'
        },
        paramName: 'nombreArchivo'
    });

    Dropzone.on('success', function (res) {
        $('#archivosDeUnProyecto').dataTable().fnDestroy();
        datatableArchivosDeUnProyecto_planeacion();
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
            @if (($proyecto->fase->nombre == 'Planeación' || $proyecto->fase->nombre == 'Finalizado') || session()->get('login_role') == App\User::IsAdministrador())
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
