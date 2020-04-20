<div class="row">
    <div class="col s12 m12 l12">
        <div class="card mailbox-content">
            <div class="card-content">
                <div class="row no-m-t no-m-b">
                    <div class="col s12 m12 l12">
                        <div class="mailbox-view">
                            <div class="mailbox-view-header">
                                <div class="left">
                                    <div class="left">
                                        <i class="material-icons fas fa-building"></i>
                                    </div>
                                    <div class="left">
                                        <span class="mailbox-title">
                                            Tecnoparque nodo
                                            {{$articulacion->articulacion_proyecto->actividad->nodo->entidad->nombre}}
                                        </span>
                                    </div>
                                </div>
                                <div class="right mailbox-buttons">
                                    <span class="mailbox-title">
                                        <p class="center">
                                            Información de la articulación en la fase de suspendido -
                                            {{$articulacion->articulacion_proyecto->actividad->nombre}}
                                        </p>
                                        <br />
                                        <p class="center">Linea Tecnológica:
                                            {{ $articulacion->articulacion_proyecto->actividad->gestor->user->nombres }} - {{ $articulacion->articulacion_proyecto->actividad->gestor->user->apellidos }}
                                        </p>
                                    </span>
                                </div>
                            </div>
                            <div class="right">
                                <small>
                                    <b>Fecha de inicio de la articulación: </b>
                                    {{optional($articulacion->articulacion_proyecto->actividad->created_at)->isoFormat('LL')}}
                                </small>
                            </div>
                            <div class="divider mailbox-divider">
                            </div>
                            <div class="mailbox-text">
                                <div class="row">
                                    <div class="col s12 m12 l12">
                                        <div class="center">
                                            <span class="mailbox-title">
                                                <i class="material-icons">build</i>
                                                Información de la articulación
                                                {{$articulacion->articulacion_proyecto->actividad->codigo_actividad}} -
                                                {{$articulacion->articulacion_proyecto->actividad->nombre}}
                                            </span>
                                        </div>
                                        <div class="divider mailbox-divider"></div>
                                    </div>
                                </div>
                                <div class="center">
                                    <span class="mailbox-title">
                                        <i class="material-icons">attach_file</i>
                                        Evidencias de la fase de suspendido.
                                    </span>
                                </div>
                                <div class="divider mailbox-divider"></div>
                                <div class="row">
                                    @include('articulaciones.archivos_table_fase', ['fase' => 'suspendido'])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>