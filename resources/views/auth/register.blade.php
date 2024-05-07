@extends('layouts.guest')
@section('meta-title', 'Registro para usuarios nuevos')
@section('meta-content', 'Registro para usuarios nuevos')
@section('content')
    <div class="section white">
        <div class="container">
            <div class="row  no-m-t no-m-b">
                <div class="col s12 m12 l12 ">
                    <h3 class="center primary-text">Registro de usuarios nuevos</h3>
                    <ul class="collapsible">
                        <li>
                            <div class="collapsible-header">¿Por qué registrarse como usuario?</div>
                            <div class="collapsible-body">
                                <p>Registrarse es el primer paso para inscribirse a los
                                    servicios ofrecios por la Red Tecnoparque Colombia. Es importante que la
                                    información ingresada sea veridica y confiable pues de ésta dependerá la calidad
                                    del proceso de ingreso.</p>
                            </div>
                        </li>
                    </ul>
                    <div class="content">
                        <form id="formRegisterUser" method="POST" action="{{ route('register.request') }}"
                            onsubmit="return checkSubmit()">
                            @csrf
                            <div class="row">
                                <h5 class="center-align primary-text">Información básica</h5>
                                <div class="col m6 vertical-line">
                                    <h5 class="center-align primary-text">Información Documento Identidad</h5>
                                    <div class="row">
                                        <div class="input-field col m6 s12">
                                            <select name="tipo_documento" style="width: 100%" tabindex="-1">
                                                <option value="">Seleccione tipo documento</option>
                                                @foreach($tiposdocumentos as $value)
                                                    @if(isset($user->tipoDocumento->id))
                                                        <option
                                                            value="{{$value->id}}" {{old('tipo_documento',$user->tipoDocumento->id) ==$value->id ? 'selected':''}}>{{$value->nombre}}</option>
                                                    @else
                                                        <option
                                                            value="{{$value->id}}" {{old('tipo_documento') == $value->id  ? 'selected':''}}>{{$value->nombre}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <label for="tipo_documento">Tipo Documento <span
                                                    class="red-text">*</span></label>
                                            <small id="tipo_documento-error" class="error red-text"></small>
                                        </div>
                                        <div class="input-field col s12 m12 l6">
                                            <input id="documento" name="documento" type="text"
                                                value="{{ isset($documento) ? $documento : '' }}" readonly>
                                            <label for="documento">Documento <span class="red-text">*</span></label>
                                            <small id="documento-error" class="error red-text"></small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12 m12 l6">
                                            <select class="js-states browser-default select2 "
                                                id="departamentoexpedicion" name="departamentoexpedicion"
                                                onchange="user.getCiudadExpedicion()" style="width: 100%" tabindex="-1">
                                                <option value="">Seleccione departamento</option>
                                                @foreach ($departamentos as $value)
                                                    @if (isset($user->ciudadexpedicion->departamento_id))
                                                        <option value="{{ $value->id }}"
                                                            {{ old('departamentoexpedicion', $user->ciudadexpedicion->departamento_id) == $value->id ? 'selected' : '' }}>
                                                            {{ $value->nombre }}</option>
                                                    @else
                                                        <option value="{{ $value->id }}"
                                                            {{ old('departamentoexpedicion') == $value->id ? 'selected' : '' }}>
                                                            {{ $value->nombre }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <label class="active" for="departamentoexpedicion">Departamento de
                                                Expedición <span class="red-text">*</span></label>
                                            <small id="departamentoexpedicion-error" class="error red-text"></small>
                                        </div>
                                        <div class="input-field col m6 s12">
                                            <select class="js-states browser-default select2" id="ciudadexpedicion"
                                                name="ciudadexpedicion" style="width: 100%" tabindex="-1">
                                                <option value="">Seleccione Primero el Departamento</option>
                                            </select>
                                            <label class="active" for="ciudadexpedicion">Ciudad de Expedición
                                                <span class="red-text">*</span></label>
                                            <small id="ciudadexpedicion-error" class="error red-text"></small>
                                        </div>
                                    </div>
                                    <h5 class="center primary-text">
                                        Datos de contacto
                                    </h5>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input class="validate" id="email" name="email" type="email"
                                                value="{{ isset($user->email) ? $user->email : old('email') }}">
                                            <label for="email">Correo <span class="red-text">*</span></label>
                                            <small id="email-error" class="error red-text"></small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12 m6 l6">
                                            <input class="validate" id="telefono" name="telefono" type="tel"
                                                value="{{ isset($user->telefono) ? $user->telefono : old('telefono') }}">
                                            <label for="telefono">Telefono</label>
                                            <small id="telefono-error" class="error red-text"></small>
                                        </div>
                                        <div class="input-field col s12 m6 l6">
                                            <input class="validate" id="celular" name="celular" type="tel"
                                                value="{{ isset($user->celular) ? $user->celular : old('celular') }}">
                                            <label for="celular">Celular <span class="red-text">*</span></label>
                                            <small id="celular-error" class="error red-text"></small>
                                        </div>
                                    </div>
                                    <h5 class="center primary-text">Datos de residencia</h5>
                                    <div class="row">
                                        <div class="input-field col s12 m6 l6">
                                            <select class="js-states browser-default select2" id="departamento"
                                                name="departamento" onchange="user.getCiudad()" style="width: 100%"
                                                tabindex="-1">
                                                <option value="">Seleccione departamento</option>
                                                @foreach ($departamentos as $value)
                                                    @if (isset($user->ciudad->departamento_id))
                                                        <option value="{{ $value->id }}"
                                                            {{ old('departamento', $user->ciudad->departamento_id) == $value->id ? 'selected' : '' }}>
                                                            {{ $value->nombre }}</option>
                                                    @else
                                                        <option value="{{ $value->id }}"
                                                            {{ old('departamento') == $value->id ? 'selected' : '' }}>
                                                            {{ $value->nombre }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <label class="active" for="departamento">Departamento de Residencia
                                                <span class="red-text">*</span></label>
                                            <small id="departamento-error" class="error red-text"></small>
                                        </div>
                                        <div class="input-field col s12 m6 l6">
                                            <select class="js-states browser-default select2" id="ciudad"
                                                name="ciudad" style="width: 100%" tabindex="-1">
                                                <option value="">Seleccione Primero el Departamento</option>
                                            </select>
                                            <label class="active" for="ciudad">Ciudad de Residencia <span
                                                    class="red-text">*</span></label>
                                            <small id="ciudad-error" class="error red-text"></small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12 m12 l12">
                                            <input class="validate" id="barrio" name="barrio" type="text"
                                                value="{{ isset($user->barrio) ? $user->barrio : old('barrio') }}">
                                            <label for="barrio">Barrio <span class="red-text">*</span></label>
                                            <small id="barrio-error" class="error red-text"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col m6 l6">
                                    <div class="row">
                                        <h5 class="center-align primary-text">Datos de identificación</h5>
                                        <div class="input-field col s12 m6 l6">
                                            <input class="validate" id="nombres" name="nombres" type="text"
                                                value="{{ isset($user->nombres) ? $user->nombres : old('nombres') }}">
                                            <label for="nombres">Nombres <span class="red-text">*</span></label>
                                            <small id="nombres-error" class="error red-text"></small>
                                        </div>
                                        <div class="input-field col s12 m6 l6">
                                            <input class="validate" id="apellidos" name="apellidos" type="text"
                                                value="{{ isset($user->apellidos) ? $user->apellidos : old('apellidos') }}">
                                            <label for="apellidos">Apellidos <span class="red-text">*</span></label>
                                            <small id="apellidos-error" class="error red-text"></small>
                                        </div>
                                        <div class="input-field col s12 m6 l6">
                                            <input class="validate datepicker" id="fechanacimiento"
                                                name="fechanacimiento" type="text"
                                                value="{{ isset($user->fechanacimiento) ? $user->fechanacimiento->toDateString() : old('fechanacimiento') }}">
                                            <label for="fechanacimiento">Fecha de Nacimiento <span
                                                    class="red-text">*</span></label>
                                            <small id="fechanacimiento-error" class="error red-text"></small>
                                        </div>
                                        <div class="input-field col s12 m6 l6">
                                            <select class="js-states browser-default select2" id="gruposanguineo"
                                                name="gruposanguineo" style="width: 100%" tabindex="-1">
                                                <option value="">Seleccione grupo sanguíneo</option>
                                                @foreach ($gruposanguineos as $value)
                                                    @if (isset($user->grupoSanguineo->id))
                                                        <option value="{{ $value->id }}"
                                                            {{ old('gruposanguineo', $user->grupoSanguineo->id) == $value->id ? 'selected' : '' }}>
                                                            {{ $value->nombre }}</option>
                                                    @else
                                                        <option value="{{ $value->id }}"
                                                            {{ old('gruposanguineo') == $value->id ? 'selected' : '' }}>
                                                            {{ $value->nombre }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <label class="active" for="gruposanguineo">Grupo Sanguíneo <span
                                                    class="red-text">*</span></label>
                                            <small id="gruposanguineo-error" class="error red-text"></small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12 m6 l6">
                                            <select id="estrato" name="estrato" style="width: 100%"
                                                    tabindex="-1">
                                                <option value="">Seleccione estrato</option>
                                                @for($i =1; $i <= 6; $i++)
                                                    @if(isset($user->estrato))
                                                        <option
                                                            value="{{ $i }}" {{old('estrato',$user->estrato) == $i ? 'selected':''}}>{{$i}}</option>
                                                    @else
                                                        <option
                                                            value="{{ $i }}" {{old('estrato') == $i ? 'selected':''}}>{{$i}}</option>
                                                    @endif
                                                @endfor
                                            </select>
                                            <label for="estrato">Estrato <span class="red-text">*</span></label>
                                            <small id="estrato-error" class="error red-text"></small>
                                        </div>
                                        <div class="input-field col s12 m6 l6">
                                            <select class="js-states browser-default select2" id="etnia"
                                                name="etnia" style="width: 100%" tabindex="-1">
                                                <option value="">Seleccione Etnia</option>
                                                @foreach ($etnias as $id => $nombre)
                                                    @if (isset($user->etnia->id))
                                                        <option value="{{ $id }}"
                                                            {{ old('etnia', $user->etnia->id) == $id ? 'selected' : ($nombre == 'No aplica' ? 'selected' : '') }}>
                                                            {{ $nombre }}</option>
                                                    @else
                                                        <option value="{{ $id }}"
                                                            {{ old('etnia') == $id ? 'selected' : ($nombre == 'No aplica' ? 'selected' : '') }}>
                                                            {{ $nombre }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <label class="active" for="etnia">Etnias <span
                                                    class="red-text">*</span></label>
                                            <small id="etnia-error" class="error red-text"></small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12 m6 l6">
                                            <select class="js-states browser-default select2" id="eps"
                                                name="eps" style="width: 100%" tabindex="-1"
                                                onchange="user.getOtraEsp(this)">
                                                <option value="">Seleccione eps</option>
                                                @foreach ($eps as $value)
                                                    @if (isset($user->eps_id))
                                                        <option value="{{ $value->id }}"
                                                            {{ old('eps', $user->eps_id) == $value->id ? 'selected' : '' }}>
                                                            {{ $value->nombre }}</option>
                                                    @else
                                                        <option value="{{ $value->id }}"
                                                            {{ old('eps') == $value->id ? 'selected' : '' }}>
                                                            {{ $value->nombre }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <label class="active" for="eps">Eps <span
                                                    class="red-text">*</span></label>
                                            <small id="eps-error" class="error red-text"></small>
                                        </div>
                                        <div class="input-field col s12 m6 l6 otraeps" style="display:none">
                                            <input class="validate" id="otraeps" name="otraeps" type="text"
                                                value="{{ isset($user->otra_eps) ? $user->otra_eps : old('otraeps') }}">
                                            <label for="otraeps" class="active">Otra Eps <span
                                                    class="red-text">*</span></label>
                                            <small id="otraeps-error" class="error red-text"></small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12 m6 l6">
                                            <select class="" id="gradodiscapacidad"
                                                name="gradodiscapacidad" style="width: 100%" tabindex="-1"
                                                onchange="user.getGradoDiscapacidad(this)">
                                                @if (isset($user->grado_discapacidad))
                                                    <option {{ $user->grado_discapacidad == 0 ? 'selected' : '' }}
                                                        value="0">
                                                        NO
                                                    </option>
                                                    <option {{ $user->grado_discapacidad == 1 ? 'selected' : '' }}
                                                        value="1">
                                                        SI
                                                    </option>
                                                @else
                                                    <option value="0">NO</option>
                                                    <option value="1">SI</option>
                                                @endif
                                            </select>
                                            <label for="gradodiscapacidad">Algún grado de discapacidad <span
                                                    class="red-text">*</span></label>
                                            <small id="gradodiscapacidad-error" class="error red-text"></small>
                                        </div>
                                        <div class="input-field col s12 m6 l6 gradodiscapacidad" style="display:none">
                                            <input class="validate" id="discapacidad" name="discapacidad"
                                                type="text"
                                                value="{{ isset($user->otra_eps) ? $user->descripcion_grado_discapacidad : old('discapacidad') }}">
                                            <label for="discapacidad" class="active">¿Cúal? <span
                                                    class="red-text">*</span></label>
                                            <small id="discapacidad-error" class="error red-text"></small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12 m6 l6">
                                            <select class="" id="madrecabezafamilia"
                                                name="madrecabezafamilia" style="width: 100%" tabindex="-1">
                                                @if (isset($user->mujerCabezaFamilia))
                                                    <option {{ $user->mujerCabezaFamilia == 0 ? 'selected' : '' }}
                                                        value="0">
                                                        NO
                                                    </option>
                                                    <option {{ $user->mujerCabezaFamilia == 1 ? 'selected' : '' }}
                                                        value="1">
                                                        SI
                                                    </option>
                                                @else
                                                    <option value="0">NO</option>
                                                    <option value="1">SI</option>
                                                @endif
                                            </select>
                                            <label for="madrecabezafamilia">¿Madre Cabeza de familia?<span
                                                    class="red-text">*</span></label>
                                            <small id="madrecabezafamilia-error" class="error red-text"></small>
                                        </div>
                                        <div class="input-field col s12 m6 l6">
                                            <select class="" id="desplazadoporviolencia"
                                                name="desplazadoporviolencia" style="width: 100%" tabindex="-1">
                                                @if (isset($user->mujerCabezaFamilia))
                                                    <option {{ $user->mujerCabezaFamilia == 0 ? 'selected' : '' }}
                                                        value="0">
                                                        NO
                                                    </option>
                                                    <option {{ $user->mujerCabezaFamilia == 1 ? 'selected' : '' }}
                                                        value="1">
                                                        SI
                                                    </option>
                                                @else
                                                    <option value="0">NO</option>
                                                    <option value="1">SI</option>
                                                @endif
                                            </select>
                                            <label for="desplazadoporviolencia">¿Desplazado(a) por
                                                violencia?<span class="red-text">*</span></label>
                                            <small id="desplazadoporviolencia-error" class="error red-text"></small>
                                        </div>
                                    </div>
                                    <div class="row center">
                                        <div class="input-field col s12 m12 l12 ">

                                            <div class="switch m-b-md">

                                                <label class="active">Genero<span class="red-text">*</span></label>
                                                <p class="no-p-v">
                                                    <input class="with-gap " name="genero" type="radio"
                                                        id="masculino" value="1"
                                                        {{ isset($user->genero) && $user->genero == 1 ? 'checked' : 'checked' }}>
                                                    <label for="masculino" class="p-h-md">Masculino</label>
                                                    <input class="with-gap" t name="genero" type="radio"
                                                        id="femenino" value="0"
                                                        {{ isset($user->genero) && $user->genero == 0 ? 'checked' : old('genero') }}>
                                                    <label for="femenino" class="p-h-md">Femenino</label>
                                                    <input class="with-gap" name="genero" type="radio"
                                                        id="no_binario" value="2"
                                                        {{ isset($user->genero) && $user->genero == 2 ? 'checked' : old('genero') }}>
                                                    <label for="no_binario" class="p-h-md">No binario</label>
                                                </p>
                                                <small id="genero-error" class="p-v-xs error red-text"></small>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <div class="divider mailbox-divider"></div>
                                    <h5 class="center-align primary-text">Último estudio y ocupaciones</h5>
                                    <div class="col m6 vertical-line">
                                        <h5 class="center-align primary-text">Último estudio</h5>
                                        <div class="row">
                                            <div class="input-field col s12 m6 l6">
                                                <input class="validate" id="institucion" name="institucion"
                                                    type="text"
                                                    value="{{ isset($user->institucion) ? $user->institucion : old('institucion') }}">
                                                <label for="institucion">Institución <span
                                                        class="red-text">*</span></label>
                                                <small id="institucion-error" class="error red-text"></small>
                                            </div>
                                            <div class="input-field col s12 m6 l6 ">
                                                <select class="" id="gradoescolaridad"  name="gradoescolaridad" style="width: 100%" tabindex="-1">
                                                    <option value="">Seleccione grado de escolaridad</option>
                                                    @foreach($gradosescolaridad as $value)
                                                        @if(isset($user->gradoescolaridad_id))
                                                            <option
                                                                value="{{$value->id}}" {{old('gradoescolaridad',$user->gradoescolaridad_id) ==$value->id ? 'selected':''}}>{{$value->nombre}}</option>
                                                        @else
                                                            <option
                                                                value="{{$value->id}}" {{old('gradoescolaridad') ==$value->id ? 'selected':''}}>{{$value->nombre}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <label for="gradoescolaridad">Grado Escolaridad <span
                                                        class="red-text">*</span></label>
                                                <small id="gradoescolaridad-error" class="error red-text"></small>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m6 l6">
                                                <input class="validate" id="titulo" name="titulo" type="text"
                                                    value="{{ isset($user->titulo_obtenido) ? $user->titulo_obtenido : old('titulo') }}">
                                                <label for="titulo">Titulo Obtenido <span
                                                        class="red-text">*</span></label>
                                                <small id="titulo-error" class="error red-text"></small>
                                            </div>
                                            <div class="input-field col s12 m6 l6">
                                                <input class="validate datepicker" id="fechaterminacion"
                                                    name="fechaterminacion" type="text"
                                                    value="{{ isset($user->fecha_terminacion) ? $user->fecha_terminacion->toDateString() : old('fechaterminacion') }}">
                                                <label for="fechaterminacion">Fecha Terminación <span
                                                        class="red-text">*</span></label>
                                                <small id="fechaterminacion-error" class="error red-text"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col m6 l6">
                                        <div class="row">
                                            <div class="col s12 m12 l12">
                                                <h5 class="center-align primary-text">Ocupaciones</h5>
                                                <div class="row">
                                                    <div class="input-field col s12 m8 l8 offset-l3 m-3">
                                                        <select class="js-states browser-default  selectMultipe"
                                                            id="ocupaciones" name="ocupaciones[]"
                                                            style="width: 100%" tabindex="-1" multiple
                                                            onchange="user.getOtraOcupacion(this)">
                                                            @foreach ($ocupaciones as $id => $nombre)
                                                                @if (isset($user))
                                                                    <option value="{{ $id }}"
                                                                        {{ collect(old('ocupaciones', $user->ocupaciones->pluck('id')))->contains($id) ? 'selected' : '' }}>
                                                                        {{ $nombre }}</option>
                                                                @else
                                                                    <option
                                                                        {{ collect(old('ocupaciones'))->contains($id) ? 'selected' : '' }}
                                                                        value="{{ $id }}">{{ $nombre }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        <label for="ocupaciones" class="active">Ocupación <span
                                                                class="red-text">*</span></label>
                                                        <small id="ocupaciones-error" class="error red-text"></small>
                                                    </div>
                                                    <div class="input-field col s12 m8 l8 offset-l3 m-3"
                                                        id="otraocupacion">
                                                        <input class="validate" id="otra_ocupacion"
                                                            name="otra_ocupacion" type="text"
                                                            value="{{ isset($user->otra_ocupacion) ? $user->otra_ocupacion : old('otra_ocupacion') }}">
                                                        <label for="otra_ocupacion" class="active">¿Cuál? <span
                                                                class="red-text">*</span></label>
                                                        <small id="otra_ocupacion-error"
                                                            class="error red-text"></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12 center-align m-t-sm">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember"
                                                id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label black-text text-black" for="remember">
                                                Acepto los <a class="m-t-sm secondary-text center-align"
                                                    href="{{ route('terminos') }}" target="_blank">términos de uso y
                                                    política de confidencialidad de los datos.</a>
                                            </label>
                                        </div>
                                        <small id="remember-error" class="error red-text"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col s12 center-align m-t-sm">
                                <button type="submit" id="login-btn"
                                    class="waves-effect waves-light btn bg-secondary center-align">
                                    <i class="material-icons left">send</i>
                                    Enviar
                                </button>
                                <button type="reset" id="login-btn"
                                    class="modal-action modal-open waves-effect bg-danger btn center-align">
                                    <i class="material-icons left">backspace</i>
                                    Regresar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modalvalidationuser" class="modal">
        <form id="formValidateCredentials" method="POST" action="{{ route('user.verify') }}"
            onsubmit="return checkSubmit()">
            @csrf
            <div class="modal-content">
                <h5>Antes de registrarse confirme que su usuario no haya sido creado</h5>
                <small>Ingrese los siguientes datos para confirmar que su usuario será realmente nuevo</small>
                <div class="row">
                    <div class="input-field col m12 s12 l12">
                        <select name="document_type" id="document_type" style="width: 100%" tabindex="-1">
                            <option value="">Seleccione tipo documento</option>
                            @foreach ($tiposdocumentos as $value)
                                <option value="{{ $value->id }}"
                                    {{ old('document_type') == $value->id ? 'selected' : '' }}>{{ $value->nombre }}
                                </option>
                            @endforeach
                        </select>
                        <label for="document_type">Tipo Documento <span class="red-text">*</span></label>
                        <small id="document_type-error" class="error red-text"></small>
                    </div>
                    <div class="input-field col l12 m12 s12">
                        <input id="document" name="document" type="text"
                            value="{{ isset($documento) ? $documento : '' }}"
                            {{ isset($documento) ? 'readonly' : '' }}>
                        <label for="document">Documento <span class="red-text">*</span></label>
                        <small id="document-error" class="error red-text"></small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" class="modal-action btn-flat bg-secondary white-text" value="Validar">
                <a href="{{ route('/') }}" class="modal-action modal-close waves-effect btn-flat">Regresar al
                    inicio</a>
            </div>
        </form>
    </div>
@endsection
@push('script')
<script>
    $(document).ready(function() {
    $('#modalvalidationuser').openModal({
        opacity: 0.7,
        in_duration: 350,
        out_duration: 250,
        ready: undefined,
        complete: undefined,
        dismissible: false,
        starting_top: '10%',
        ending_top: '10%'
    });
    user.getOtraOcupacion();
    $('.selectMultipe').select2({
        language: "es",
    });

});
    </script>
@endpush
