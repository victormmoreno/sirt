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
                                            Tecnoparque nodo {{$articulacion->articulacion_proyecto->actividad->nodo->entidad->nombre}}
                                        </span>
                                    </div>
                                </div>
                                <div class="right mailbox-buttons">
                                    <span class="mailbox-title">
                                        <p class="center">
                                            Información de la articulación en la fase de inicio - {{$articulacion->articulacion_proyecto->actividad->nombre}} 
                                        </p>
                                        <br />
                                        <p class="center">Linea Tecnológica:
                                            {{$articulacion->articulacion_proyecto->actividad->gestor->lineatecnologica->abreviatura}} - {{$articulacion->articulacion_proyecto->actividad->gestor->lineatecnologica->nombre}}
                                        </p>
                                    </span>
                                </div>
                            </div>
                            <div class="right">
                                <small>
                                    <b>Fecha de inicio del proyecto: </b>
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
                                                {{$articulacion->articulacion_proyecto->actividad->codigo_actividad}} - {{$articulacion->articulacion_proyecto->actividad->nombre}}
                                            </span>
                                        </div>
                                        <div class="divider mailbox-divider"></div>
                                        <div class="row">
                                            <div class="col s12 m4 l4">
                                                <ul class="collection">
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            Código de la articulación
                                                        </span>
                                                        <p>
                                                            {{$articulacion->articulacion_proyecto->actividad->codigo_actividad}}
                                                        </p>
                                                    </li>
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            Nombre de la articulación
                                                        </span>
                                                        <p>
                                                            {{$articulacion->articulacion_proyecto->actividad->nombre}}
                                                        </p>
                                                    </li>
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            Grupo de Investigación
                                                        </span>
                                                        <p>
                                                            {{$articulacion->articulacion_proyecto->entidad->nombre}}
                                                        </p>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col s12 m4 l4">
                                                <ul class="collection">
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            Acuerdos de coautoría
                                                        </span>
                                                        <p>
                                                            {{$articulacion->acuerdos}}
                                                        </p>
                                                    </li>
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            Alcance del Proyecto
                                                        </span>
                                                        <p>
                                                            {{$articulacion->alcance_articulacion}}
                                                        </p>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col s12 m4 l4">
                                                <ul class="collection with-header">
                                                    <li class="collection-header">
                                                        <h5 class="cyan-text text-darken-3">Productos a alcanzar</h5>
                                                    </li>
                                                    @foreach ($articulacion->productos as $item)
                                                        <li class="collection-item">
                                                            <p>
                                                                {{$item->nombre}}
                                                            </p>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="divider mailbox-divider"></div>
                                <div class="center">
                                    <span class="mailbox-title">
                                        <i class="material-icons">group</i>
                                        Talentos que participan la articulación.
                                    </span>
                                </div>
                                <div class="divider mailbox-divider"></div>
                                <div class="row">
                                    <div class="col s12 m6 l6 offset-l3 offset-m3">
                                        <div class="card-panel blue lighten-5">
                                            <h5 class="center">Talentos que participan en la articulación</h5>
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10%">Talento Interlocutor</th>
                                                        <th style="width: 90%">Talento</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($articulacion->articulacion_proyecto->talentos as $key => $value)
                                                        <tr>
                                                        <td>{{$value->pivot->talento_lider == 1 ? 'SI' : 'NO'}}</td>
                                                        <td>{{$value->user()->withTrashed()->first()->documento}} - {{$value->user()->withTrashed()->first()->nombres}} {{$value->user()->withTrashed()->first()->apellidos}}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="divider mailbox-divider"></div>
                                <div class="center">
                                    <span class="mailbox-title">
                                        <i class="material-icons">attach_file</i>
                                        Evidencias de la fase de inicio.
                                    </span>
                                </div>
                                <div class="divider mailbox-divider"></div>
                                <div class="row">
                                    <div class="col s6 m6 l6">
                                        <p class="p-v-xs">
                                            <input type="checkbox" disabled {{ $articulacion->acc == 1 ? 'checked' : '' }} id="txtacc" name="txtacc" value="1">
                                            <label for="txtacc">Formato de confidencialidad y compromiso firmado.</label>
                                        </p>
                                    </div>
                                    <div class="col s6 m6 l6">
                                        <p class="p-v-xs">
                                            <input type="checkbox" disabled {{ $articulacion->articulacion_proyecto->actividad->formulario_inicio == 1 ? 'checked' : '' }} id="txtformulario_inicio" name="txtformulario_inicio" value="1">
                                            <label for="txtformulario_inicio">Formularios con firmas del gestor y talentos.</label>
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    @include('articulaciones.archivos_table_fase', ['fase' => 'inicio'])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>