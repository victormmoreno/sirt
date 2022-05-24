<div>
    <form action="{{route('indicador.export.metas')}}" name="frmDescargarMetas" method="get">
        {!! method_field('GET')!!}
        {!! csrf_field() !!}
        <p class="p-v-xs">
            <input type="checkbox" id="txtall" name="txtall" onclick="selectAll(this, 'metas_down')" value="all">
            <label for="txtall">Todos.</label>
        </p>
        @foreach ($nodos as $nodo)
        <div class="col s6 m3 l3">
            <p class="p-v-xs">
                <input type="checkbox" id="txtnodo_metas_id{{$nodo->id}}" name="txtnodo_metas_id[]" class="metas_down" value="{{$nodo->id}}">
                <label for="txtnodo_metas_id{{$nodo->id}}">{{$nodo->nodos}}.</label>
            </p>
        </div>
        @endforeach
        <button type="submit" onclick="downloadMetas(event)" class="waves-effect waves-grey grey darken-1 white-text btn-flat search-tabs-button left show-on-large hide-on-med-and-down">
            <i class="material-icons left">file_download</i>Descargar metas
        </button>
    </form>
</div>