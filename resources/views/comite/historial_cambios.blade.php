<ul class="collapsible" data-collapsible="accordion">
    <li>
      <div class="collapsible-header teal lighten-4"><i class="material-icons">filter_drama</i>Ver historial de cambios.</div>
      <div class="collapsible-body">
        <div class="row">
          <div class="center col s12 m12 l12">
            <ul class="collection">
              @foreach ($comite->historial as $value)
              <li class="collection-item">
                El día {{$value->created_at}} el {{$value->role->name}} {{$value->user->nombres}} {{$value->user->apellidos}} {{$value->movimiento->movimiento}} 
                {{$value->descripcion}}.
                {{-- @switch($value->movimiento->movimiento)
                    @case(App\Models\Movimiento::IsRegistrar())
                        @break
                    @default
                        
                @endswitch --}}
              </li>
              @endforeach
            </ul>
        </div>
      </div>
    </div>
  </li>
</ul>