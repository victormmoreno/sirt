{!! csrf_field() !!}
<div class="row">
    <div class="input-field col s12 m8 l6 offset-l3 offset-m2">
        <i class="material-icons prefix green-complement-text">
            speaker_notes
        </i>
        <select class="" id="txtlinea" name="txtlinea" style="width: 100%" tabindex="-1">
            <option value="">Seleccione linea</option>
            @foreach($lineas as $id => $nombre)
                @if(isset($sublinea))
                <option value="{{$id}}" {{old('txtlinea',$id) ==  $sublinea->lineatecnologica_id ? 'selected':''}}>{{$nombre}}</option>
                @else
                    <option value="{{$id}}" {{old('txtlinea') == $id  ? 'selected':''}}>{{$nombre}}</option>
                @endif
            @endforeach
        </select>
        <label for="txtlinea">
            Linea
        </label>
        @error('txtlinea')
            <label id="txtlinea-error" class="error" for="txtlinea">{{ $message }}</label>
        @enderror
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m8 l6 offset-l3 offset-m2">
        <i class="material-icons prefix green-complement-text">
            dns
        </i>
        <input id="txtnombre" name="txtnombre" type="text" value="{{ isset($sublinea->nombre) ? $sublinea->nombre : old('txtnombre')}}">
            <label for="txtnombre">
                Nombre *
            </label>
            @error('txtnombre')
                <label id="txtnombre-error" class="error" for="txtnombre">{{ $message }}</label>
            @enderror
        </input>
    </div>
</div>
<div class="row">
    <div class="col s12 m12 l12">
        <div class="col s12 center-align m-t-sm">
            <button type="submit"
                    class="waves-effect waves-light btn bg-secondary center-align">
                <i class="material-icons left">send</i>
                {{isset($btnText) ? $btnText : 'Guardar'}}
            </button>
            <a href="{{route('sublineas.index')}}"
               class="modal-action modal-open waves-effect bg-danger btn center-align">
                <i class="material-icons right">backspace</i>
                Regresar
            </a>
        </div>
    </div>
</div>
