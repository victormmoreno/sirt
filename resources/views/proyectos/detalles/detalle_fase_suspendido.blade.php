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
                                        <i class="material-icons fas fa-building primary-text"></i>
                                    </div>
                                    <div class="left">
                                        <span class="mailbox-title primary-text">{{$proyecto->present()->proyectoNode()}}</span>
                                    </div>
                                </div>
                                <div class="right mailbox-buttons">
                                    <span class="mailbox-title">
                                        <p class="center secondary-text">
                                            Información de Proyecto en la fase de suspendido -
                                            {{$proyecto->articulacion_proyecto->actividad->present()->actividadName()}}
                                        </p>
                                        <br />
                                        <p class="center">Linea Tecnológica:
                                            {{$proyecto->present()->proyectoAbreviaturaLinea()}} -
                                            {{$proyecto->present()->proyectoLinea()}}
                                        </p>
                                    </span>
                                </div>
                            </div>
                            <div class="right">
                                <small class="secondary-text">
                                    <b>Fecha de inicio del proyecto: </b>
                                    {{$proyecto->articulacion_proyecto->actividad->present()->actividadcreatedAt()}}
                                </small>
                            </div>
                            <div class="divider mailbox-divider"></div>
                            <div class="mailbox-text">
                                <div class="row">
                                    <div class="col s12 m12 l12">
                                        <div class="center">
                                            <span class="mailbox-title primary-text">
                                                Información del Proyecto
                                                {{$proyecto->articulacion_proyecto->actividad->present()->actividadCode()}} -
                                                {{$proyecto->articulacion_proyecto->actividad->present()->actividadName()}}
                                            </span>
                                        </div>
                                        <div class="divider mailbox-divider"></div>
                                    </div>
                                </div>
                                <div class="center">
                                    <span class="mailbox-title primary-text">
                                        <i class="material-icons">attach_file</i>
                                        Evidencias de la fase de suspendido.
                                    </span>
                                </div>
                                <div class="divider mailbox-divider"></div>
                                <div class="row">
                                    @include('proyectos.archivos_table_fase', ['fase' => 'Concluido sin finalizar'])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
