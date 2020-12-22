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
                                            Tecnoparque nodo
                                            {{$articulacion->articulacion_proyecto->actividad->nodo->entidad->nombre}}
                                        </span>
                                    </div>
                                </div>
                                <div class="right mailbox-buttons">
                                    <span class="mailbox-title">
                                        <p class="center">
                                            Información de la articulación en la fase de planeación -
                                            {{$articulacion->articulacion_proyecto->actividad->nombre}}
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
                                                    @if ($articulacion->fase->nombre == 'Cierre' || $articulacion->fase->nombre == 'Suspendido')
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            Fecha de cierre de la articulación
                                                        </span>
                                                        <p>
                                                            {{$articulacion->articulacion_proyecto->actividad->fecha_cierre->isoFormat('YYYY-MM-DD')}}
                                                        </p>
                                                    </li>
                                                    @endif
                                                </ul>
                                            </div>
                                            <div class="col s12 m4 l4">
                                                <ul class="collection">
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            Costo aproximado de la articulación
                                                        </span>
                                                        <p>
                                                            $ {{$costo->getData()->costosTotales}}
                                                        </p>
                                                    </li>
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            Conclusiones
                                                        </span>
                                                        <p>
                                                            {{$articulacion->articulacion_proyecto->actividad->conclusiones}}
                                                        </p>
                                                    </li>
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            Siguientes investigaciones o proyectos de la articulación
                                                        </span>
                                                        <p>
                                                            {{$articulacion->siguientes_investigaciones}}
                                                        </p>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col s12 m4 l4">
                                                <ul class="collection with-header">
                                                    <li class="collection-header"><h5 class="title cyan-text text-darken-3">Productos alcanzados</h5></li>
                                                    @foreach ($articulacion->productos as $item)
                                                    <li class="collection-item">
                                                        <p>
                                                            {{$item->nombre}}
                                                        </p>
                                                        <span class="title cyan-text text-darken-3">
                                                            ¿Se cumplió?
                                                        </span>
                                                        <p>
                                                            {{$item->pivot->logrado == 0 ? 'NO' : 'SI'}}
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
                                        <i class="material-icons">attach_file</i>
                                        Evidencias de la fase de cierre.
                                    </span>
                                </div>
                                <div class="divider mailbox-divider"></div>
                                <div class="row">
                                    <div class="col s6 m6 l6">
                                        <p class="p-v-xs">
                                            <input type="checkbox" disabled {{ $articulacion->informe_final == 1 ? 'checked' : '' }} id="txtinforme_final" name="txtinforme_final" value="1">
                                            <label for="txtinforme_final">Evidencias (en un solo archivo).</label>
                                        </p>
                                    </div>
                                    <div class="col s6 m6 l6">
                                        <p class="p-v-xs">
                                            <input type="checkbox" disabled {{ $articulacion->articulacion_proyecto->actividad->formulario_final == 1 ? 'checked' : '' }} id="txtformulario_final" name="txtformulario_final" value="1">
                                            <label for="txtformulario_final">Formularios con firmas del gestor y talentos.</label>
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    @include('articulaciones.archivos_table_fase', ['fase' => 'cierre'])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>