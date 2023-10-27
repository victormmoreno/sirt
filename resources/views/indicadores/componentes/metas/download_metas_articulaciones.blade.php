<div class="row">
    <form action="{{route('indicador.export.metas-articulaciones')}}" name="frmDescargarMetasArticulaciones" method="get">
        {!! method_field('GET')!!}
        {!! csrf_field() !!}
        <div class="input-field col s12 m6 l6">
            <select multiple name="txtnodo_meta_articulaticion[]" id="txtnodo_meta_articulaticion" style="width: 100%">
                @if (session()->get('login_role') == auth()->user()->IsActivador() || session()->get('login_role') == auth()->user()->IsAdministrador())
                    <option value="all" selected>Todos</option>
                @endif
                    @foreach($nodos as $nodo)
                        <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                    @endforeach
            </select>
            <label for="txtnodo_meta_articulaticion">Seleccione el nodo</label>
        </div>
        <div class="input-field col s12 m4 l4">
            {{-- <button type="submit" onclick="downloadMetasArticulaciones(event)" class="btn bg-secondary left show-on-large hide-on-med-and-down">
                <i class="material-icons left">file_download</i>Descargar metas
            </button> --}}
            <button type="submit" class="btn bg-secondary left show-on-large hide-on-med-and-down">
                <i class="material-icons left">file_download</i>Descargar metas
            </button>
        </div>
    </form>
</div>