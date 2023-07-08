<div class="row">
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
            <div class="input-field col s12 m6 l6">
                <select multiple name="txtnodo_ideas_download[]" id="txtnodo_ideas_download" style="width: 100%">
                @if (session()->get('login_role') == auth()->user()->IsActivador() || session()->get('login_role') == auth()->user()->IsAdministrador())
                    <option value="all" selected>Todos</option>
                @endif
                @foreach($nodos as $nodo)
                    <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                @endforeach
                </select>
                <label for="txtnodo_ideas_download">Seleccione el nodo</label>
            </div>
        </div>
        <center>
            <button type="submit" onclick="downloadIdeasIndicadores(event)" class="btn bg-secondary show-on-large hide-on-med-and-down">
                <i class="material-icons left">file_download</i>Descargar ideas
            </button>
        </center>
    </form>
</div>
