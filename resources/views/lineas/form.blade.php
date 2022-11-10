<div class="col s12 m8 l8 offset-l2 offset-m2">
    {!! csrf_field() !!}
    @if ($errors->any())
    <div class="card bg-danger">
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
        <div class="input-field col s12 m8 l8 offset-l2 offset-m2">
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
        <div class="input-field col s12 m8 l8 offset-l2 offset-m2">
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
        <div class="col s12 m12 l12">
            <div class="col s12 center-align m-t-sm">
                <button type="submit"
                        class="waves-effect waves-light btn bg-secondary center-align">
                    <i class="material-icons left">send</i>
                    {{isset($btnText) ? $btnText : 'Guardar'}}
                </button>
                <a href="{{route('lineas.index')}}"
                   class="modal-action modal-open waves-effect bg-danger btn center-align">
                    <i class="material-icons right">backspace</i>
                    Regresar
                </a>
            </div>
        </div>
    </div>
</div>

