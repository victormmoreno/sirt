@extends('spa.layouts.app')
@section('meta-tittle', 'Inicio')
@section('meta-content', 'Inicio')
@section('content-spa')

{!! csrf_field() !!}

<div class="card">
    <div class="card-content">
        <div class="col s12 m12 l12">
            <h3 class="card-title center-align">
                <b>Registro usuario</b>
            </h3>
        </div>

        @if ($errors->any())
        <div class="card red lighten-3">
            <div class="row">
                <div class="col s12 m10">
                    <div class="card-content white-text">
                        <p>
                            <i class="material-icons left">
                                info_outline
                            </i>
                            Los datos marcados con * son obligatorios
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <form action="" method="POST">
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <h5 class="card-title center-align">Documentación y lugar de expedición</h5>
                        </div>
                        <div class="divider"></div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12 m6 l6">
                            <i class="material-icons prefix">
                                library_books
                            </i>
                            <select name="txttipo_documento" style="width: 100%" tabindex="-1">
                                <option value="">Seleccione tipo documento</option>
                                @foreach($tiposdocumentos as $value)
                                    @if(isset($user->tipoDocumento->id))
                                        <option value="{{$value->id}}" {{old('txttipo_documento',$user->tipoDocumento->id) ==$value->id ? 'selected':''}}>{{$value->nombre}}</option>
                                    @else
                                        <option value="{{$value->id}}" {{old('txttipo_documento') == $value->id  ? 'selected':''}}>{{$value->nombre}}</option>
                                    @endif
                                @endforeach
                            </select>
                            <label for="txttipo_documento">Tipo Documento <span class="red-text">*</span></label>
                            <small id="txttipo_documento-error" class="error red-text"></small>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <i class="material-icons prefix">
                                library_books
                            </i>
                            <input class="validate" id="txtnumdoc" name="txtnumdoc" type="text">
                            <label for="txtnumdoc">Número de documento<span class="red-text">*</span></label>
                            @error('txtnumdoc')
                                <label id="txtnumdoc-error" class="error" for="txtnumdoc">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12 m6 l6">
                            <i class="material-icons prefix">
                                map
                            </i>
                            <select name="txtdpto" style="width: 100%" tabindex="-1">
                                <option value="">Seleccione departamento</option>
                                @foreach($departamentos as $value)
                                    @if(isset($user->departamento->id))
                                        <option value="{{$value->id}}" {{old('txtdpto',$user->departamento->id) ==$value->id ? 'selected':''}}>{{$value->nombre}}</option>
                                    @else
                                        <option value="{{$value->id}}" {{old('txtdpto') == $value->id  ? 'selected':''}}>{{$value->nombre}}</option>
                                    @endif
                                @endforeach
                            </select>
                            <label for="txtdpto">Departamento<span class="red-text">*</span></label>
                            <small id="txtdpto-error" class="error red-text"></small>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <i class="material-icons prefix">
                                domain
                            </i>
                            <select name="txtciudad_residencia" style="width: 100%" tabindex="-1">
                                <option value="">Seleccione ciudad</option>
                                @foreach($ciudades as $value)
                                    @if(isset($user->ciudad->id))
                                        <option value="{{$value->id}}" {{old('txtciudad',$user->ciudad->id) ==$value->id ? 'selected':''}}>{{$value->nombre}}</option>
                                    @else
                                        <option value="{{$value->id}}" {{old('txtciudad') == $value->id  ? 'selected':''}}>{{$value->nombre}}</option>
                                    @endif
                                @endforeach
                            </select>
                            <label for="txtciudad">Ciudad<span class="red-text">*</span></label>
                            <small id="txtciudad-error" class="error red-text"></small>
                        </div>
                    </div>
                </div>

                <div class="card">

                    <div class="card-content">
                        <div class="col s12 m12 l12">
                            <h5 class="card-title center-align">Datos personales</h5>
                        </div>
                        <div class="divider"></div>

                        <div class="row">
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">
                                    account_circle
                                </i>
                                <input class="validate" id="txtnombres" name="txtnombres" type="text">
                                <label for="txtnombres">Nombres<span class="red-text">*</span></label>
                                @error('txnombres')
                                    <label id="txtnombres-error" class="error" for="txtnombres">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">
                                    account_circle
                                </i>
                                <input class="validate" id="txtapellidos" name="txtapellidos" type="text">
                                <label for="txtapellidos">Apellidos<span class="red-text">*</span></label>
                                @error('txtapellidos')
                                    <label id="txtapellidos-error" class="error" for="txtapellidos">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">
                                    map
                                </i>
                                <select name="txtdpto_residencia" style="width: 100%" tabindex="-1">
                                    <option value="">Seleccione departamento</option>
                                    @foreach($departamentos as $value)
                                        @if(isset($user->departamento->id))
                                            <option value="{{$value->id}}" {{old('txtdpto_residencia',$user->departamento->id) ==$value->id ? 'selected':''}}>{{$value->nombre}}</option>
                                        @else
                                            <option value="{{$value->id}}" {{old('txtdpto_residencia') == $value->id  ? 'selected':''}}>{{$value->nombre}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <label for="txtdpto_residencia">Departamento residencia<span class="red-text">*</span></label>
                                <small id="txtdpto_residencia-error" class="error red-text"></small>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">
                                    domain
                                </i>
                                <select name="txtciudad_residencia" style="width: 100%" tabindex="-1">
                                    <option value="">Seleccione ciudad</option>
                                    @foreach($ciudades as $value)
                                        @if(isset($user->ciudad->id))
                                            <option value="{{$value->id}}" {{old('txtciudad_residencia',$user->ciudad->id) ==$value->id ? 'selected':''}}>{{$value->nombre}}</option>
                                        @else
                                            <option value="{{$value->id}}" {{old('txtciudad_residencia') == $value->id  ? 'selected':''}}>{{$value->nombre}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <label for="txtciudad_residencia">Ciudad residencia<span class="red-text">*</span></label>
                                <small id="txtciudad_residencia-error" class="error red-text"></small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">
                                    home
                                </i>
                                <input class="validate" id="txtdireccion" name="txtdireccion" type="text">
                                <label for="txtdireccion">Dirección residencia<span class="red-text">*</span></label>
                                @error('txtdireccion')
                                    <label id="txtdireccion-error" class="error" for="txtdireccion">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">
                                    phone
                                </i>
                                <input class="validate" id="txttelefono" name="txttelefono" type="tel">
                                <label for="txttelefono">Teléfono / Celular  <span class="red-text">*</span></label>
                                @error('txttelefono')
                                    <label id="txttelefono-error" class="error" for="txttelefono">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">
                                    email
                                </i>
                                <input class="validate" id="txtcorreo" name="txtcorreo" type="text">
                                <label for="txtcorreo">Correo Electronico  <span class="red-text">*</span></label>
                                @error('txtcorreo')
                                    <label id="txtcorreo-error" class="error" for="txtcorreo">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">email</i>
                                <input class="validate" id="txtconfirmemail" name="txtconfirmemail" type="text">
                                <label for="txtconfirmemail">Confirmar correo electronico<span class="red-text">*</span></label>
                                @error('txtconfirmemail')
                                    <label id="txtconfirmemail-error" class="error" for="txtconfirmemail">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12 m12 l12 offset-l5 m5 s5">
                                <div class="switch m-b-md">
                                    <i class="material-icons prefix">wc</i>
                                        <label class="active">
                                            Genero
                                            <span class="red-text">*</span>
                                        </label>
                                    <label>
                                        Masculino
                                        @if(isset($user->genero))
                                        <input type="checkbox" id="txtgenero" name="txtgenero" {{$user->genero != 1 ? 'checked' : old('txtgenero')}}>
                                        @else
                                        <input type="checkbox" id="txtgenero" name="txtgenero" {{old('txtgenero') == 'on' ? 'checked' : ''}}>
                                        @endif
                                        <span class="lever"></span>
                                        Femenino
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card">
                    <div class="card-content">
                        <div class="row container section">
                            <div class="input-field col s12 m12 l12 offset-l4 offset-m4 offset-s4">
                                <button class="waves-effect cyan darken-1 btn center-aling" type="submit">
                                    <i class="material-icons left">
                                        done_all
                                    </i>
                                    {{isset($btnText) ? $btnText : 'Guardar'}}
                                </button>
                                <a class="waves-effect red lighten-2 btn center-aling" href="{{route('/')}}">
                                    <i class="material-icons left">
                                        backspace
                                    </i>
                                    Cancelar
                                </a>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection



