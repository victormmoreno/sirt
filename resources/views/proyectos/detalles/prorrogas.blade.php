@if (isset($proyecto->prorrogas()->get()->last()->fecha_ejecucion))
    <div class="row col s12 m12 l12 orange lighten-2">
        <ul class="collection">
            <li class="collection-item">
                <span class="title secondary-text">
                    Fecha estimada para terminar la fase de ejecución del proyecto.
                </span>
                <p>
                    {{$proyecto->prorrogas()->get()->last()->fecha_ejecucion}}
                </p>
                <p>
                    {{$proyecto->prorrogas()->get()->last()->justificacion}}
                </p>
                @if ($proyecto->prorrogas()->get()->count() > 1)
                    <a href="#prorrogasProyecto_modal" class="modal-trigger">
                        Este proyecto registra {{$proyecto->prorrogas()->get()->count()}} veces en las que se ha extendido su fecha de ejecución
                    </a>
                @endif
            </li>
        </ul>
    </div>
    <div id="prorrogasProyecto_modal" class="modal modal-fixed-footer">
        <div class="modal-content">
            <center>
                <h4 class="center-aling">Veces que el proyecto ha extendido la fecha para terminar la fase de ejecución</h4>
            </center>
            <div class="divider"></div>
            <div>
                <ul class="collection">
                @foreach ($proyecto->prorrogas as $prorroga)
                    <li class="collection-item">
                        <div class="row">
                            <div class="col s12 m4 l4">
                                <b class="title green-text">Proyecto</b>
                                <p>{{$proyecto->codigo_proyecto}} {{$proyecto->nombre}}</p>
                            </div>
                            <div class="col s12 m5 l5">
                                <b class="title green-text">Fecha estimada para finalizar la fase de ejecución</b>
                                <p>{{$prorroga->fecha_ejecucion}}</p>
                                @if ($prorroga->justificacion != null)
                                    <p><b>Justificación:</b> {{$prorroga->justificacion}}</p>
                                @endif
                            </div>
                            <div class="col s12 m3 l3">
                                <b class="title green-text">Fecha de registro en el sistema</b>
                                <p>{{$prorroga->created_at}}</p>
                            </div>
                        </div>
                    </li>
                @endforeach
                </ul>
            </div>
        </div>
        <div class="modal-footer white-text">
            <a href="#!" class="modal-action modal-close waves-effect waves-primary btn-flat ">Cerrar</a>
        </div>
    </div>
@endif