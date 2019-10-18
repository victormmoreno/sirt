

<div class="col s12 m8 l8 offset-l2 m2">
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
            <div class="col s12 m12 l12">
                <blockquote>
                    <ul class="collection">
                        <li class="collection-item">Debes tener en cuenta que el costo administrativo de <b>{{$costoadministrativo->costoadministrativo}}</b> soló será válido para el presente año. <br/> Recuerde que este valor solo se ingresa una sola vez al año</li>
                </ul>
            </blockquote>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 m6 l6 offset-l3 m3 s3">
            <i class="material-icons prefix">
                settings_input_svideo
            </i>
            <input id="txtcostoadministrativo"  type="text" value="{{ isset($costoadministrativo->costoadministrativo) ? $costoadministrativo->costoadministrativo : 'No Registra'}}" readonly>
                <label for="txtcostoadministrativo">
                    Costo Administrativo <span class="red-text"></span>
                </label>
            </input>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 m6 l6 offset-l3 m3 s3">
            <i class="material-icons prefix">
                money
            </i>
            <input id="txtvalor" name="txtvalor" type="text" value="{{ isset($costoadministrativo->valor) ? $costoadministrativo->valor : old('txtvalor')}}">
                <label for="txtvalor">
                    Valor <span class="red-text">*</span>
                </label>
                @error('txtvalor')
                    <label id="txtvalor-error" class="error" for="txtvalor">{{ $message }}</label>
                @enderror
            </input>
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

