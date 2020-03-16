<ul class="collapsible" data-collapsible="accordion">
    <li>
        <div class="collapsible-header teal lighten-4"><i class="material-icons">filter_drama</i>Ver historial de
            movimientos.</div>
        <div class="collapsible-body">
            <div class="row">
                <div class="center col s12 m12 l12">
                    <ul class="collection">
                        <li class="collection-item">
                            La articulación fue creada el día {{$articulacion->articulacion_proyecto->actividad->fecha_inicio->isoFormat('YYYY-MM-DD')}}.
                        </li>
                        @for ($i = 0; $i < $historico->count(); $i++)
                            <li class="collection-item">
                                @if ($historico[$i]->fase == 'Finalizado')
                                El {{$historico[$i]->rol}} {{$historico[$i]->usuario}} {{$historico[$i]->movimiento}} la
                                articulación el día {{$historico[$i]->created_at}}
                                @else
                                El {{$historico[$i]->rol}} {{$historico[$i]->usuario}}
                                {{$historico[$i]->movimiento}} la fase de {{$historico[$i]->fase}} el día
                                {{$historico[$i]->created_at}}.
                                @endif
                            </li>
                        @endfor
                    </ul>
                </div>
            </div>
        </div>
    </li>
</ul>