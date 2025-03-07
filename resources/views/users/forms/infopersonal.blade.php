<div class="row">
    <div class="col m6 vertical-line">
        <h5 class="text-primarycolor center-align primary-text">Información Documento Identidad</h5>
        <div class="row">
            <div class="input-field col l6 m10 s12 offset-m1">
                <select  name="txttipo_documento" style="width: 100%" tabindex="-1">
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
            <div class="input-field col l6 m10 s12 offset-m1">
                @if($view == 'create')
                <input id="txtdocumento" name="txtdocumento"  type="text" value="{{isset($documento) ? $documento : ''}}" {{isset($documento) ? 'readonly' : ''}}>
                @elseif(isset($user->documento))
                <input id="txtdocumento" name="txtdocumento"  type="text" value="{{$user->documento}}">
                @endif
                <label for="txtdocumento">Documento <span class="red-text">*</span></label>
                <small id="txtdocumento-error" class="error red-text"></small>
            </div>
        </div>
        <div class="row">
            <div class="input-field col l6 m10 s12 offset-m1">
                <select class="js-states browser-default select2 " id="txtdepartamentoexpedicion" name="txtdepartamentoexpedicion" onchange="user.getCiudadExpedicion()" style="width: 100%" tabindex="-1">
                    <option value="">Seleccione departamento</option>
                    @foreach($departamentos as $value)

                        @if(isset($user->ciudadexpedicion->departamento_id))
                            <option value="{{$value->id}}" {{old('txtdepartamentoexpedicion',$user->ciudadexpedicion->departamento_id) ==$value->id ? 'selected':''}}>{{$value->nombre}}</option>
                        @else

                            <option value="{{$value->id}}" {{old('txtdepartamentoexpedicion') == $value->id  ? 'selected':''}}>{{$value->nombre}}</option>
                        @endif
                    @endforeach
                </select>

                <label class="active" for="txtdepartamentoexpedicion">Departamento de Expedición <span class="red-text">*</span></label>
                <small id="txtdepartamentoexpedicion-error" class="error red-text"></small>
            </div>
            <div class="input-field col l6 m10 s12 offset-m1">
                <select class="js-states browser-default select2" id="txtciudadexpedicion" name="txtciudadexpedicion" style="width: 100%" tabindex="-1">
                    <option value="">Seleccione Primero el Departamento</option>
                </select>
                <label class="active" for="txtciudadexpedicion">Ciudad de Expedición <span class="red-text">*</span></label>
                <small id="txtciudadexpedicion-error" class="error red-text"></small>
            </div>
        </div>
        <h5 class="center primary-text">Datos de contacto</h5>
        <div class="row">
            <div class="input-field col s12">
                <input class="validate" id="txtemail" name="txtemail" type="email" value="{{ isset($user->email) ? $user->email : old('txtemail')}}">
                <label for="txtemail">Correo <span class="red-text">*</span></label>
                <small id="txtemail-error" class="error red-text"></small>
            </div>
        </div>
        <div class="row">
            <div class="input-field col l6 m10 s12 offset-m1">
                <input class="validate" id="txttelefono" name="txttelefono" type="tel" value="{{ isset($user->telefono) ? $user->telefono : old('txttelefono')}}">
                <label for="txttelefono">Telefono</label>
                <small id="txttelefono-error"  class="error red-text"></small>
            </div>
            <div class="input-field col l6 m10 s12 offset-m1">
                <input class="validate" id="txtcelular" name="txtcelular" type="tel"  value="{{ isset($user->celular) ? $user->celular : old('txtcelular')}}">
                <label for="txtcelular">Celular <span class="red-text">*</span></label>
                <small id="txtcelular-error"  class="error red-text"></small>
            </div>
        </div>
        <h5 class="center primary-text">Datos de residencia</h5>
        <div class="row">
            <div class="input-field col l6 m10 s12 offset-m1">
                <select class="js-states browser-default select2" id="txtdepartamento" name="txtdepartamento" onchange="user.getCiudad()" style="width: 100%" tabindex="-1">
                    <option value="">Seleccione departamento</option>
                    @foreach($departamentos as $value)
                        @if(isset($user->ciudad->departamento_id))
                            <option value="{{$value->id}}" {{old('txtdepartamento',$user->ciudad->departamento_id) ==$value->id ? 'selected':''}}>{{$value->nombre}}</option>
                        @else
                            <option value="{{$value->id}}" {{old('txtdepartamento') == $value->id  ? 'selected':''}}>{{$value->nombre}}</option>
                        @endif
                    @endforeach
                </select>
                <label class="active" for="txtdepartamento">Departamento de Residencia <span class="red-text">*</span></label>
                <small id="txtdepartamento-error" class="error red-text"></small>
            </div>
            <div class="input-field col l6 m10 s12 offset-m1">
                <select class="js-states browser-default select2" id="txtciudad" name="txtciudad" style="width: 100%" tabindex="-1">
                    <option value="">Seleccione Primero el Departamento</option>
                </select>
                <label class="active" for="txtciudad">Ciudad de Residencia <span class="red-text">*</span></label>
                <small id="txtciudad-error" class="error red-text"></small>
            </div>
        </div>
        <div class="row">
            <div class="input-field col l12 m10 s12 offset-m1">
                <input class="validate" id="txtbarrio" name="txtbarrio" type="text"  value="{{ isset($user->barrio) ? $user->barrio : old('txtbarrio')}}">
                <label for="txtbarrio">Barrio <span class="red-text">*</span></label>
                <small id="txtbarrio-error"  class="error red-text"></small>
            </div>

        </div>
    </div>
    <div class="col m6 l6">
        <div class="row">
            <h5 class="center-align primary-text">Datos de identificación</h5>

            <div class="input-field col l6 m10 s12 offset-m1">
                <input class="validate" id="txtnombres" name="txtnombres" type="text"  value="{{ isset($user->nombres) ? $user->nombres : old('txtnombres')}}">
                <label for="txtnombres">Nombres <span class="red-text">*</span></label>
                <small id="txtnombres-error" class="error red-text"></small>
            </div>
            <div class="input-field col l6 m10 s12 offset-m1">
                <input class="validate" id="txtapellidos" name="txtapellidos" type="text" value="{{ isset($user->apellidos) ? $user->apellidos : old('txtapellidos')}}">
                <label for="txtapellidos">Apellidos <span class="red-text">*</span></label>
                <small id="txtapellidos-error" class="error red-text"></small>
            </div>

            <div class="input-field col l6 m10 s12 offset-m1">
                <input class="validate datepicker" id="txtfecha_nacimiento" name="txtfecha_nacimiento" type="text" value="{{ isset($user->fechanacimiento) ? $user->fechanacimiento->toDateString() : old('txtfecha_nacimiento')}}">
                <label for="txtfecha_nacimiento">Fecha de Nacimiento <span class="red-text">*</span></label>
                <small id="txtfecha_nacimiento-error"  class="error red-text"></small>
            </div>
            <div class="input-field col l6 m10 s12 offset-m1">
                <select class="js-states browser-default select2" id="txtgruposanguineo" name="txtgruposanguineo" style="width: 100%" tabindex="-1" >
                    <option value="">Seleccione grupo sanguíneo </option>
                    @foreach($gruposanguineos as $value)

                        @if(isset($user->grupoSanguineo->id))
                            <option value="{{$value->id}}" {{old('txtgruposanguineo',$user->grupoSanguineo->id) ==$value->id ? 'selected':''}}>{{$value->nombre}}</option>
                        @else
                        <option value="{{$value->id}}" {{old('txtgruposanguineo') == $value->id  ? 'selected':''}}>{{$value->nombre}}</option>
                        @endif
                    @endforeach
                </select>
                <label class="active" for="txtgruposanguineo">Grupo Sanguíneo <span class="red-text">*</span></label>
                <small id="txtgruposanguineo-error"  class="error red-text"></small>
            </div>
        </div>
        <div class="row">
            <div class="input-field col l6 m10 s12 offset-m1">
                <select id="txtestrato" name="txtestrato" style="width: 100%" tabindex="-1">
                    <option value="">Seleccione estrato</option>
                    @for($i =1; $i <= 6; $i++)
                        @if(isset($user->estrato))
                        <option value="{{ $i }}" {{old('txtestrato',$user->estrato) == $i ? 'selected':''}}>{{$i}}</option>
                        @else
                        <option value="{{ $i }}"  {{old('txtestrato') == $i ? 'selected':''}}>{{$i}}</option>
                        @endif
                    @endfor
                </select>
                <label for="txtestrato">Estrato <span class="red-text">*</span></label>
                <small id="txtestrato-error"  class="error red-text"></small>
            </div>
            <div class="input-field col l6 m10 s12 offset-m1">

                <select class="js-states browser-default select2" id="txtetnias" name="txtetnias" style="width: 100%" tabindex="-1">
                    <option value="">Seleccione Etnia</option>
                        @foreach($etnias as $id => $nombre)
                            @if(isset($user->etnia->id))
                            <option value="{{$id}}" {{old('txtetnias',$user->etnia->id) ==$id ? 'selected':''}}>{{$nombre}}</option>
                            @else
                                <option value="{{$id}}" {{old('txtetnias') ==$id ? 'selected':''}}>{{$nombre}}</option>
                            @endif
                        @endforeach
                    </select>
                    <label class="active" for="txtetnias">Etnias <span class="red-text">*</span></label>
                    <small id="txtetnias-error"  class="error red-text"></small>
            </div>
        </div>
        <div class="row">
            <div class="input-field col l6 m10 s12 offset-m1" >
                <select class="js-states browser-default select2" id="txteps" name="txteps" style="width: 100%" tabindex="-1" onchange="user.getOtraEsp(this)">
                    <option value="">Seleccione eps</option>
                    @foreach($eps as $value)
                        @if(isset($user->eps_id))
                            <option value="{{$value->id}}" {{old('txteps',$user->eps_id) ==  $value->id ? 'selected':''}}>{{$value->nombre}}</option>
                        @else
                            <option value="{{$value->id}}" {{old('txteps') == $value->id  ? 'selected':''}}>{{$value->nombre}}</option>
                        @endif
                    @endforeach
                </select>
                <label class="active" for="txteps" >Eps <span class="red-text">*</span></label>
                <small id="txteps-error"  class="error red-text"></small>
            </div>
            <div class="input-field col l6 m10 s12 offset-m1 otraeps"  style="display:none">
                <input class="validate" id="txtotraeps" name="txtotraeps" type="text" value="{{ isset($user->otra_eps) ? $user->otra_eps : old('txtotraeps')}}">
                <label for="txtotraeps" class="active">Otra Eps <span class="red-text">*</span></label>
                <small id="txtotraeps-error"  class="error red-text"></small>
            </div>
        </div>
        <div class="row">
            <div class="input-field col l6 m10 s12 offset-m1">
                <select class="" id="txtgrado_discapacidad" name="txtgrado_discapacidad" style="width: 100%" tabindex="-1" onchange="user.getGradoDiscapacidad(this)">
                    @if(isset($user->grado_discapacidad))
                    <option {{$user->grado_discapacidad == 0 ?'selected' : ''}} value="0">NO </option>
                    <option {{$user->grado_discapacidad == 1 ?'selected' : ''}} value="1">SI </option>
                    @else
                        <option value="0">NO </option>
                        <option value="1">SI </option>
                    @endif
                </select>
                <label for="txtgrado_discapacidad">Algún grado de discapacidad <span class="red-text">*</span></label>
                <small id="txtgrado_discapacidad-error" class="error red-text"></small>
            </div>
            <div class="input-field col l6 m10 s12 offset-m1 gradodiscapacidad"  style="display:none">
                <input class="validate" id="txtdiscapacidad" name="txtdiscapacidad" type="text" value="{{ isset($user->otra_eps) ? $user->descripcion_grado_discapacidad : old('txtdiscapacidad')}}">
                <label for="txtdiscapacidad" class="active">¿Cúal? <span class="red-text">*</span></label>
                <small id="txtdiscapacidad-error"  class="error red-text"></small>
            </div>
        </div>
        <div class="row center">
            <div class="input-field col s12 m12 l12 ">
                <div class="switch m-b-md">
                    <label class="active">Genero<span class="red-text">*</span></label>
                    <p class="no-p-v">
                        <input  class="with-gap " name="txtgenero" type="radio" id="masculino" value="1" {{isset($user->genero) && $user->genero == 1 ? 'checked' : old('txtgenero')}}>
                        <label for="masculino"class="p-h-md">Masculino</label>
                        <input class="with-gap"t name="txtgenero" type="radio" id="femenino" value="0" {{isset($user->genero) && $user->genero == 0 ? 'checked' : old('txtgenero')}}>
                        <label  for="femenino" class="p-h-md">Femenino</label>
                        <input class="with-gap" name="txtgenero" type="radio" id="no_binario" value="2" {{isset($user->genero) && $user->genero == 2 ? 'checked' : old('txtgenero')}}>
                        <label for="no_binario" class="p-h-md">Binario</label>
                    </p>
                    <small id="txtgenero-error"  class="error red-text"></small>
                </div>
            </div>
        </div>
    </div>
</div>
