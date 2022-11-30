@extends('layouts.app')

@section('meta-title', 'Perfil |' . $user->nombres. ' '. $user->apellidos)

@section('content')
    <main class="mn-inner inner-active-sidebar">
        <div class="content">
            <div class="row no-m-t no-m-b m-r-lg m-l-lg">
                <div class="left left-align">
                    <h5 class="left-align primary-text">
                        <a class="footer-text left-align"
                           href="{{route('usuario.usuarios.show', $user->present()->userDocumento())}}">
                            <i class="material-icons left">arrow_back</i>
                        </a>Usuarios
                    </h5>
                </div>
                <div class="right right-align show-on-large hide-on-med-and-down">
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li><a href="{{route('usuario.index')}}">Usuarios</a></li>
                        <li class="active">Cambiar Información</li>
                    </ol>
                </div>
            </div>
            <div class="row no-m-t no-m-b">
                <div class="col s12 m12 l12">
                    <div class="card mailbox-content">
                        <div class="card-content">
                            <div class="row no-m-t no-m-b">
                                <div class="col s12 m12 l12">
                                    <div class="mailbox-view">
                                        <div class="mailbox-view-header">
                                            @include('users.profile.nav.header')
                                            <div class="right mailbox-buttons">
                                                    <span class="mailbox-title">
                                                        <p class="center">
                                                            Editar perfil
                                                            <b>
                                                                {{$user->nombres}} {{$user->apellidos}}
                                                            </b>
                                                        </p>
                                                    </span>
                                            </div>
                                        </div>
                                        <div class="divider mailbox-divider">
                                        </div>
                                        <div class="mailbox-text">
                                            <form action="{{ route('usuario.usuarios.updateaccount',$user->id)}}"
                                                  id="formEditUser" method="POST" onsubmit="return checkSubmit()">
                                                {!! csrf_field() !!}
                                                {!! method_field('PUT')!!}
                                                <div class="row">
                                                    <div class="col s12 m12 l12 ">
                                                        <div class="row">
                                                            <div class="col m6">
                                                                <div class="row">
                                                                    <div class="input-field col m6 s12">
                                                                        <select name="txttipo_documento"
                                                                                style="width: 100%" tabindex="-1">
                                                                            <option value="">Seleccione tipo documento</option>
                                                                            @foreach($tiposdocumentos as $value)
                                                                                @if(isset($user->tipoDocumento->id))
                                                                                    <option
                                                                                        value="{{$value->id}}" {{old('txttipo_documento',$user->tipoDocumento->id) ==$value->id ? 'selected':''}}>{{$value->nombre}}</option>
                                                                                @else
                                                                                    <option
                                                                                        value="{{$value->id}}" {{old('txttipo_documento') == $value->id  ? 'selected':''}}>{{$value->nombre}}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                        <label for="txttipo_documento">Tipo Documento
                                                                            <span class="red-text">*</span></label>
                                                                        <small id="txttipo_documento-error"
                                                                               class="error red-text"></small>
                                                                    </div>
                                                                    <div class="input-field col m6 s12">
                                                                        @if($view == 'create')
                                                                            <input id="txtdocumento" name="txtdocumento"
                                                                                   type="text" value="{{$documento}}"
                                                                                   readonly/>
                                                                        @elseif(isset($user->documento))
                                                                            <input id="txtdocumento" name="txtdocumento"
                                                                                   type="text"
                                                                                   value="{{$user->documento}}"/>
                                                                        @endif
                                                                        <label for="txtdocumento">Documento <span class="red-text">*</span></label>
                                                                        <small id="txtdocumento-error"class="error red-text"></small>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="input-field col m6 s12">
                                                                        <select
                                                                            class="js-states browser-default select2 "
                                                                            id="txtdepartamentoexpedicion"
                                                                            name="txtdepartamentoexpedicion"
                                                                            onchange="user.getCiudadExpedicion()"
                                                                            style="width: 100%" tabindex="-1">
                                                                            <option value="">Seleccione departamento
                                                                            </option>
                                                                            @foreach($departamentos as $value)
                                                                                @if(isset($user->ciudadexpedicion->departamento_id))
                                                                                    <option
                                                                                        value="{{$value->id}}" {{old('txtdepartamentoexpedicion',$user->ciudadexpedicion->departamento_id) ==$value->id ? 'selected':''}}>{{$value->nombre}}</option>
                                                                                @else
                                                                                    <option
                                                                                        value="{{$value->id}}" {{old('txtdepartamentoexpedicion') == $value->id  ? 'selected':''}}>{{$value->nombre}}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                        <label class="active" for="txtdepartamentoexpedicion">Departamentode Expedición <span class="red-text">*</span></label>
                                                                        <small id="txtdepartamentoexpedicion-error" class="error red-text"></small>
                                                                    </div>
                                                                    <div class="input-field col m6 s12">
                                                                        <select
                                                                            class="js-states browser-default select2"
                                                                            id="txtciudadexpedicion"
                                                                            name="txtciudadexpedicion"
                                                                            style="width: 100%" tabindex="-1">
                                                                            <option value="">Seleccione Primero el Departamento</option>
                                                                        </select>
                                                                        <label class="active" for="txtciudadexpedicion">Ciudad
                                                                            de Expedición <span
                                                                                class="red-text">*</span></label>
                                                                        <small id="txtciudadexpedicion-error"
                                                                               class="error red-text"></small>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="input-field col s12 m6 l6">
                                                                        <input class="validate" id="txtnombres"
                                                                               name="txtnombres" type="text"
                                                                               value="{{ isset($user->nombres) ? $user->nombres : old('txtnombres')}}">
                                                                        <label for="txtnombres">Nombres <span
                                                                                class="red-text">*</span></label>
                                                                        <small id="txtnombres-error"
                                                                               class="error red-text"></small>
                                                                    </div>
                                                                    <div class="input-field col s12 m6 l6">
                                                                        <input class="validate" id="txtapellidos"
                                                                               name="txtapellidos" type="text"
                                                                               value="{{ isset($user->apellidos) ? $user->apellidos : old('txtapellidos')}}">
                                                                        <label for="txtapellidos">Apellidos <span
                                                                                class="red-text">*</span></label>
                                                                        <small id="txtapellidos-error"
                                                                               class="error red-text"></small>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="input-field col s12 m6 l6">
                                                                        <select
                                                                            class="js-states browser-default select2"
                                                                            id="txtdepartamento" name="txtdepartamento"
                                                                            onchange="user.getCiudad()"
                                                                            style="width: 100%" tabindex="-1">
                                                                            <option value="">Seleccione departamento
                                                                            </option>
                                                                            @foreach($departamentos as $value)
                                                                                @if(isset($user->ciudad->departamento_id))
                                                                                    <option
                                                                                        value="{{$value->id}}" {{old('txtdepartamento',$user->ciudad->departamento_id) ==$value->id ? 'selected':''}}>{{$value->nombre}}</option>
                                                                                @else
                                                                                    <option
                                                                                        value="{{$value->id}}" {{old('txtdepartamento') == $value->id  ? 'selected':''}}>{{$value->nombre}}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                        <label class="active" for="txtdepartamento">Departamento
                                                                            de Residencia <span
                                                                                class="red-text">*</span></label>
                                                                        <small id="txtdepartamento-error"
                                                                               class="error red-text"></small>
                                                                    </div>
                                                                    <div class="input-field col s12 m6 l6">
                                                                        <select
                                                                            class="js-states browser-default select2"
                                                                            id="txtciudad" name="txtciudad"
                                                                            style="width: 100%" tabindex="-1">
                                                                            <option value="">Seleccione Primero el
                                                                                Departamento
                                                                            </option>
                                                                        </select>
                                                                        <label class="active" for="txtciudad">Ciudad de
                                                                            Residencia <span
                                                                                class="red-text">*</span></label>
                                                                        <small id="txtciudad-error"
                                                                               class="error red-text"></small>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="input-field col s12">
                                                                        <input class="validate" id="txtemail"
                                                                               name="txtemail" type="email"
                                                                               value="{{ isset($user->email) ? $user->email : old('txtemail')}}">
                                                                        <label for="txtemail">Correo <span
                                                                                class="red-text">*</span></label>
                                                                        <small id="txtemail-error"
                                                                               class="error red-text"></small>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="input-field col s12 m6 l6">
                                                                        <select class="" id="txtgrado_discapacidad"
                                                                                name="txtgrado_discapacidad"
                                                                                style="width: 100%" tabindex="-1"
                                                                                onchange="user.getGradoDiscapacidad(this)">
                                                                            @if(isset($user->grado_discapacidad))
                                                                                <option
                                                                                    {{$user->grado_discapacidad == 0 ?'selected' : ''}} value="0">
                                                                                    NO
                                                                                </option>
                                                                                <option
                                                                                    {{$user->grado_discapacidad == 1 ?'selected' : ''}} value="1">
                                                                                    SI
                                                                                </option>
                                                                            @else
                                                                                <option value="0">NO</option>
                                                                                <option value="1">SI</option>
                                                                            @endif

                                                                        </select>
                                                                        <label for="txtgrado_discapacidad">Algún grado
                                                                            de discapacidad <span
                                                                                class="red-text">*</span></label>
                                                                        <small id="txtgrado_discapacidad-error"
                                                                               class="error red-text"></small>
                                                                    </div>
                                                                    <div
                                                                        class="input-field col s12 m6 l6 gradodiscapacidad"
                                                                        style="display:none">
                                                                        <input class="validate" id="txtdiscapacidad"
                                                                               name="txtdiscapacidad" type="text"
                                                                               value="{{ isset($user->otra_eps) ? $user->descripcion_grado_discapacidad : old('txtdiscapacidad')}}">
                                                                        <label for="txtdiscapacidad" class="active">¿Cúal?
                                                                            <span class="red-text">*</span></label>
                                                                        <small id="txtdiscapacidad-error"
                                                                               class="error red-text"></small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col m6">
                                                                <div class="row">
                                                                    <div class="input-field col s12 m6 l6">
                                                                        <input class="validate datepicker"
                                                                               id="txtfecha_nacimiento"
                                                                               name="txtfecha_nacimiento" type="text"
                                                                               value="{{ isset($user->fechanacimiento) ? $user->fechanacimiento->toDateString() : old('txtfecha_nacimiento')}}">
                                                                        <label for="txtfecha_nacimiento">Fecha de
                                                                            Nacimiento <span
                                                                                class="red-text">*</span></label>
                                                                        <small id="txtfecha_nacimiento-error"
                                                                               class="error red-text"></small>
                                                                    </div>
                                                                    <div class="input-field col s12 m6 l6">
                                                                        <select class="" id="txtgruposanguineo"
                                                                                name="txtgruposanguineo"
                                                                                style="width: 100%" tabindex="-1">
                                                                            <option value="">Seleccione grupo
                                                                                sanguíneo
                                                                            </option>
                                                                            @foreach($gruposanguineos as $value)
                                                                                @if(isset($user->grupoSanguineo->id))
                                                                                    <option
                                                                                        value="{{$value->id}}" {{old('txtgruposanguineo',$user->grupoSanguineo->id) ==$value->id ? 'selected':''}}>{{$value->nombre}}</option>
                                                                                @else
                                                                                    <option
                                                                                        value="{{$value->id}}" {{old('txtgruposanguineo') == $value->id  ? 'selected':''}}>{{$value->nombre}}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                        <label for="txtgruposanguineo">Grupo Sanguíneo
                                                                            <span class="red-text">*</span></label>
                                                                        <small id="txtgruposanguineo-error"
                                                                               class="error red-text"></small>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="input-field col s12 m6 l6">
                                                                        <select
                                                                            class="js-states browser-default select2"
                                                                            id="txteps" name="txteps"
                                                                            style="width: 100%" tabindex="-1"
                                                                            onchange="user.getOtraEsp(this)">
                                                                            <option value="">Seleccione eps</option>
                                                                            @foreach($eps as $value)
                                                                                @if(isset($user->eps_id))
                                                                                    <option
                                                                                        value="{{$value->id}}" {{old('txteps',$user->eps_id) ==  $value->id ? 'selected':''}}>{{$value->nombre}}</option>
                                                                                @else
                                                                                    <option
                                                                                        value="{{$value->id}}" {{old('txteps') == $value->id  ? 'selected':''}}>{{$value->nombre}}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                        <label class="active" for="txteps">Esp <span
                                                                                class="red-text">*</span></label>
                                                                        <small id="txteps-error"
                                                                               class="error red-text"></small>
                                                                    </div>
                                                                    <div class="input-field col s12 m6 l6 otraeps"
                                                                         style="display:none">
                                                                        <input class="validate" id="txtotraeps"
                                                                               name="txtotraeps" type="text"
                                                                               value="{{ isset($user->otra_eps) ? $user->otra_eps : old('txtotraeps')}}">
                                                                        <label for="txtotraeps" class="active">Otra Eps
                                                                            <span class="red-text">*</span></label>
                                                                        <small id="txtotraeps-error"
                                                                               class="error red-text"></small>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="input-field col s12 m6 l6">
                                                                        <select class="" id="txtestrato"
                                                                                name="txtestrato" style="width: 100%"
                                                                                tabindex="-1">
                                                                            <option value="">Seleccione estrato</option>
                                                                            @for($i =1; $i <= 6; $i++)
                                                                                @if(isset($user->estrato))
                                                                                    <option
                                                                                        value="{{ $i }}" {{old('txtestrato',$user->estrato) == $i ? 'selected':''}}>{{$i}}</option>
                                                                                @else
                                                                                    <option
                                                                                        value="{{ $i }}" {{old('txtestrato') == $i ? 'selected':''}}>{{$i}}</option>
                                                                                @endif

                                                                            @endfor
                                                                        </select>
                                                                        <label for="txtestrato">Estrato <span
                                                                                class="red-text">*</span></label>
                                                                        <small id="txtestrato-error"
                                                                               class="error red-text"></small>
                                                                    </div>
                                                                    <div class="input-field col s12 m6 l6">

                                                                        <select class="" id="txtetnias" name="txtetnias"
                                                                                style="width: 100%" tabindex="-1">
                                                                            <option value="">Seleccione Etnia</option>
                                                                            @foreach($etnias as $id => $nombre)
                                                                                @if(isset($user->etnia->id))
                                                                                    <option
                                                                                        value="{{$id}}" {{old('txtetnias',$user->etnia->id) ==$id ? 'selected':''}}>{{$nombre}}</option>
                                                                                @else
                                                                                    <option
                                                                                        value="{{$id}}" {{old('txtetnias') ==$id ? 'selected':''}}>{{$nombre}}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                        <label for="txtetnias">Etnias <span
                                                                                class="red-text">*</span></label>
                                                                        <small id="txtetnias-error"
                                                                               class="error red-text"></small>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="input-field col s12 m6 l6">

                                                                        <input class="validate" id="txtbarrio"
                                                                               name="txtbarrio" type="text"
                                                                               value="{{ isset($user->barrio) ? $user->barrio : old('txtbarrio')}}">
                                                                        <label for="txtbarrio">Barrio <span
                                                                                class="red-text">*</span></label>
                                                                        <small id="txtbarrio-error"
                                                                               class="error red-text"></small>
                                                                    </div>
                                                                    <div class="input-field col s12 m6 l6">
                                                                        <input class="validate" id="txtdireccion"
                                                                               name="txtdireccion" type="text"
                                                                               value="{{ isset($user->direccion) ? $user->direccion : old('txtdireccion')}}">
                                                                        <label for="txtdireccion">Dirección <span
                                                                                class="red-text">*</span></label>
                                                                        <small id="txtdireccion-error"
                                                                               class="error red-text"></small>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="input-field col s12 m6 l6">
                                                                        <input class="validate" id="txttelefono"
                                                                               name="txttelefono" type="tel"
                                                                               value="{{ isset($user->telefono) ? $user->telefono : old('txttelefono')}}">
                                                                        <label for="txttelefono">Telefono</label>
                                                                        <small id="txttelefono-error"
                                                                               class="error red-text"></small>
                                                                    </div>
                                                                    <div class="input-field col s12 m6 l6">
                                                                        <input class="validate" id="txtcelular"
                                                                               name="txtcelular" type="tel"
                                                                               value="{{ isset($user->celular) ? $user->celular : old('txtcelular')}}">
                                                                        <label for="txtcelular">Celular <span
                                                                                class="red-text">*</span></label>
                                                                        <small id="txtcelular-error"
                                                                               class="error red-text"></small>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="divider mailbox-divider">
                                                </div>
                                                <div class="row">

                                                    <div class="col s12 m9 l9 offset-l5 offset-m5 "><br>
                                                        <div class="row">
                                                            <div class="input-field col s12 m12 l12">
                                                                <div class="switch m-b-md">
                                                                    <label class="active">Genero<span
                                                                            class="red-text">*</span></label>
                                                                    <p class="no-p-v">
                                                                        <input class="with-gap " name="txtgenero"
                                                                               type="radio" id="masculino"
                                                                               value="1" {{isset($user->genero) && $user->genero == 1 ? 'checked' : old('txtgenero')}}>
                                                                        <label for="masculino"
                                                                               class="p-h-md">Masculino</label>
                                                                        <input class="with-gap" t name="txtgenero"
                                                                               type="radio" id="femenino"
                                                                               value="0" {{isset($user->genero) && $user->genero == 0 ? 'checked' : old('txtgenero')}}>
                                                                        <label for="femenino"
                                                                               class="p-h-md">Femenino</label>
                                                                        <input class="with-gap" name="txtgenero"
                                                                               type="radio" id="no_binario"
                                                                               value="2" {{isset($user->genero) && $user->genero == 2 ? 'checked' : old('txtgenero')}}>
                                                                        <label for="no_binario" class="p-h-md">No
                                                                            binario</label>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="divider mailbox-divider"></div>
                                                <div class="row">
                                                    <div class="col s12 m3 l3">
                                                        <blockquote>
                                                            <ul class="collection">
                                                                <li class="collection-item">
                                                                    <span class="title"><b>Ocupaciones</b></span>
                                                                    <p>Puedes seleccionar varias ocupaciones si es el
                                                                        caso de que las tenga, sino seleccione una</p>

                                                                </li>
                                                            </ul>
                                                        </blockquote>
                                                        <div class="row">
                                                            <div class="input-field col s12 m12 l12">

                                                                <select class="js-states browser-default selectMultipe"
                                                                        id="txtocupaciones" name="txtocupaciones[]"
                                                                        style="width: 100%" tabindex="-1" multiple
                                                                        onchange="ocupacion.getOtraOcupacion(this)">

                                                                    @foreach($ocupaciones as $id => $nombre)

                                                                        <option
                                                                            value="{{$id}}" {{collect(old('txtocupaciones',$user->ocupaciones->pluck('id')))->contains($id) ? 'selected' : ''  }} >{{$nombre}}</option>

                                                                    @endforeach
                                                                </select>
                                                                <label for="txtocupaciones" class="active">Ocupación
                                                                    <span class="red-text">*</span></label>
                                                                <small id="txtocupaciones-error"
                                                                       class="error red-text"></small>

                                                            </div>
                                                            <div class="input-field col s12 m12 l12" id="otraocupacion">
                                                                <input class="validate" id="txtotra_ocupacion"
                                                                       name="txtotra_ocupacion" type="text"
                                                                       value="{{ isset($user->otra_ocupacion) ? $user->otra_ocupacion : old('txtotra_ocupacion')}}">
                                                                <label for="txtotra_ocupacion" class="active">¿Cuál?
                                                                    <span class="red-text">*</span></label>
                                                                <small id="txtotra_ocupacion-error"
                                                                       class="error red-text"></small>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m9 l9"><br>
                                                        <div class="mailbox-view-header">
                                                            <div class="center">
                                                                <div class="center">
                                                                    <i class="Small material-icons prefix green-complement-text">
                                                                        supervised_user_circle
                                                                    </i>
                                                                </div>
                                                                <div class="center">
                                                                    <span class="mailbox-title green-complement-text">Último estudio</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="divider mailbox-divider"></div>
                                                        <div class="row">
                                                            <div class="input-field col s12 m6 l6">
                                                                <input class="validate" id="txtinstitucion"
                                                                       name="txtinstitucion" type="text"
                                                                       value="{{ isset($user->institucion) ? $user->institucion : old('txtinstitucion')}}">
                                                                <label for="txtinstitucion">Institución <span
                                                                        class="red-text">*</span></label>
                                                                <small id="txtinstitucion-error"
                                                                       class="error red-text"></small>
                                                            </div>
                                                            <div class="input-field col s12 m6 l6 ">
                                                                <select class="" id="txtgrado_escolaridad"
                                                                        name="txtgrado_escolaridad" style="width: 100%"
                                                                        tabindex="-1">
                                                                    <option value="">Seleccione grado de escolaridad
                                                                    </option>
                                                                    @foreach($gradosescolaridad as $value)
                                                                        <option
                                                                            value="{{$value->id}}" {{old('txtgrado_escolaridad',$user->gradoescolaridad_id) ==$value->id ? 'selected':''}}>{{$value->nombre}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <label for="txtgrado_escolaridad">Grado Escolaridad
                                                                    <span class="red-text">*</span></label>
                                                                <small id="txtgrado_escolaridad-error"
                                                                       class="error red-text"></small>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="input-field col s12 m6 l6">
                                                                <input class="validate" id="txttitulo" name="txttitulo"
                                                                       type="text"
                                                                       value="{{ isset($user->titulo_obtenido) ? $user->titulo_obtenido : old('txttitulo')}}">
                                                                <label for="txttitulo">Titulo Obtenido <span
                                                                        class="red-text">*</span></label>
                                                                <small id="txttitulo-error"
                                                                       class="error red-text"></small>
                                                            </div>
                                                            <div class="input-field col s12 m6 l6">

                                                                <input class="validate datepicker"
                                                                       id="txtfechaterminacion"
                                                                       name="txtfechaterminacion" type="text"
                                                                       value="{{ isset($user->fecha_terminacion) ? optional($user->fecha_terminacion)->toDateString() : old('txtfechaterminacion')}}">
                                                                <label for="txtfechaterminacion">Fecha Terminación <span
                                                                        class="red-text">*</span></label>
                                                                <small id="txtfechaterminacion-error"
                                                                       class="error red-text"></small>

                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                                <div class="divider mailbox-divider">
                                                </div>
                                                <div class="right">
                                                    <button type="submit"
                                                            class="waves-effect waves-teal bg-secondary white-text btn-flat m-t-xs">
                                                        Cambiar Información Personal
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@push('script')
    <script>
        $(document).ready(function() {

            $('.selectMultipe').select2({
                language: "es",
            });
            user.getCiudadExpedicion();
            user.getCiudad();
            ocupacion.getOtraOcupacion();
            @if(isset($user->eps->id))
            user.getOtraEsp('{{$user->eps->id}}');
            @endif

            @if(isset($user->grado_discapacidad))
            user.getGradoDiscapacidad();
            @endif

        });

        var ocupacion = {
            getOtraOcupacion:function (idocupacion) {
                $('#otraocupacion').hide();
                let id = $(idocupacion).val();
                let nombre = $("#txtocupaciones option:selected").text();
                let resultado = nombre.match(/[A-Z][a-z]+/g);
                @if($errors->any())
                $('#otraocupacion').hide();

                if (resultado != null  && resultado.includes('{{App\Models\Ocupacion::IsOtraOcupacion() }}')) {
                    $('#otraocupacion').show();
                }

                @endif
                if (resultado != null ) {
                    if (resultado.includes('{{App\Models\Ocupacion::IsOtraOcupacion() }}')) {
                        $('#otraocupacion').show();
                    }
                }
            }
        };


        var user = {
            getCiudadExpedicion:function(){
                let id;
                id = $('#txtdepartamentoexpedicion').val();
                $.ajax({
                    dataType:'json',
                    type:'get',
                    url: host_url + '/usuario/getciudad/'+id
                }).done(function(response){
                    $('#txtciudadexpedicion').empty();
                    $('#txtciudadexpedicion').append('<option value="">Seleccione la Ciudad</option>')
                    $.each(response.ciudades, function(i, e) {
                        $('#txtciudadexpedicion').append('<option  value="'+e.id+'">'+e.nombre+'</option>');
                        @if(isset($user->ciudadexpedicion->id))
                        $('#txtciudadexpedicion').select2('val','{{$user->ciudadexpedicion->id}}');

                        @endif
                    });
                    $('#txtciudadexpedicion').material_select();
                });
            },


            getCiudad:function(){
                let id;
                id = $('#txtdepartamento').val();
                $.ajax({
                    dataType:'json',
                    type:'get',
                    url: host_url + '/usuario/getciudad/'+id
                }).done(function(response){
                    $('#txtciudad').empty();
                    $('#txtciudad').append('<option value="">Seleccione la Ciudad</option>')
                    $.each(response.ciudades, function(i, e) {
                        $('#txtciudad').append('<option  value="'+e.id+'">'+e.nombre+'</option>');
                        @if(isset($user->ciudad->id))
                        $('#txtciudad').select2('val','{{$user->ciudad->id}}');

                        @endif
                    })

                    $('#txtciudad').material_select();
                });
            },

            getOtraEsp:function (ideps) {
                let id = $(ideps).val();
                let nombre = $("#txteps option:selected").text();

                if (nombre != '{{App\Models\Eps::OTRA_EPS }}') {

                    $(".otraeps").css("display", "none");



                }else{

                    $(".otraeps").css("display", "block");
                }
            },

            getGradoDiscapacidad(){
                let discapacidad = $('#txtgrado_discapacidad').val();
                if (discapacidad == 1) {
                    $('.gradodiscapacidad').css("display", "block");

                }else{
                    $(".gradodiscapacidad").css("display", "none");
                }
            }
        }
    </script>
@endpush

