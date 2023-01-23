<ul class="collapsible" data-collapsible="accordion">
    <li>
        <div class="collapsible-header bg-primary white-text"><i class="material-icons">filter_drama</i>Ver historial de cambios.</div>
        <div class="collapsible-body">
            <div class="row">
                <div class="center col s12 m12 l12">
                    <ul class="collection">
                        <li class="collection-item">
                            La Articulación fue creada el día
                            {{$articulationStage->present()->articulationStageCreatedDate()}}.
                        </li>
                        @for ($i = 0; $i < $traceability->count(); $i++)
                        <li class="collection-item">
                            @if ( isset($traceability[$i]->usuario) && $traceability[$i]->movimiento == App\Models\Movimiento::IsSolicitarTalento())
                                El {{$traceability[$i]->rol}} {{$traceability[$i]->usuario}} {{$traceability[$i]->movimiento}} avalar el '{{$traceability[$i]->descripcion}}' de la {{__('articulation-stage')}}
                                en la fecha {{$traceability[$i]->created_at->isoFormat('MMMM Do YYYY, h:mm:ss a')}}
                            @endif
                            @if ( isset($traceability[$i]->usuario) && $traceability[$i]->movimiento== App\Models\Movimiento::IsSolicitarDinamizador())
                                El {{$traceability[$i]->rol}} {{$traceability[$i]->usuario}} {{$traceability[$i]->movimiento}}
                                el aval para '{{$traceability[$i]->descripcion}}' la {{__('articulation-stage')}} en la fecha {{$traceability[$i]->created_at->isoFormat('MMMM Do YYYY, h:mm:ss a')}}
                            @endif
                            @if ( isset($traceability[$i]->usuario) && $traceability[$i]->movimiento == App\Models\Movimiento::IsAprobar())
                                El {{$traceability[$i]->rol}} {{$traceability[$i]->usuario}} {{$traceability[$i]->movimiento}}
                                el aval para '{{$traceability[$i]->descripcion}}' la {{__('articulation-stage')}} en la fecha {{$traceability[$i]->created_at->isoFormat('MMMM Do YYYY, h:mm:ss a')}}
                            @endif
                            @if ( isset($traceability[$i]->usuario) && $traceability[$i]->movimiento == App\Models\Movimiento::IsNoAprobar())
                                El {{$traceability[$i]->rol}} {{$traceability[$i]->usuario}} {{$traceability[$i]->movimiento}}
                                el aval para '{{$traceability[$i]->descripcion}}' la {{__('articulation-stage')}}  en la fecha {{$traceability[$i]->created_at->isoFormat('MMMM Do YYYY, h:mm:ss a')}} por los siguientes motivos:  {{$traceability[$i]->comentarios}}
                            @endif
                            @if ( isset($traceability[$i]->usuario) && $traceability[$i]->movimiento == App\Models\Movimiento::IsRegistrar() || $traceability[$i]->movimiento == App\Models\Movimiento::IsCalificar())
                                El día {{$traceability[$i]->created_at->isoFormat('MMMM Do YYYY, h:mm:ss a')}} el {{$traceability[$i]->rol}} {{$traceability[$i]->usuario}} {{$traceability[$i]->movimiento}}
                                la {{__('articulation-stage')}} {{$traceability[$i]->descripcion}}.
                            @endif
                            @if ( isset($traceability[$i]->usuario) && $traceability[$i]->movimiento == App\Models\Movimiento::IsAsignar())
                                El día {{$traceability[$i]->created_at}} el {{$traceability[$i]->rol}} {{$traceability[$i]->usuario}} {{$traceability[$i]->movimiento}}
                                la {{__('articulation-stage')}} al {{$traceability[$i]->rol}}  {{$traceability[$i]->descripcion}}.
                            @endif
                            @if ( isset($traceability[$i]->usuario) && $traceability[$i]->movimiento == App\Models\Movimiento::IsCambiar())
                                El día {{$traceability[$i]->created_at}} el {{$traceability[$i]->rol}} {{$traceability[$i]->usuario}} {{$traceability[$i]->movimiento}}
                                el articulador de la {{__('articulation-stage')}} {{$traceability[$i]->descripcion}}.
                            @endif
                            @if ( isset($traceability[$i]->usuario) && $traceability[$i]->movimiento == App\Models\Movimiento::IsReversar())
                                El {{$traceability[$i]->rol}} {{$traceability[$i]->usuario}} {{$traceability[$i]->movimiento}} la articulación a
                                la fase {{$traceability[$i]->descripcion}} en la fecha {{$traceability[$i]->created_at->isoFormat('MMMM Do YYYY, h:mm:ss a')}}
                            @endif
                        </li>
                        @endfor
                    </ul>
                </div>
            </div>
        </div>
    </li>
</ul>

