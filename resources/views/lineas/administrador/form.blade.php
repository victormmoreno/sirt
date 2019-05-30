{!! csrf_field() !!}
<div class="row">
    <div class="input-field col s12 m6 l6 offset-l3 m3 s3">
        <i class="material-icons prefix">
            dns
        </i>
        <input id="txtabreviatura" name="txtabreviatura" type="text" value="{{ isset($linea->abreviatura) ? $linea->abreviatura : old('txtabreviatura')}}">
            <label for="txtabreviatura">
                Abreviatura *
            </label>
            @error('txtabreviatura')
                <label id="txtabreviatura-error" class="error" for="txtabreviatura">{{ $message }}</label>
            @enderror
        </input>
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m6 l6 offset-l3 m3 s3">
        <i class="material-icons prefix">
            dns
        </i>
        <input id="txtnombre" name="txtnombre" type="text" value="{{ isset($linea->nombre) ? $linea->nombre : old('txtnombre')}}">
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
        <textarea class="materialize-textarea" id="txtdescripcion" length="2000" maxlength="2000" name="txtdescripcion">
            {{ isset($linea->descripcion) ? $linea->descripcion : old('txtdescripcion')}}
        </textarea>
        <label for="txtdescripcion">
            Descripción
        </label>
        @error('txtdescripcion')
            <label id="txtdescripcion-error" class="error" for="txtdescripcion">{{ $message }}</label>
        @enderror
    </div>
</div>
<center>
   
    <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done_all</i>{{isset($btnText) ? $btnText : 'Guardar'}}</button> 
    <a class="btn waves-effect red lighten-2 center-aling" href="{{route('lineas.index')}}">
        <i class="material-icons right">
            backspace
        </i>
        Cancelar
    </a>
</center>
