<ul class="collapsible" data-collapsible="accordion">
    <li>
        <div class="collapsible-header teal lighten-4"><i class="material-icons">filter_drama</i>Ver historial de cambios.</div>
        <div class="collapsible-body">
            <div class="row">
            <div class="center col s12 m12 l12">
                <ul class="collection">
                <li class="collection-item">
                    La idea de proyecto fue creada el día
                    {{$idea->created_at->isoFormat('YYYY-MM-DD')}}.
                </li>
                @foreach ($idea->historial as $value)
                <li class="collection-item">
                    @if ($value->movimiento->movimiento == App\Models\Movimiento::IsPostular() || $value->movimiento->movimiento == App\Models\Movimiento::IsDuplicar())
                    El {{$value->role->name}} {{$value->user->nombres}} {{$value->user->apellidos}} {{$value->movimiento->movimiento}}
                    la idea de proyecto {{$value->descripcion}} en la fecha {{$value->created_at}}
                    @endif
                    @if ($value->movimiento->movimiento == App\Models\Movimiento::IsAprobar() || $value->movimiento->movimiento == App\Models\Movimiento::IsNoAprobar())
                    El {{$value->role->name}} {{$value->user->nombres}} {{$value->user->apellidos}} {{$value->movimiento->movimiento}}
                    {{$value->descripcion}} en la fecha {{$value->created_at}}
                    @endif
                    @if ($value->movimiento->movimiento == App\Models\Movimiento::IsRegistrar() || $value->movimiento->movimiento == App\Models\Movimiento::IsCalificar())
                    El día {{$value->created_at}} el {{$value->role->name}} {{$value->user->nombres}} {{$value->user->apellidos}} {{$value->movimiento->movimiento}}
                    la idea de proyecto {{$value->descripcion}}.
                    @endif
                    @if ($value->movimiento->movimiento == App\Models\Movimiento::IsAsignar())
                    El día {{$value->created_at}} el {{$value->role->name}} {{$value->user->nombres}} {{$value->user->apellidos}} {{$value->movimiento->movimiento}}
                    la idea de proyecto al experto {{$value->descripcion}}.
                    @endif
                    @if ($value->movimiento->movimiento == App\Models\Movimiento::IsCambiar())
                    El día {{$value->created_at}} el {{$value->role->name}} {{$value->user->nombres}} {{$value->user->apellidos}} {{$value->movimiento->movimiento}}
                    el experto de la idea de proyecto {{$value->descripcion}}.
                    @endif
                    @if ($value->movimiento->movimiento == App\Models\Movimiento::IsInhabilitar())
                    El {{$value->role->name}} {{$value->user->nombres}} {{$value->user->apellidos}} {{$value->movimiento->movimiento}}
                    la idea de proyecto {{$value->descripcion}} en la fecha {{$value->created_at}}.
                    @endif
                    @if ($value->movimiento->movimiento == App\Models\Movimiento::IsNotificar())
                    El {{$value->role->name}} {{$value->user->nombres}} {{$value->user->apellidos}} {{$value->movimiento->movimiento}}
                    {{$value->descripcion}} en la fecha {{$value->created_at}}.
                    @endif
                </li>
                @endforeach
                </ul>
            </div>
        </div>
    </div>
    </li>
</ul>
