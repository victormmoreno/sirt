<ul class="collapsible" data-collapsible="accordion">
    <li>
        <div class="collapsible-header teal lighten-4"><i class="material-icons">filter_drama</i>Ver historial de cambios.</div>
            <div class="collapsible-body">
                <div class="row">
                <div class="center col s12 m12 l12">
                    <ul class="collection">
                        <li class="collection-item">
                            La Articulación fue creada el día
                            {{$articulacion->present()->articulacionPbtstartDate()}}.
                        </li>
                    @foreach ($articulacion->historial as $value)
                        <li class="collection-item">
                            <!--{{$value->user}}-->
                            @if ( isset($value->user) && $value->movimiento->movimiento == App\Models\Movimiento::IsSolicitarTalento())
                                El {{$value->role->name}} {{$value->user->nombres}} {{$value->user->apellidos}} {{$value->movimiento->movimiento}} aprobar la fase
                                {{$value->descripcion}} en la fecha {{$value->created_at->isoFormat('DD-MM-YYYY')}}
                            @endif
                            @if ( isset($value->user) && $value->movimiento->movimiento == App\Models\Movimiento::IsSolicitarDinamizador())
                                El {{$value->role->name}} {{$value->user->nombres}} {{$value->user->apellidos}} {{$value->movimiento->movimiento}}
                                {{$value->descripcion}} la articulación en la fecha {{$value->created_at->isoFormat('DD-MM-YYYY')}}
                            @endif
                            @if ( isset($value->user) && $value->movimiento->movimiento == App\Models\Movimiento::IsAprobar())
                                El {{$value->role->name}} {{$value->user->nombres}} {{$value->user->apellidos}} {{$value->movimiento->movimiento}}
                                la fase {{$value->descripcion}} en la fecha {{$value->created_at->isoFormat('DD-MM-YYYY')}}
                            @endif
                                @if ( isset($value->user) && $value->movimiento->movimiento == App\Models\Movimiento::IsNoAprobar())
                                El {{$value->role->name}} {{$value->user->nombres}} {{$value->user->apellidos}} {{$value->movimiento->movimiento}}
                                la fase {{$value->descripcion}} en la fecha {{$value->created_at->isoFormat('DD-MM-YYYY')}} por los siguientes motivos:  {{$value->comentarios}}
                            @endif
                            @if ( isset($value->user) && $value->movimiento->movimiento == App\Models\Movimiento::IsPostular() || $value->movimiento->movimiento == App\Models\Movimiento::IsDuplicar())
                                El {{$value->role->name}} {{$value->user->nombres}} {{$value->user->apellidos}} {{$value->movimiento->movimiento}}
                                la articulación {{$value->descripcion}} en la fecha {{$value->created_at}}
                            @endif

                            @if ( isset($value->user) && $value->movimiento->movimiento == App\Models\Movimiento::IsRegistrar() || $value->movimiento->movimiento == App\Models\Movimiento::IsCalificar())
                                El día {{$value->created_at->isoFormat('DD-MM-YYYY')}} el {{$value->role->name}} {{$value->user->nombres}} {{$value->user->apellidos}} {{$value->movimiento->movimiento}}
                                la articulación {{$value->descripcion}}.
                            @endif
                            @if ( isset($value->user) && $value->movimiento->movimiento == App\Models\Movimiento::IsAsignar())
                                El día {{$value->created_at}} el {{$value->role->name}} {{$value->user->nombres}} {{$value->user->apellidos}} {{$value->movimiento->movimiento}}
                                la articulación al experto {{$value->descripcion}}.
                            @endif
                            @if ( isset($value->user) && $value->movimiento->movimiento == App\Models\Movimiento::IsCambiar())
                                El día {{$value->created_at}} el {{$value->role->name}} {{$value->user->nombres}} {{$value->user->apellidos}} {{$value->movimiento->movimiento}}
                                el experto de la articulación {{$value->descripcion}}.
                            @endif
                            @if ( isset($value->user) && $value->movimiento->movimiento == App\Models\Movimiento::IsReversar())
                                El {{$value->role->name}} {{$value->user->nombres}} {{$value->user->apellidos}} {{$value->movimiento->movimiento}} la articulación a
                                la fase {{$value->descripcion}} en la fecha {{$value->created_at->isoFormat('DD-MM-YYYY')}}
                            @endif
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </li>
</ul>
