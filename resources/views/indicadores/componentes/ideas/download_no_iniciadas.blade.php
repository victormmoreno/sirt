<div class="row card card-panel">
    <form action="{{route('indicador.export.ideas')}}" name="frmDescargarIdeas" method="get">
        {!! method_field('GET')!!}
        {!! csrf_field() !!}
        <p class="p-v-xs">
            <input type="checkbox" id="txtallideasnoiniciadas" name="txtallideasnoiniciadas" onclick="selectAll(this, 'ideas_no_iniciadas')" value="all">
            <label for="txtallideasnoiniciadas">Todos.</label>
        </p>
        @foreach ($nodos as $nodo)
        <div class="col s6 m3 l3">
            <p class="p-v-xs">
                <input type="checkbox" id="txtnodo_ideas_no_iniciadas{{$nodo->id}}" name="txtnodo_ideas_no_iniciadas[]" class="ideas_no_iniciadas" value="{{$nodo->id}}">
                <label for="txtnodo_ideas_no_iniciadas{{$nodo->id}}">{{$nodo->nodos}}.</label>
            </p>
        </div>
        @endforeach
        <button type="submit" onclick="downloadMetas(event)" class="waves-effect waves-grey grey darken-1 white-text btn-flat search-tabs-button left show-on-large hide-on-med-and-down">
            <i class="material-icons left">file_download</i>Descargar ideas
        </button>
    </form>
</div>