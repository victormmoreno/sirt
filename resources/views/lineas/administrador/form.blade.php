{!! csrf_field() !!}
<div class="row">
    <div class="input-field col s12 m6 l6 offset-l3 m3 s3">
        <i class="material-icons prefix">
            dns
        </i>
        <input id="txtnombre" name="txtabreviatura" type="text" value="{{ isset($linea->abreviatura) ? $linea->abreviatura : old('txtabreviatura')}}">
            <label for="txtnombre">
                Abreviatura *
            </label>
            @error('txtabreviatura')
            <span class="helper-text">
                <strong>
                    {{ $message }}
                </strong>
            </span>
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
            <span class="helper-text">
                <strong>
                    {{ $message }}
                </strong>
            </span>
            @enderror
        </input>
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m6 l6 offset-l3 m3 s3">
        <i class="material-icons prefix">
            speaker_notes
        </i>
        <textarea class="materialize-textarea" id="txtdescripcion" length="1000" maxlength="1000" name="txtdescripcion">
            {{ isset($linea->descripcion) ? $linea->descripcion : old('txtdescripcion')}}
        </textarea>
        <label for="txtdescripcion">
            Descripción
        </label>
        @error('txtdescripcion')
            <span class="helper-text">
                <strong>
                    {{ $message }}
                </strong>
            </span>
            @enderror
    </div>
</div>
{{--
<br>
    <label for="mensaje">
        mensaje
        <textarea class="form-control" name="nombre">
            --}}
                {{-- {{ $message->mensaje  old('mensaje')}} --}}
                {{-- {{ isset($linea->nombre) ? $linea->nombre : old('linea')}}
        </textarea>
        @error('nombre')
        <span class="helper-text">
            <strong>
                {{ $message }}
            </strong>
        </span>
        @enderror
    </label>
    <br>
        --}}
        <center>
            <input class="btn btn-primary" type="submit" value="{{isset($btnText) ? $btnText : 'Guardar'}}"></input>
            <a href="" class="btn waves-effect red lighten-2  center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
        </center>
        
        
        {{--php7
        <input class="btn btn-primary" type="submit" value="{{ $btnText ?? 'Guardar'}}">
        </input>
        --}}
            {{--
        <input class="btn btn-primary" type="submit" value="{{ $btnText or 'Guardar'}}">
        </input>
        --}}
      {{--
    </br>
</br>
--}}
