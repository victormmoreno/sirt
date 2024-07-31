<div class="row">
    <div class="col s12 m8 l8">
        <ul class="collection">
            <li class="collection-item">
                El proyecto fue creado el día {{ $proyecto->fecha_inicio->isoFormat('YYYY-MM-DD') }}.
            </li>
            @foreach ($historico->get() as $item)
                <li class="collection-item">
                    El {{$item->rol}} {{$item->usuario}} {{$item->movimiento}}
                    {{-- @if ($item->movimiento == 'Cerró')
                    El {{$item->rol}} {{$item->usuario}} {{$item->movimiento}} el proyecto --}}
                    @if ($item->movimiento == 'Cambió')
                    el experto del proyecto (Este proyecto se encontraba en fase de {{$item->fase}}).
                    @elseif($item->movimiento == 'Reversó')
                    el proyecto de la fase {{$item->fase}} a {{$item->comentarios}}.
                    @elseif($item->movimiento == 'no aprobó')
                    la fase de {{$item->fase}} del proyecto por los siguientes motivos: {{$item->comentarios}}.
                    @elseif($item->movimiento == 'solicitó al talento' || $item->movimiento == 'solicitó al dinamizador')
                    aprobar la fase de {{$item->fase}} del proyecto.
                    @elseif($item->movimiento == 'suspendió')
                    el proyecto cuando se encontraba en la fase de {{$item->fase}}.
                    @elseif($item->movimiento == 'Aprobó')
                    la fase de {{$item->fase}}.
                    @elseif($item->movimiento == 'estableció')
                    como fecha para terminar la fase de {{$item->fase}} del proyecto el día {{$item->comentarios}}.
                    @else
                    mientras el proyecto estaba en fase {{$item->fase}}.
                    @endif
                    <br>
                    Fecha de este evento: <a href="#!">{{$item->created_at}}</a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="col s12 m4 l4">
        <ul class="collection">
            <li class="collection-item avatar">
                <i class="large material-icons circle bg-primary">insert_chart</i>
                <p>
                    Cantidad de eventos registrados: <b>{{$historico->get()->count()}}</b>
                </p>
                <p>
                    Veces que se solicitó el cambio de fase de proyecto: <b>{{$historico->whereIn('movimiento', ['solicitó al talento', 'solicitó al dinamizador'])->get()->count()}}</b>
                </p>
                <p>
                    Veces que se envió la encuesta de percepción: <b>{{$proyecto->EncuestasEnviadas()->get()->count()}}</b>
                </p>
                @if ( $proyecto->fase->nombre != $proyecto->IsFinalizado() && $proyecto->fase->nombre != $proyecto->IsSuspendido() )
                    <p>
                        Duración de la ejecución del proyecto hasta el momento: <b>{{ $proyecto->fecha_inicio->diffInDays(Carbon\Carbon::now()) }}</b> días.
                    </p>
                @endif
                @if ($proyecto->fase->nombre == $proyecto->IsFinalizado())
                    <p>
                        Duración de la ejecución del proyecto: <b>{{ $proyecto->fecha_inicio->diffInDays($proyecto->fecha_cierre) }}</b> días.
                    </p>
                @endif
            </li>
        </ul>
    </div>
</div>