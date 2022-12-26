<div class="row card card-panel">
    <form action="{{route('indicador.export.ideas')}}" name="frmDescargarIdeas" method="get">
        {!! method_field('GET')!!}
        {!! csrf_field() !!}
        <div class="row">
            <div class="input-field col s12 m6 l6">
                <select class="js-states select2 browser-default" name="txtestado_idea_download" id="txtestado_idea_download" style="width: 100%">
                  <option value="{{App\Models\EstadoIdea::IsAdmitido()}}">Ideas que se aprobaron en comité pero no tiene proyecto iniciado</option>
                </select>
                <label for="txtestado_idea_download" class="active">Seleccione una opción</label>
            </div>
        </div>
        <label for="txtideas_download" class="active">Seleccione los nodos de los que se generarán el reporte</label>
        <p class="p-v-xs">
            <input type="checkbox" id="txtideas_download" name="txtideas_download" onclick="selectAll(this, 'ideas_download')" value="all">
            <label for="txtideas_download">Todos.</label>
        </p>
        @foreach ($nodos as $nodo)
        <div class="col s6 m4 l4">
            <p class="p-v-xs">
                <input type="checkbox" id="txtnodo_ideas_download{{$nodo->id}}" name="txtnodo_ideas_download[]" class="ideas_download" value="{{$nodo->id}}" onclick="verificarChecks(this, 'txtideas_download')">
                <label for="txtnodo_ideas_download{{$nodo->id}}">{{$nodo->nodos}}.</label>
            </p>
        </div>
        @endforeach
        <button type="submit" onclick="downloadIdeasIndicadores(event)" class="waves-effect waves-grey grey darken-1 white-text btn-flat search-tabs-button left show-on-large hide-on-med-and-down">
            <i class="material-icons left">file_download</i>Descargar ideas
        </button>
    </form>
</div>