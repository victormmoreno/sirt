@extends('layouts.app')
@section('meta-title', 'Taller de fortalecimiento')
@section('content')
    <main class="mn-inner inner-active-sidebar">
        <div class="content">
            <div class="row no-m-t no-m-b">
                <div class="row">
                    <h5 class="left primary-text primary-text">
                        <a href="{{ route('taller') }}">
                            <i class="left material-icons primary-text">arrow_back</i>
                        </a> Talleres de fortalecimiento
                    </h5>
                    <div class="right right-align show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li><a href="{{ route('home') }}">Inicio</a></li>
                            <li><a href="{{ route('taller') }}">Taller de fortalecimiento</a></li>
                            <li class="active">Evidencias</li>
                        </ol>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <form onsubmit="return checkSubmit()" method="post"
                                    action="{{ route('taller.update.evidencias', $entrenamiento->id) }}">
                                    {!! method_field('PUT') !!}
                                    {!! csrf_field() !!}
                                    <div class="row">
                                        <div class="input-field col s12 m6 l6">
                                            <input id="txtcodigo_entrenamiento" required disabled
                                                value="{{ $entrenamiento->codigo_entrenamiento }}">
                                            <label for="txtcodigo_entrenamiento" class="active">Código del taller</label>
                                        </div>
                                        <div class="input-field col s12 m6 l6">
                                            <input id="txtfecha_sesion1" disabled
                                                value="{{ $entrenamiento->fecha_sesion1->toDateString() }}">
                                            <label for="txtfecha_sesion1" class="active">Fecha del taller</label>
                                        </div>
                                    </div>
                                    <div class="divider"></div>
                                    <div class="row">
                                        <div class="col s4 m4 l4">
                                            <p class="p-v-xs">
                                                <input type="checkbox" name="txtcorreos"
                                                    {{ $entrenamiento->correos == 'No' ? '' : 'checked' }} id="txtcorreos"
                                                    value="1">
                                                <label for="txtcorreos">Correos</label>
                                            </p>
                                        </div>
                                        <div class="col s4 m4 l4">
                                            <p class="p-v-xs">
                                                <input type="checkbox" name="txtfotos"
                                                    {{ $entrenamiento->fotos == 'No' ? '' : 'checked' }} id="txtfotos"
                                                    value="1">
                                                <label for="txtfotos">Fotos</label>
                                            </p>
                                        </div>
                                        <div class="col s4 m4 l4">
                                            <p class="p-v-xs">
                                                <input type="checkbox" name="txtlistado_asistencia"
                                                    {{ $entrenamiento->listado_asistencia == 'No' ? '' : 'checked' }}
                                                    id="txtlistado_asistencia" value="1">
                                                <label for="txtlistado_asistencia">Listado de Asistencia</label>
                                            </p>
                                        </div>
                                    </div>
                                    @can('upload', $entrenamiento)
                                        <div class="row">
                                            <ul class="collapsible" data-collapsible="accordion">
                                                <li>
                                                    <div class="collapsible-header teal lighten-4"><i
                                                            class="material-icons">filter_drama</i>Pulse aquí para subir los
                                                        entregables del taller de fortalecimiento</div>
                                                    <div class="collapsible-body">
                                                        <div class="row">
                                                            <div class="center col s12 m12 l12">
                                                                <h6>Pulse aquí para subir los entregables del taller de fortalecimiento.
                                                                </h6>
                                                                <div class="dropzone" id="evidencias_entrenamiento"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    @endcan
                                    <div class="divider"></div>
                                    <div class="center">
                                        <button type="submit" class="bg-secondary btn center-aling"><i
                                                class="material-icons right">send</i>Modificar</button>
                                        <a href="{{ route('taller') }}" class="bg-danger btn center-aling"><i
                                                class="material-icons left">backspace</i>Cancelar</a>
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col s12 m12 l12">
                                        <ul class="collapsible" data-collapsible="accordion">
                                            <li>
                                                <div class="collapsible-header teal lighten-4"><i
                                                        class="material-icons">filter_drama</i>Pulse aquí para ver las
                                                    evidencias del taller de fortalecimiento</div>
                                                <div class="collapsible-body">
                                                    <div class="row">
                                                        <div class="col s12 m12 l12">
                                                            <table
                                                                class="display responsive-table datatable-example dataTable"
                                                                style="width: 100%" id="archivosDeUnEntrenamiento">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Archivo</th>
                                                                        <th style="width: 10%">Descargar</th>
                                                                        <th style="width: 10%">Eliminar</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
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
        datatableArchivosDeUnEntrenamiento();

        function datatableArchivosDeUnEntrenamiento() {
            $('#archivosDeUnEntrenamiento').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                order: false,
                ajax: {
                    url: host_url + "/taller/datatableArchivosDeUnEntrenamiento/" + {{ $entrenamiento->id }},
                    type: "get",
                },
                columns: [{
                        data: 'file',
                        name: 'file',
                        orderable: false,
                    },
                    {
                        data: 'download',
                        name: 'download',
                        orderable: false,
                    },
                    {
                        data: 'delete',
                        name: 'delete',
                        orderable: false,
                    }
                ],
                initComplete: function() {
                    this.api().columns().every(function() {
                        var column = this;
                        var input = document.createElement("input");
                        $(input).appendTo($(column.footer()).empty())
                            .on('change', function() {
                                column.search($(this).val(), false, false, true).draw();
                            });
                    });
                }
            });
        }

        var DropzoneEntrenamiento = new Dropzone('#evidencias_entrenamiento', {
            url: host_url + '/taller/store/' + {{ $entrenamiento->id }} + '/files',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            dictDefaultMessage: 'Arrastra los archivos aquí para subirlos.',
            params: {
                fase: 'Inscrito'
            },
            paramName: 'nombreArchivo'
        });

        DropzoneEntrenamiento.on('success', function(res) {
            $('#archivosDeUnEntrenamiento').dataTable().fnDestroy();
            datatableArchivosDeUnEntrenamiento();
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                icon: 'success',
                title: 'El archivo se ha subido con éxito!'
            });
        })

        DropzoneEntrenamiento.on('error', function(file, res) {
            var msg = res.errors.nombreArchivo[0];
            $('.dz-error-message:last > span').text(msg);
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                icon: 'error',
                title: 'El archivo no se ha podido subir!'
            });
        })
        Dropzone.autoDiscover = false;
    </script>
@endpush
