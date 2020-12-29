@extends('spa.layouts.app')

@section('meta-tittle', 'Registro para usuarios nuevos')
@section('meta-content', 'Registro para usuarios nuevos')
@section('content-spa')
<main class="mn-inner inner-active-sidebar no-padding">
	<div class="section white">
		<div class="container">
			<div class="row  no-m-t no-m-b">
				<div class="col s12 m12 l12 ">
                    <h3 class="text-primarycolor center hand-of-Sean-fonts orange-text text-darken-3">Registro de usuarios nuevos</h3>
                    <ul class="collapsible">
                        <li>
                            <div class="collapsible-header">¿Por qué registrarse como usuario?</div>
                            <div class="collapsible-body"><p>Registrarse es el primer paso para inscribirse a los servicios ofrecios por la Red Tecnoparque Colombia. Es importante que la información ingresada sea veridica y confiable pues de ésta dependerá la calidad del proceso de ingreso.</p></div>
                        </li>
                    </ul>
                    <div class="content">
                        <form id="formRegisterUser"   method="POST" action="{{ route('register.request') }}" onsubmit="return checkSubmit()">
                            @csrf
                            <div class="row">
                                <h5 class="text-primarycolor center-align hand-of-Sean-fonts orange-text text-darken-3">Información básica</h5>
                                <div class="col m6 vertical-line">
                                    <h5 class="text-primarycolor center-align hand-of-Sean-fonts orange-text text-darken-3">Información Documento Identidad</h5>
                                    <div class="row">
                                        <div class="input-field col m6 s12">
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
                                        <div class="input-field col m6 s12">

                                            <input id="txtdocumento" name="txtdocumento"  type="text" value="{{isset($documento) ? $documento : ''}}" readonly>
                                            <label for="txtdocumento">Documento <span class="red-text">*</span></label>
                                            <small id="txtdocumento-error" class="error red-text"></small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col m6 s12">
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
                                        <div class="input-field col m6 s12">
                                            <select class="js-states browser-default select2" id="txtciudadexpedicion" name="txtciudadexpedicion" style="width: 100%" tabindex="-1">
                                                <option value="">Seleccione Primero el Departamento</option>
                                            </select>
                                            <label class="active" for="txtciudadexpedicion">Ciudad de Expedición <span class="red-text">*</span></label>
                                            <small id="txtciudadexpedicion-error" class="error red-text"></small>
                                        </div>
                                    </div>
                                    <h5 class="text-primarycolor center hand-of-Sean-fonts orange-text text-darken-3">Datos de contacto</h5>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input class="validate" id="txtemail" name="txtemail" type="email" value="{{ isset($user->email) ? $user->email : old('txtemail')}}">
                                            <label for="txtemail">Correo <span class="red-text">*</span></label>
                                            <small id="txtemail-error" class="error red-text"></small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12 m6 l6">
                                            <input class="validate" id="txttelefono" name="txttelefono" type="tel" value="{{ isset($user->telefono) ? $user->telefono : old('txttelefono')}}">
                                            <label for="txttelefono">Telefono</label>
                                            <small id="txttelefono-error"  class="error red-text"></small>
                                        </div>
                                        <div class="input-field col s12 m6 l6">
                                            <input class="validate" id="txtcelular" name="txtcelular" type="tel"  value="{{ isset($user->celular) ? $user->celular : old('txtcelular')}}">
                                            <label for="txtcelular">Celular</label>
                                            <small id="txtcelular-error"  class="error red-text"></small>
                                        </div>
                                    </div>
                                    <h5 class="text-primarycolor center hand-of-Sean-fonts orange-text text-darken-3">Datos de residencia</h5>
                                    <div class="row">
                                        <div class="input-field col s12 m6 l6">
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
                                        <div class="input-field col s12 m6 l6">
                                            <select class="js-states browser-default select2" id="txtciudad" name="txtciudad" style="width: 100%" tabindex="-1">
                                                <option value="">Seleccione Primero el Departamento</option>
                                            </select>
                                            <label class="active" for="txtciudad">Ciudad de Residencia <span class="red-text">*</span></label>
                                            <small id="txtciudad-error" class="error red-text"></small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12 m6 l6">
                                            <input class="validate" id="txtbarrio" name="txtbarrio" type="text"  value="{{ isset($user->barrio) ? $user->barrio : old('txtbarrio')}}">
                                            <label for="txtbarrio">Barrio <span class="red-text">*</span></label>
                                            <small id="txtbarrio-error"  class="error red-text"></small>
                                        </div>
                                        <div class="input-field col s12 m6 l6">
                                            <input class="validate" id="txtdireccion" name="txtdireccion" type="text"  value="{{ isset($user->direccion) ? $user->direccion : old('txtdireccion')}}">
                                            <label for="txtdireccion">Dirección <span class="red-text">*</span></label>
                                            <small id="txtdireccion-error"  class="error red-text"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col m6 l6">
                                    <div class="row">
                                        <h5 class="text-primarycolor center-align hand-of-Sean-fonts orange-text text-darken-3">Datos de identificación</h5>

                                        <div class="input-field col s12 m6 l6">
                                            <input class="validate" id="txtnombres" name="txtnombres" type="text"  value="{{ isset($user->nombres) ? $user->nombres : old('txtnombres')}}">
                                            <label for="txtnombres">Nombres <span class="red-text">*</span></label>
                                            <small id="txtnombres-error" class="error red-text"></small>
                                        </div>
                                        <div class="input-field col s12 m6 l6">
                                            <input class="validate" id="txtapellidos" name="txtapellidos" type="text" value="{{ isset($user->apellidos) ? $user->apellidos : old('txtapellidos')}}">
                                            <label for="txtapellidos">Apellidos <span class="red-text">*</span></label>
                                            <small id="txtapellidos-error" class="error red-text"></small>
                                        </div>

                                        <div class="input-field col s12 m6 l6">
                                            <input class="validate datepicker" id="txtfecha_nacimiento" name="txtfecha_nacimiento" type="text" value="{{ isset($user->fechanacimiento) ? $user->fechanacimiento->toDateString() : old('txtfecha_nacimiento')}}">
                                            <label for="txtfecha_nacimiento">Fecha de Nacimiento <span class="red-text">*</span></label>
                                            <small id="txtfecha_nacimiento-error"  class="error red-text"></small>
                                        </div>
                                        <div class="input-field col s12 m6 l6">
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
                                        <div class="input-field col s12 m6 l6">
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
                                        <div class="input-field col s12 m6 l6">

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
                                        <div class="input-field col s12 m6 l6" >
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
                                        <div class="input-field col s12 m6 l6 otraeps"  style="display:none">
                                            <input class="validate" id="txtotraeps" name="txtotraeps" type="text" value="{{ isset($user->otra_eps) ? $user->otra_eps : old('txtotraeps')}}">
                                            <label for="txtotraeps" class="active">Otra Eps <span class="red-text">*</span></label>
                                            <small id="txtotraeps-error"  class="error red-text"></small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12 m6 l6">
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
                                        <div class="input-field col s12 m6 l6 gradodiscapacidad"  style="display:none">
                                            <input class="validate" id="txtdiscapacidad" name="txtdiscapacidad" type="text" value="{{ isset($user->otra_eps) ? $user->descripcion_grado_discapacidad : old('txtdiscapacidad')}}">
                                            <label for="txtdiscapacidad" class="active">¿Cúal? <span class="red-text">*</span></label>
                                            <small id="txtdiscapacidad-error"  class="error red-text"></small>
                                        </div>
                                    </div>
                                    <div class="row center">
                                        <div class="input-field col s12 m12 l12 ">
                                            <div class="switch m-b-md">
                                                <label class="active">Genero<span class="red-text">*</span></label>
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
                                                <small id="txtgenero-error"  class="error red-text"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <div class="divider mailbox-divider"></div>
                                    <h5 class="text-primarycolor center-align hand-of-Sean-fonts orange-text text-darken-3">Último estudio y ocupaciones</h5>
                                    <div class="col m6 vertical-line">
                                        <h5 class="text-primarycolor center-align hand-of-Sean-fonts orange-text text-darken-3">Último estudio</h5>
                                        <div class="row">
                                            <div class="input-field col s12 m6 l6">
                                                <input class="validate" id="txtinstitucion" name="txtinstitucion" type="text"  value="{{ isset($user->institucion) ? $user->institucion : old('txtinstitucion')}}">
                                                <label for="txtinstitucion">Institución <span class="red-text">*</span></label>

                                                <small id="txtinstitucion-error" class="error red-text"></small>
                                            </div>
                                            <div class="input-field col s12 m6 l6 ">
                                                <select class="" id="txtgrado_escolaridad" name="txtgrado_escolaridad" style="width: 100%" tabindex="-1">
                                                    <option value="">Seleccione grado de escolaridad</option>
                                                    @foreach($gradosescolaridad as $value)
                                                        @if(isset($user->gradoescolaridad_id))
                                                        <option value="{{$value->id}}" {{old('txtgrado_escolaridad',$user->gradoescolaridad_id) ==$value->id ? 'selected':''}}>{{$value->nombre}}</option>
                                                        @else
                                                            <option value="{{$value->id}}" {{old('txtgrado_escolaridad') ==$value->id ? 'selected':''}}>{{$value->nombre}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <label for="txtgrado_escolaridad">Grado Escolaridad <span class="red-text">*</span></label>
                                                <small id="txtgrado_escolaridad-error" class="error red-text"></small>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m6 l6">
                                                <input class="validate" id="txttitulo" name="txttitulo" type="text"  value="{{ isset($user->titulo_obtenido) ? $user->titulo_obtenido : old('txttitulo')}}">
                                                <label for="txttitulo">Titulo Obtenido <span class="red-text">*</span></label>
                                                <small id="txttitulo-error" class="error red-text"></small>
                                            </div>
                                            <div class="input-field col s12 m6 l6">
                                                <input class="validate datepicker" id="txtfechaterminacion" name="txtfechaterminacion" type="text" value="{{ isset($user->fecha_terminacion) ? $user->fecha_terminacion->toDateString() : old('txtfechaterminacion')}}">
                                                <label for="txtfechaterminacion">Fecha Terminación <span class="red-text">*</span></label>
                                                <small id="txtfechaterminacion-error" class="error red-text"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col m6 l6">
                                        <div class="row">
                                            <div class="col s12 m12 l12">
                                                <h5 class="text-primarycolor center-align hand-of-Sean-fonts orange-text text-darken-3">Ocupaciones</h5>
                                                <div class="row">
                                                    <div class="input-field col s12 m8 l8 offset-l3 m-3">
                                                        <select class="js-states browser-default  selectMultipe" id="txtocupaciones" name="txtocupaciones[]" style="width: 100%" tabindex="-1" multiple onchange="user.getOtraOcupacion(this)">
                                                            @foreach($ocupaciones as $id => $nombre)
                                                                @if(isset($user))
                                                                <option value="{{$id}}" {{collect(old('txtocupaciones',$user->ocupaciones->pluck('id')))->contains($id) ? 'selected' : ''  }} >{{$nombre}}</option>
                                                                @else
                                                                    <option {{collect(old('txtocupaciones'))->contains($id) ? 'selected' : ''  }}  value="{{$id}}" >{{$nombre}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        <label for="txtocupaciones" class="active">Ocupación <span class="red-text">*</span></label>
                                                        <small id="txtocupaciones-error" class="error red-text"></small>
                                                    </div>
                                                    <div class="input-field col s12 m8 l8 offset-l3 m-3" id="otraocupacion">
                                                        <input class="validate" id="txtotra_ocupacion" name="txtotra_ocupacion" type="text"  value="{{ isset($user->otra_ocupacion) ? $user->otra_ocupacion : old('txtotra_ocupacion')}}">
                                                        <label for="txtotra_ocupacion" class="active">¿Cuál? <span class="red-text">*</span></label>
                                                        <small id="txtotra_ocupacion-error" class="error red-text"></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row center">
                                <div class="col s12 m12 l12">
                                    <div class="divider mailbox-divider"></div>
                                    <h5 class="text-primarycolor center-align hand-of-Sean-fonts orange-text text-darken-3">Otros datos</h5>
                                    <p class="p-v-xs">
                                        <input checked="" class="txttipousuario" id="txttalento" name="txttipousuario" type="radio" value="talento" onchange="user.checkedTypeUser()" {{ isset($idea->pregunta1) && $idea->pregunta1 == 1 ? 'checked' : old('pregunta1') == 1 ? 'checked':''}}/>
                                        <label align="justify" for="txttalento" class="black-text text-black">
                                            Deseo presentar una idea de proyecto.
                                        </label>
                                    </p>
                                    <p class="p-v-xs">
                                        <input class="txttipousuario" id="txtcontratista" name="txttipousuario" type="radio" value="contratista" onchange="user.checkedTypeUser()" {{ isset($idea->pregunta2) && $idea->pregunta2 == 2 ? 'checked' : old('pregunta2') == 2 ? 'checked':''}}/>
                                        <label align="justify" for="txtcontratista" class="black-text text-black">
                                            Soy contratista de la Red Tecnoparque Colombia.
                                        </label>
                                    </p>
                                    <small id="txttipousuario-error" class="error red-text"></small>
                                </div>
                            </div>
                            <!-- talento -->
                            <div class="row talento">
                                <div class="col s12 m8 l8 offset-l2 offset-m2">
                                    <h5 class="text-primarycolor center-align hand-of-Sean-fonts orange-text text-darken-3">Información talento</h5>
                                    <div class="divider mailbox-divider"></div>
                                    <div class="row">
                                        <div class="input-field col s12 m4 l4 ">
                                            <select class="js-states browser-default select2 select2-hidden-accessible" id="txttipotalento" name="txttipotalento" style="width: 100%" tabindex="-1" onchange="tipoTalento.getSelectTipoTalento(this)">
                                                @if(isset($user->talento->tipotalento->id) && ((session()->get('login_role') == App\User::IsAdministrador() || session()->get('login_role') == App\User::IsDinamizador())))
                                                    <option value="{{$user->talento->tipotalento->id}}" selected>{{$user->talento->tipotalento->nombre}}</option>
                                                @else
                                                    <option value="">Seleccione tipo de talento</option>
                                                    @foreach($tipotalentos as $id => $nombre)
                                                        @if(isset($user->talento->tipotalento->id))
                                                        <option value="{{$id}}" {{old('txttipotalento',$user->talento->tipotalento->id) ==$id ? 'selected':''}}>{{$nombre}}</option>
                                                        @else
                                                            <option value="{{$id}}" {{old('txttipotalento') ==$id ? 'selected':''}}>{{$nombre}}</option>
                                                        @endif

                                                    @endforeach
                                                @endif
                                            </select>
                                            <label for="txttipotalento" class="active">Tipo Talento <span class="red-text">*</span></label>
                                            <small id="txttipotalento-error"  class="error red-text"></small>
                                        </div>
                                        <div class="input-field col s12 m8 l8" >
                                            <div class="row">
                                                <div class="input-field col s12 m12 l12 valign-wrapper selecttipotalento" style="display:block">
                                                    <h5>Selecciona un tipo de talento</h5>
                                                </div>
                                            </div>
                                            <div class="row aprendizSena" style="display:none">
                                                <div class="input-field col s12 m12 l12"  >
                                                    <select class=" js-states browser-default select2 select2-hidden-accessible" id="txtregional_aprendiz" name="txtregional_aprendiz" style="width: 100%" tabindex="-1" onchange="tipoTalento.getCentroFormacionAprendiz()" >
                                                        @if(session()->get('login_role') == App\User::IsAdministrador() || session()->get('login_role') == App\User::IsDinamizador())
                                                            @if(isset($user->talento->entidad->centro->regional->id))
                                                                <option value="{{$user->talento->entidad->centro->regional->id}}" selected="">{{$user->talento->entidad->centro->regional->nombre}}</option>
                                                            @else
                                                                <option value="">No se encontraron resultados</option>
                                                            @endif
                                                        @else
                                                            <option value="">Seleccione regional</option>
                                                            @foreach($regionales as $id => $nombre)
                                                                @if(isset($user->talento->entidad->centro->regional->id))
                                                                    <option value="{{$id}}" {{old('txtregional_aprendiz',$user->talento->entidad->centro->regional->id) ==$id ? 'selected':''}}>{{$nombre}}</option>
                                                                @else
                                                                    <option value="{{$id}}" {{old('txtregional_aprendiz') ==$id ? 'selected':''}}>{{$nombre}}</option>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <label for="txtregional_aprendiz" class="active">Regional <span class="red-text">*</span></label>
                                                    <small id="txtregional_aprendiz-error"  class="error red-text"></small>
                                                </div>
                                                <div class="input-field col s12 m12 l12">

                                                    <select class="js-states browser-default select2 select2-hidden-accessible" id="txtcentroformacion_aprendiz" name="txtcentroformacion_aprendiz" style="width: 100%" tabindex="-1" >
                                                        <option value="">Seleccione Primero la regional</option>
                                                    </select>
                                                    <label for="txtcentroformacion_aprendiz" class="active">Centro de formación <span class="red-text">*</span></label>
                                                    <small id="txtcentroformacion_aprendiz-error"  class="error red-text"></small>
                                                </div>
                                                <div class="input-field col s12 m12 l12 ">

                                                    <input class="validate" id="txtprogramaformacion_aprendiz" name="txtprogramaformacion_aprendiz" type="text"  value="{{ isset($user->talento->programa_formacion) ? $user->talento->programa_formacion : old('txtprogramaformacion_aprendiz')}}" {{session()->get('login_role') == App\User::IsAdministrador() || session()->get('login_role') == App\User::IsDinamizador()  ? 'readonly' : ''}}>
                                                    <label for="txtprogramaformacion_aprendiz">Programa de Formación <span class="red-text">*</span></label>
                                                    <small id="txtprogramaformacion_aprendiz-error"  class="error red-text"></small>
                                                </div>
                                            </div>
                                            <div class="row egresadoSena" style="display:none">
                                                <div class="input-field col s12 m12 l12" >
                                                    <select class=" js-states browser-default select2 select2-hidden-accessible" id="txtregional_egresado" name="txtregional_egresado" style="width: 100%" tabindex="-1" onchange="tipoTalento.getCentroFormacionEgresadoSena()">
                                                        @if(session()->get('login_role') == App\User::IsAdministrador() || session()->get('login_role') == App\User::IsDinamizador())
                                                            @if(isset($user->talento->entidad->centro->regional->id))
                                                                <option value="{{$user->talento->entidad->centro->regional->id}}" selected="">{{$user->talento->entidad->centro->regional->nombre}}</option>
                                                            @else
                                                                <option value="">No se encontraron resultados</option>
                                                            @endif
                                                        @else
                                                            <option value="">Seleccione regional</option>
                                                            @foreach($regionales as $id => $nombre)
                                                                @if(isset($user->talento->entidad->centro->regional->id))
                                                                    <option value="{{$id}}" {{old('txtregional_egresado',$user->talento->entidad->centro->regional->id) ==$id ? 'selected':''}}>{{$nombre}}</option>
                                                                @else
                                                                    <option value="{{$id}}" {{old('txtregional_egresado') ==$id ? 'selected':''}}>{{$nombre}}</option>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <label for="txtregional_egresado" class="active">Regional <span class="red-text">*</span></label>
                                                    <small id="txtregional_egresado-error"  class="error red-text"></small>
                                                </div>
                                                <div class="input-field col s12 m12 l12">

                                                    <select class="js-states browser-default select2 select2-hidden-accessible" id="txtcentroformacion_egresado" name="txtcentroformacion_egresado" style="width: 100%" tabindex="-1" >
                                                        <option value="">Seleccione Primero la regional</option>
                                                    </select>
                                                    <label for="txtcentroformacion_egresado" class="active">Centro de formación <span class="red-text">*</span></label>
                                                    <small id="txtcentroformacion_egresado-error"  class="error red-text"></small>
                                                </div>
                                                <div class="input-field col s12 m12 l12 ">

                                                    <input class="validate" id="txtprogramaformacion_egresado" name="txtprogramaformacion_egresado" type="text"  value="{{ isset($user->talento->programa_formacion) ? $user->talento->programa_formacion : old('txtprogramaformacion_egresado')}}" {{session()->get('login_role') == App\User::IsAdministrador() || session()->get('login_role') == App\User::IsDinamizador()  ? 'readonly' : ''}}>
                                                    <label for="txtprogramaformacion_egresado">Programa de Formación <span class="red-text">*</span></label>
                                                    <small id="txtprogramaformacion_egresado-error"  class="error red-text"></small>
                                                </div>
                                                <div class="input-field col s12 m12 l12 ">
                                                    <select class="" id="txttipoformacion" name="txttipoformacion" style="width: 100%" tabindex="-1" >
                                                        @if(session()->get('login_role') == App\User::IsAdministrador() || session()->get('login_role') == App\User::IsDinamizador())
                                                            @if(isset($user->talento->tipoformacion->id))
                                                                <option value="{{$user->talento->tipoformacion->id}}" selected="">{{$user->talento->tipoformacion->nombre}}</option>
                                                            @else
                                                                <option value="">No se encontraron resultados</option>
                                                            @endif
                                                        @else
                                                            <option value="">Seleccione Tipo Formación</option>
                                                            @foreach($tipoformaciones as $id => $nombre)
                                                                @if(isset($user->talento->tipoformacion->id))
                                                                    <option value="{{$id}}" {{old('txttipoformacion',$user->talento->tipoformacion->id) ==$id ? 'selected':''}}>{{$nombre}}</option>
                                                                @else
                                                                <option value="{{$id}}" {{old('txttipoformacion') ==$id ? 'selected':''}}>{{$nombre}}</option>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <label for="txttipoformacion">Tipo Formación <span class="red-text">*</span></label>
                                                    <small id="txttipoformacion-error"  class="error red-text"></small>
                                                </div>
                                            </div>

                                            <div class="row funcionarioSena" style="display:none">
                                                <div class="input-field col s12 m12 l12" >
                                                    <select class=" js-states browser-default select2 select2-hidden-accessible" id="txtregional_funcionarioSena" name="txtregional_funcionarioSena" style="width: 100%" tabindex="-1" onchange="tipoTalento.getCentroFormacionFuncionarioSena()" >
                                                        @if(session()->get('login_role') == App\User::IsAdministrador() || session()->get('login_role') == App\User::IsDinamizador())
                                                            @if(isset($user->talento->entidad->centro->regional->id))
                                                                <option value="{{$user->talento->entidad->centro->regional->id}}" selected="">{{$user->talento->entidad->centro->regional->nombre}}</option>
                                                            @else
                                                                <option value="">No se encontraron resultados</option>
                                                            @endif
                                                        @else
                                                            <option value="">Seleccione regional</option>
                                                            @foreach($regionales as $id => $nombre)
                                                                @if(isset($user->talento->entidad->centro->regional->id))
                                                                    <option value="{{$id}}" {{old('txtregional_funcionarioSena',$user->talento->entidad->centro->regional->id) ==$id ? 'selected':''}}>{{$nombre}}</option>
                                                                @else
                                                                    <option value="{{$id}}" {{old('txtregional_funcionarioSena') ==$id ? 'selected':''}}>{{$nombre}}</option>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <label for="txtregional_funcionarioSena" class="active">Regional <span class="red-text">*</span></label>
                                                    <small id="txtregional_funcionarioSena-error"  class="error red-text"></small>
                                                </div>
                                                <div class="input-field col s12 m12 l12">
                                                    <select class="js-states browser-default select2 select2-hidden-accessible" id="txtcentroformacion_funcionarioSena" name="txtcentroformacion_funcionarioSena" style="width: 100%" tabindex="-1" >
                                                        <option value="">Seleccione Primero la regional</option>
                                                    </select>
                                                    <label for="txtcentroformacion_funcionarioSena" class="active">Centro de formación <span class="red-text">*</span></label>
                                                    <small id="txtcentroformacion_funcionarioSena-error"  class="error red-text"></small>
                                                </div>
                                                <div class="input-field col s12 m12 l12">

                                                    <input class="validate" id="txtdependencia" name="txtdependencia" type="text"  value="{{ isset($user->talento->dependencia) ? $user->talento->dependencia : old('txtdependencia')}}" {{session()->get('login_role') == App\User::IsAdministrador() || session()->get('login_role') == App\User::IsDinamizador()  ? 'readonly' : ''}}>

                                                    <label for="txtdependencia">Dependencia</label>
                                                    <small id="txtdependencia-error"  class="error red-text"></small>
                                                </div>
                                            </div>
                                            <div class="row instructorSena" style="display:none">
                                                <div class="input-field col s12 m12 l12" >
                                                    <select class=" js-states browser-default select2 select2-hidden-accessible" id="txtregional_instructorSena" name="txtregional_instructorSena" style="width: 100%" tabindex="-1" onchange="tipoTalento.getCentroFormacionInstructorSena()" >
                                                        @if(session()->get('login_role') == App\User::IsAdministrador() || session()->get('login_role') == App\User::IsDinamizador())
                                                            @if(isset($user->talento->entidad->centro->regional->id))
                                                                <option value="{{$user->talento->entidad->centro->regional->id}}" selected="">{{$user->talento->entidad->centro->regional->nombre}}</option>
                                                            @else
                                                                <option value="">No se encontraron resultados</option>
                                                            @endif
                                                        @else
                                                            <option value="">Seleccione regional</option>
                                                            @foreach($regionales as $id => $nombre)
                                                                @if(isset($user->talento->entidad->centro->regional->id))
                                                                    <option value="{{$id}}" {{old('txtregional_instructorSena',$user->talento->entidad->centro->regional->id) ==$id ? 'selected':''}}>{{$nombre}}</option>
                                                                @else
                                                                    <option value="{{$id}}" {{old('txtregional_instructorSena') ==$id ? 'selected':''}}>{{$nombre}}</option>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <label for="txtregional_instructorSena" class="active">Regional <span class="red-text">*</span></label>
                                                    <small id="txtregional_instructorSena-error"  class="error red-text"></small>
                                                </div>
                                                <div class="input-field col s12 m12 l12">

                                                    <select class="js-states browser-default select2 select2-hidden-accessible" id="txtcentroformacion_instructorSena" name="txtcentroformacion_instructorSena" style="width: 100%" tabindex="-1">
                                                        <option value="">Seleccione Primero la regional</option>
                                                    </select>
                                                    <label for="txtcentroformacion_instructorSena" class="active">Centro de formación <span class="red-text">*</span></label>
                                                    <small id="txtcentroformacion_instructorSena-error"  class="error red-text"></small>
                                                </div>

                                            </div>
                                            <div class="row otherUser"></div>
                                                <div class="row universitario" style="display:none">
                                                    <div class="input-field col s12 m12 l12" >
                                                        <select class="" id="txttipoestudio" name="txttipoestudio" style="width: 100%" tabindex="-1" >
                                                            @if(session()->get('login_role') == App\User::IsAdministrador() || session()->get('login_role') == App\User::IsDinamizador())
                                                                @if(isset($user->talento->tipoestudio->id))
                                                                    <option value="{{$user->talento->tipoestudio->id}}" selected="">{{$user->talento->tipoestudio->nombre}}</option>
                                                                @else
                                                                    <option value="">No se encontraron resultados</option>
                                                                @endif
                                                            @else
                                                                <option value="">Seleccione Tipo Estudio</option>
                                                                @foreach($tipoestudios as $id => $nombre)
                                                                    @if(isset($user->talento->tipoestudio->id))
                                                                    <option value="{{$id}}" {{old('txttipoestudio',$user->talento->tipoestudio->id) ==$id ? 'selected':''}}>{{$nombre}}</option>
                                                                    @else
                                                                        <option value="{{$id}}" {{old('txttipoestudio') ==$id ? 'selected':''}}>{{$nombre}}</option>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        <label for="txttipoestudio">Tipo Estudio <span class="red-text">*</span></label>
                                                        <small id="txttipoestudio-error"  class="error red-text"></small>
                                                    </div>

                                                    <div class="input-field col s12 m12 l12" >
                                                        <input class="validate" id="txtuniversidad" name="txtuniversidad" type="text"  value="{{ isset($user->talento->universidad) ? $user->talento->universidad : old('txtuniversidad')}}" {{session()->get('login_role') == App\User::IsAdministrador() || session()->get('login_role') == App\User::IsDinamizador()  ? 'readonly' : ''}}>
                                                        <label for="txtuniversidad">Universidad <span class="red-text">*</span></label>
                                                        <small id="txtuniversidad-error"  class="error red-text"></small>
                                                    </div>

                                                    <div class="input-field col s12 m12 l12" >
                                                        <input class="validate" id="txtcarrera" name="txtcarrera" type="text"  value="{{ isset($user->talento->carrera_universitaria) ? $user->talento->carrera_universitaria : old('txtcarrera')}}" {{session()->get('login_role') == App\User::IsAdministrador() || session()->get('login_role') == App\User::IsDinamizador()  ? 'readonly' : ''}}>
                                                        <label for="txtcarrera">Nombre de la Carrera <span class="red-text">*</span></label>
                                                        <small id="txtcarrera-error"  class="error red-text"></small>
                                                    </div>
                                                </div>
                                                <div class="row funcionarioEmpresa" style="display:none">


                                                    <div class="input-field col s12 m12 l12" >
                                                        <input class="validate" id="txtempresa" name="txtempresa" type="text"  value="{{ isset($user->talento->empresa) ? $user->talento->empresa : old('txtempresa')}}" {{session()->get('login_role') == App\User::IsAdministrador() || session()->get('login_role') == App\User::IsDinamizador()  ? 'readonly' : ''}}>
                                                        <label for="txtempresa">Nombre de la Empresa <span class="red-text">*</span></label>
                                                        <small id="txtempresa-error"  class="error red-text"></small>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- contratista -->
                            <div class="row contratista">
                                <div class="col s12 m8 l8 offset-l2 offset-m2">
                                    <h5 class="text-primarycolor center-align hand-of-Sean-fonts orange-text text-darken-3">Información Contratista Red Tecnoparque Colombia</h5>
                                    <div class="divider mailbox-divider"></div>
                                    <div class="row">
                                        <div class="input-field col s12 m8 l8 offset-l2 offset-m2">
                                            <select class="js-states browser-default select2 select2-hidden-accessible"  id="txtnodo" name="txtnodo"  style="width: 100%" tabindex="-1">
                                                    <option value="">Seleccione Nodo</option>
                                                    @foreach($nodos as $id => $nodo)
                                                        <option value="{{$id}}" {{old('txtnodo') ==  $id ? 'selected':''}}>{{$nodo}}</option>
                                                    @endforeach
                                            </select>
                                            <label for="txtnodo" class="active">Nodo<span class="red-text">*</span></label>
                                            <small id="txtnodo-error" class="error red-text"></small>
                                        </div>
                                        <div class="input-field col s12 m8 l8 offset-l4 offset-m4">
                                            <p class="p-v-xs">
                                                <input checked="" class="txttipocontratista" id="txtcontratistas" name="txttipocontratista" type="radio" value="planta" {{ old('pregunta1') == 'planta' ? 'checked':''}}/>
                                                <label align="justify" for="txtcontratistas" class="black-text text-black">
                                                    Contratista.
                                                </label>
                                                <input  class="txttipocontratista" id="txtplanta" name="txttipocontratista" type="radio" value="contratista"  {{ old('pregunta1') == 'contratista' ? 'checked':''}}/>
                                                <label align="justify" for="txtplanta" class="black-text text-black">
                                                    Planta.
                                                </label>
                                            </p>
                                            <small id="txttipocontratista-error" class="error red-text"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12 center-align m-t-sm">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="txtremember" id="txtremember" {{ old('txtremember') ? 'checked' : '' }}>
                                            <label class="form-check-label black-text text-black" for="txtremember">
                                                Acepto los <a class="m-t-sm  blue-text text-light-blue accent-4 center-align" href="{{ route('terminos') }}" target="_blank">términos de uso y política de confidencialidad de los datos.</a>
                                            </label>
                                        </div>
                                        <small id="txtremember-error" class="error red-text"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col s12 center-align m-t-sm">
                                <button type="submit" id="login-btn" class="waves-effect waves-light btn center-align">
                                    <i class="material-icons left">send</i>
                                        Enviar
                                </button>
                                <button type="reset" id="login-btn" class="modal-action modal-open waves-effect red lighten-2 btn center-align">
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
    <form id="formValidateCredentials"   method="POST" action="{{ route('user.verify') }}" onsubmit="return checkSubmit()">
        @csrf
        <div class="modal-content">
            <h5>Antes de registrarse confirme que su usuario no haya sido creado</h5>
            <small>Ingrese los siguientes datos para confirmar que su usuario será realmente nuevo</small>
            <div class="row">
                <div class="input-field col m12 s12 l12">
                    <select  name="document_type" style="width: 100%" tabindex="-1">
                        <option value="">Seleccione tipo documento</option>
                        @foreach($tiposdocumentos as $value)
                                <option value="{{$value->id}}" {{old('document_type') == $value->id  ? 'selected':''}}>{{$value->nombre}}</option>
                        @endforeach
                    </select>
                    <label for="document_type">Tipo Documento <span class="red-text">*</span></label>
                    <small id="document_type-error" class="error red-text"></small>
                </div>
                <div class="input-field col l12 m12 s12">
                    <input id="document" name="document"  type="text" value="{{isset($documento) ? $documento : ''}}" {{isset($documento) ? 'readonly' : ''}}>
                    <label for="document">Documento <span class="red-text">*</span></label>
                    <small id="document-error" class="error red-text"></small>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <input type="submit" class="modal-action btn-flat" value="Validar">
        <a href="{{route('/')}}" class="modal-action modal-close waves-effect btn-flat" >Regresar al inicio</a>
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
        user.checkedTypeUser();
        tipoTalento.getSelectTipoTalento();

    $('.selectMultipe').select2({
        language: "es",
    });


});
</script>
@endpush

