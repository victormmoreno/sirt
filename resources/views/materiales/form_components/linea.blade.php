<div class="row">
    <div class="input-field col s12 m12 l12">
        <select style="width: 100%" class="js-states" id="txtlineatecnologica" name="txtlineatecnologica">
            <option value="">Seleccione la línea tecnológica donde se registrará el material de formación</option>
            @if (isset($material->lineatecnologica->id))
                @forelse ($lineastecnologicas as $id => $linea)
                    <option value="{{$linea->id}}" {{ $material->lineatecnologica_id == $linea->id ? 'selected':'' }}>{{$linea->nombre}}</option>
                @empty
                    <option value=""> No hay información disponible</option>
                @endforelse
            @else
                @forelse ($lineastecnologicas->lineas as $id => $linea)
                    <option value="{{$linea->id}}" {{ old('txtlineatecnologica') == $linea->id ? 'selected':'' }}>{{$linea->nombre}}</option>
                @empty
                    <option value=""> No hay información disponible</option>
                @endforelse
            @endif
        </select>
        @error('txtlineatecnologica')
        <label class="error" for="txtlineatecnologica" id="txtlineatecnologica-error">
            {{ $message }}
        </label>
        @enderror
    </div>
</div>