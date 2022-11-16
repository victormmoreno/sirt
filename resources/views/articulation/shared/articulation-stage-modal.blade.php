<div class="modal modal modal-fixed-footer" id="type_articulations_modal">
    <div class="modal-content">
        <h4 class="orange-text">Tipos de articulaciones</h4>
        <div class="row">
            <div class="col s12 m6 l6 offset-l3 m3 ">
                <ul class="collection">
                    @forelse($articulationTypes as $articulationType)
                        <li class="collection-item avatar">
                            <i class="material-icons circle orange darken-2">
                                beenhere
                            </i>
                            <span class="title">{{$articulationType->name}}</span>
                            <p>
                                @if($articulationType->articulationsubtypes->count())
                                    <small>{{$articulationType->articulationsubtypes->pluck('name')->implode(', ')}}</small>
                                @endif
                            </p>
                        </li>
                    @empty
                        <div class="center">
                            <i class="large material-icons center">pan_tool</i>
                            <p class="center-align">No se encontraron resultados</p>
                        </div>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-info btn-flat">Cerrar</a>
    </div>
    </div>
