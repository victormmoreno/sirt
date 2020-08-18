<ul class="collapsible" data-collapsible="accordion">
  <li>
    <div class="collapsible-header teal lighten-4"><i class="material-icons">filter_drama</i>Ver historial de
      movimientos.</div>
    <div class="collapsible-body">
      <div class="row">
        <div class="center col s12 m12 l12">
          <ul class="collection">
            <li class="collection-item">
              El proyecto fue creado el día
              {{$proyecto->articulacion_proyecto->actividad->fecha_inicio->isoFormat('YYYY-MM-DD')}}.
            </li>
            @for ($i = 0; $i < $historico->count(); $i++)
              <li class="collection-item">
                @if ($historico[$i]->fase == 'Finalizado')
                El {{$historico[$i]->rol}} {{$historico[$i]->usuario}} {{$historico[$i]->movimiento}} el proyecto el día {{$historico[$i]->created_at}}
                @else
                  @if ($historico[$i]->movimiento == 'Cambió')
                  El {{$historico[$i]->rol}} {{$historico[$i]->usuario}} {{$historico[$i]->movimiento}} el gestor del proyecto el día {{$historico[$i]->created_at}}
                  (Este proyecto se encontraba en fase de {{$historico[$i]->fase}})
                  @elseif($historico[$i]->movimiento == 'Reversó')
                  El {{$historico[$i]->rol}} {{$historico[$i]->usuario}} {{$historico[$i]->movimiento}} el proyecto de la fase {{$historico[$i]->fase}} a {{$historico[$i]->comentarios}} el día {{$historico[$i]->created_at}}.
                  @elseif($historico[$i]->movimiento == 'no aprobó')
                  El {{$historico[$i]->rol}} {{$historico[$i]->usuario}}
                  {{$historico[$i]->movimiento}} la fase de {{$historico[$i]->fase}} del proyecto el día {{$historico[$i]->created_at}} por los siguientes motivos: {{$historico[$i]->comentarios}}.
                  @else
                  El {{$historico[$i]->rol}} {{$historico[$i]->usuario}}
                  {{$historico[$i]->movimiento}} la fase de {{$historico[$i]->fase}} el día {{$historico[$i]->created_at}}.
                  @endif
                @endif
              </li>
            @endfor
          </ul>
        </div>
      </div>
    </div>
  </li>
</ul>