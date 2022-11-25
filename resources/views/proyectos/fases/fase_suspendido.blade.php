@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
            <h5 class="primary-text">
            <a class="footer-text left-align" href="{{route('proyecto.inicio', $proyecto)}}">
                <i class="material-icons arrow-l left primary-text">arrow_back</i>
            </a> Proyectos de Base Tecnológica
            </h5>
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        @include('proyectos.titulo')
                        @include('proyectos.navegacion')
                        @include('proyectos.historial_cambios')
                        @include('proyectos.options.options')
                        @include('proyectos.detalles.detalle_general')
                        @include('proyectos.forms.form_suspendido')
                        @include('proyectos.detalles.detalle_fase_suspendido')
                        @can('aprobar_suspendido', $proyecto)
                            <form action="{{route('proyecto.update.suspendido', [$proyecto->id])}}" method="POST" name="frmAprobacionProyecto">
                                {!! method_field('PUT')!!}
                                @csrf
                                <div class="divider"></div>
                                <div class="center-align">
                                    @include('proyectos.botones_aprobacion_component')
                                    <a href="{{route('proyecto')}}" class="waves-effect bg-danger btn center-aling">
                                        <i class="material-icons right">backspace</i>Cancelar
                                    </a>
                                </div>
                            </form>
                        @endcan
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
    datatableArchivosDeUnProyecto_suspendido();
    var Dropzone = new Dropzone('#fase_suspendido_proyecto', {
        url: '{{ route('proyecto.files.upload', $proyecto->id) }}',
        headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        dictDefaultMessage: 'Arrastra los archivos aquí para subirlos.',
        params: {
        fase: 'Suspendido'
        },
        paramName: 'nombreArchivo'
    });

    function preguntaSuspender(e){
    e.preventDefault();
        Swal.fire({
            title: '¿Está seguro(a) de suspender este proyecto?',
            text: "No podrás revertir esta acción!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Sí!'
        }).then((result) => {
            if (result.value) {
                document.frmSuspenderProyectoGestor.submit();
            }
        })
    }

    Dropzone.on('success', function (res) {
        $('#archivosDeUnProyecto').dataTable().fnDestroy();
        datatableArchivosDeUnProyecto_suspendido();
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
            @if ($proyecto->present()->isAprobacionDinamizadorSuspender() == 0)
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
