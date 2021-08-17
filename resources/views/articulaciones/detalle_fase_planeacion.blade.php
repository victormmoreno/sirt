<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
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
                                            {{$articulacion->present()->articulacionPbtNodo()}}
                                        </span>
                                    </div>
                                </div>
                                <div class="right mailbox-buttons">
                                    <span class="mailbox-title">
                                        <p class="center">
                                            Información de la articulación en la fase de planeación -
                                            {{$articulacion->present()->articulacionName()}}
                                        </p>

                                    </span>
                                </div>
                            </div>
                            <div class="right">
                                <small>
                                    <b>Fecha de inicio de la articulación: </b>
                                    {{$articulacion->present()->articulacionPbtcreatedAt()}}
                                </small>
                            </div>
                            <div class="divider mailbox-divider"></div>
                            <div class="mailbox-text">
                                <div class="row">
                                    <div class="col s12 m12 l12">
                                        <div class="center">
                                            <span class="mailbox-title">
                                                <i class="material-icons">build</i>
                                                Información de la articulación
                                                {{$articulacion->present()->articulacionCode()}} -
                                                {{$articulacion->present()->articulacionName()}}
                                            </span>
                                        </div>
                                        <div class="divider mailbox-divider"></div>
                                    </div>
                                </div>
                                <div class="center">
                                    <span class="mailbox-title">
                                        <i class="material-icons">attach_file</i>
                                        Evidencias de la fase de planeación.
                                    </span>
                                </div>
                                <div class="divider mailbox-divider"></div>
                                <div class="row">
                                    <div class="col s6 m6 l6">
                                        <p class="p-v-xs">
                                            <input type="checkbox" disabled {{ $articulacion->articulacion_proyecto->actividad->cronograma == 1 ? 'checked' : '' }}
                                                id="txtcronograma" name="txtcronograma" value="1">
                                            <label for="txtcronograma">
                                                Cronograma de trabajo.
                                            </label>
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    @include('articulaciones.archivos_table_fase', ['fase' => 'planeacion'])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
