
<div class="col s12 m3 l3 ">
    <div class="show-on-large">
        <i class="material-icons extra-big center-align">
            dns
        </i>
    </div>
</div>
<div class="col s12 m9 l9">
    <div class="divider mailbox-divider"></div>
    {!! csrf_field() !!}

    @if ($errors->any())
    <div class="card red lighten-3">
        <div class="row">
            <div class="col s12 m12">
                <div class="card-content white-text">
                    <p>
                        <i class="material-icons left">
                            info_outline
                        </i>
                        @if(collect($errors->all())->count() > 1)
                        Tienes {{collect($errors->all())->count()}} errores
                        @else
                            Tienes {{collect($errors->all())->count()}} error
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="input-field col s12 m6 l6 offset-l3 m3 s3">
            <i class="material-icons prefix">
                dns
            </i>
            <input id="txtabreviatura" name="txtabreviatura" type="text" value="{{ isset($linea->abreviatura) ? $linea->abreviatura : old('txtabreviatura')}}">
                <label for="txtabreviatura">
                    Abreviatura <span class="red-text">*</span>
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
                    Nombre <span class="red-text">*</span>
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
</div>

