<div class="row">
    <div class="input-field col s12 m4 l4">
        <select multiple name="selectNodos[]" id="selectNodos" style="width: 100%">
            @if ($nodos->count() >= 2)
                <option value="all" selected>Todos</option>
                @foreach ($nodos as $nodo)
                    <option value="{{ $nodo->id }}">
                        {{ $nodo->nodos }}
                    </option>
                @endforeach
            @else
                @foreach ($nodos as $nodo)
                    <option value="{{ $nodo->id }}" selected>
                        {{ $nodo->nodos }}
                    </option>
                @endforeach
            @endif
        </select>
        <label for="selectNodos">Seleccione el nodo</label>
    </div>
    <div class="input-field col s12 m4 l4">
        <input type="text" id="txtdesde" name="txtdesde" class="datepicker picker__input"
            value="{{ Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
        <label for="txtdesde">Finalizados desde</label>
    </div>
    <div class="input-field col s12 m4 l4">
        <input type="text" id="txthasta" name="txthasta" class="datepicker picker__input"
            value="{{ Carbon\Carbon::now()->toDateString() }}">
        <label for="txthasta">Finalizados hasta</label>
    </div>
</div>
<div class="center input-field col s12 m6 l6">
    <button type="submit"
        class="waves-effect waves-grey bg-secondary-lighten white-text btn-flat search-tabs-button m-l-xs">Descargar<i
            class="material-icons left">file_download</i></button>
</div>
