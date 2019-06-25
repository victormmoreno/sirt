{!! csrf_field() !!}

<div class="row">
    <div class="input-field col s12 m6 l6 offset-l3 m3 s3">
        <i class="material-icons prefix">
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
    <div class="input-field col s12 m6 l6 offset-l3 m3 s3">
        <i class="material-icons prefix">
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
<center>
   
    <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done_all</i>{{isset($btnText) ? $btnText : 'Guardar'}}</button> 
    <a class="btn waves-effect red lighten-2 center-aling" href="{{route('sublineas.index')}}">
        <i class="material-icons right">
            backspace
        </i>
        Cancelar
    </a>
</center>
