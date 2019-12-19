@extends('layouts.app')

@section('meta-title', 'Perfil |' . $user->nombres. ' '. $user->apellidos)

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s10 m10 l10">
                        <h5 class="left-align">
                            <i class="material-icons left">
                                supervised_user_circle
                            </i>
                            Usuarios | Perfil
                        </h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m12 l12">
                        <div class="card mailbox-content">
                            <div class="card-content">
                                <div class="row no-m-t no-m-b">
                                    <div class="col s12 m12 l12">
                                        @include('users.profile.nav.navbar')
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
                                                <form action="{{ route('perfil.update',$user->id)}}" method="POST" onsubmit="return checkSubmit()">
                                                    {!! csrf_field() !!}
                                                    {!! method_field('PUT')!!}
                                                    <div class="row">
                                                        <div class="col s12 m3 l3">
                                                            <blockquote>
                                                                <ul class="collection">
                                                                    <li class="collection-item">
                                                                        <span class="title"><b>Configuración principal</b></span>
                                                                        <p>Esta información aparecerá en tu perfil</p>
                                                                    </li>
                                                                    <li class="collection-item">
                                                                        <span class="title"><b>Perfil</b></span>
                                                                        <p>Después de una actualización correcta del perfil, se le redirigirá a la página de inicio de sesión donde podrá iniciar sesión nuevamente.</p>
                                                                    </li>
                                                                </ul>
                                                            </blockquote>
                                                        </div>
                                                        <div class="col s12 m9 l9"><br>
                                                            <div class="row">
                                                                <div class="input-field col s12 m6 l6">
                                                                    <i class="material-icons prefix">
                                                                         credit_card
                                                                    </i>
                                                                    <select class="" id="txttipo_documento" name="txttipo_documento" style="width: 100%" tabindex="-1">
                                                                        <option value="">Seleccione tipo documento</option>
                                                                        @foreach($tiposdocumentos as $value)
                                                                            @if(isset($user->tipodocumento_id))
                                                                            <option value="{{$value->id}}" {{old('txttipo_documento',$user->tipodocumento_id) ==  $value->id ? 'selected':''}}>{{$value->nombre}}</option> 
                                                                            @else
                                                                                <option value="{{$value->id}}" {{old('txttipo_documento') == $value->id  ? 'selected':''}}>{{$value->nombre}}</option> 
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                    <label for="txtcelular">Tipo Documento <span class="red-text">*</span></label>
                                                                    @error('txttipo_documento')
                                                                        <label id="txttipo_documento-error" class="error" for="txttipo_documento">{{ $message }}</label>
                                                                    @enderror
                                                                </div>
                                                                <div class="input-field col s12 m6 l6">
                                                                    <i class="material-icons prefix">
                                                                        assignment_ind
                                                                    </i>
                                                                    <input id="txtdocumento" name="txtdocumento" type="text" value="{{ isset($user->documento) ? $user->documento : old('txtdocumento')}}">
                                                                    <label for="txtdocumento">Documento <span class="red-text">*</span></label> 
                                                                    @error('txtdocumento')
                                                                        <label id="txtdocumento-error" class="error" for="txtdocumento">{{ $message }}</label>
                                                                    @enderror
                                                                </div>    
                                                            </div>
                                                            <div class="row">
                                                                <div class="input-field col s12 m6 l6">
                                                                    <i class="material-icons prefix">
                                                                        account_circle
                                                                    </i>
                                                                    <input class="validate" id="txtnombres" name="txtnombres" type="text"  value="{{ isset($user->nombres) ? $user->nombres : old('txtnombres',$user->nombres)}}">
                                                                    <label for="txtnombres">Nombres <span class="red-text">*</span></label>
                                                                    @error('txtnombres')
                                                                        <label id="txtnombres-error" class="error" for="txtnombres">{{ $message }}</label>
                                                                    @enderror
                                                                </div>
                                                                <div class="input-field col s12 m6 l6">
                                                                    <i class="material-icons prefix">
                                                                        account_circle
                                                                    </i>
                                                                    <input class="validate" id="txtapellidos" name="txtapellidos" type="text" value="{{ isset($user->apellidos) ? $user->apellidos : old('txtapellidos', $user->apellidos)}}">
                                                                    <label for="txtapellidos">Apellidos <span class="red-text">*</span></label>
                                                                    @error('txtapellidos')
                                                                        <label id="txtapellidos-error" class="error" for="txtapellidos">{{ $message }}</label>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="input-field col s12 m6 l6">
                                                                    <i class="material-icons prefix">
                                                                        date_range
                                                                    </i>
                                                                    <input class="validate datepicker" id="txtfecha_nacimiento" name="txtfecha_nacimiento" type="text" value="{{ isset($user->fechanacimiento) ? $user->fechanacimiento->toDateString() : old('txtfecha_nacimiento',  $user->fechanacimiento->toDateString())}}">
                                                                    <label for="txtfecha_nacimiento">Fecha de Nacimiento <span class="red-text">*</span></label>
                                                                    @error('txtfecha_nacimiento')
                                                                        <label id="txtfecha_nacimiento-error" class="error" for="txtfecha_nacimiento">{{ $message }}</label>
                                                                    @enderror
                                                                </div>
                                                               <div class="input-field col s12 m6 l6">
                                                                    <i class="material-icons prefix">
                                                                        details
                                                                    </i>
                                                                    <select class="" id="txtgruposanguineo" name="txtgruposanguineo" style="width: 100%" tabindex="-1" >
                                                                        <option value="">Seleccione grupo sanguíneo </option>
                                                                        @foreach($gruposanguineos as $value)
                                                                            @if(isset($user->gruposanguineo_id))
                                                                            <option value="{{$value->id}}" {{old('txtgruposanguineo',$user->gruposanguineo_id) ==  $value->id ? 'selected':''}}>{{$value->nombre}}</option> 
                                                                            @else
                                                                                <option value="{{$value->id}}" {{old('txtgruposanguineo') == $value->id  ? 'selected':''}}>{{$value->nombre}}</option> 
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                    <label for="txtgruposanguineo">Grupo Sanguíneo <span class="red-text">*</span></label>
                                                                    @error('txtgruposanguineo')
                                                                        <label id="txtgruposanguineo-error" class="error" for="txtgruposanguineo">{{ $message }}</label>
                                                                    @enderror 
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="input-field col s12 m6 l6" >
                                                                    <i class="material-icons prefix">
                                                                        details
                                                                    </i>
                                                                    <select class="" id="txteps" name="txteps" style="width: 100%" tabindex="-1" onchange="eps.getOtraEsp(this)">
                                                                        <option value="">Seleccione eps</option>
                                                                        @foreach($eps as $value) 
                                                                                <option value="{{$value->id}}" {{old('txteps',$user->eps_id) ==  $value->id ? 'selected':''}}>{{$value->nombre}}</option> 
                                                                        @endforeach
                                                                    </select>
                                                                    <label for="txteps" >Esp <span class="red-text">*</span></label>
                                                                    @error('txteps')
                                                                        <label id="txteps-error" class="error" for="txteps">{{ $message }}</label>
                                                                    @enderror 
                                                                </div>
                                                                <div class="input-field col s12 m6 l6" id="otraeps">
                                                                    <i class="material-icons prefix">
                                                                        details
                                                                    </i>
                                                                    <input class="validate" id="txtotraeps" name="txtotraeps" type="text" value="{{ isset($user->otra_eps) ? $user->otra_eps : old('txtotraeps', $user->otra_eps)}}">
                                                                    <label for="txtotraeps" class="active">Otra Eps <span class="red-text">*</span></label>
                                                                    @error('txtotraeps')
                                                                        <label id="txtotraeps-error" class="error" for="txtotraeps">{{ $message }}</label>
                                                                    @enderror 
                                                                </div>
                                                               
                                                                <div class="input-field col s12 m6 l6">
                                                                    <i class="material-icons prefix">
                                                                        details
                                                                    </i>
                                                                    <select class="" id="txtestrato" name="txtestrato" style="width: 100%" tabindex="-1">
                                                                        <option value="">Seleccione estrato</option>
                                                                        @for($i =1; $i <= 6; $i++)
                                                                                <option value="{{ $i }}"  {{old('txtestrato',$user->estrato) ==$i ? 'selected':''}}>{{$i}}</option> 
                                                                        @endfor
                                                                    </select>
                                                                    <label for="txtestrato">Estrato <span class="red-text">*</span></label>
                                                                    @error('txtestrato')
                                                                        <label id="txtestrato-error" class="error" for="txtestrato">{{ $message }}</label>
                                                                    @enderror 
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="input-field col s12 m6 l6">

                                                                    <i class="material-icons prefix">
                                                                        details
                                                                    </i>
                                                                   
                                                                    <select class="" id="txtdepartamento" name="txtdepartamento" onchange="UserAdministradorEdit.getCiudad()" style="width: 100%" tabindex="-1">
                                                                        <option value="">Seleccione departamento</option>
                                                                        @foreach($departamentos as $value)
                                                                            @if(isset($user->ciudad->departamento->id))
                                                                                <option value="{{$value->id}}" {{old('txtdepartamento',$user->ciudad->departamento->id) ==  $value->id ? 'selected':''}}>{{$value->nombre}}</option> 
                                                                            @else
                                                                                <option value="{{$value->id}}" {{old('txtdepartamento') == $value->id  ? 'selected':''}}>{{$value->nombre}}</option> 
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                   
                                                                    <label for="txtdepartamento">Departamento de Residencia <span class="red-text">*</span></label>
                                                                    @error('txtdepartamento')
                                                                        <label id="txtdepartamento-error" class="error" for="txtdepartamento">{{ $message }}</label>
                                                                    @enderror 
                                                                </div>
                                                             
                                                                <div class="input-field col s12 m6 l6">
                                                                    <i class="material-icons prefix">
                                                                        details
                                                                    </i>
                                                                
                                                                    <select class="" id="txtciudad" name="txtciudad" style="width: 100%" tabindex="-1">
                                                                        <option value="">Seleccione Primero el Departamento</option>
                                                                        
                                                                    </select>

                                                                    <label for="txtciudad">Ciudad de Residencia <span class="red-text">*</span></label>
                                                                    @error('txtciudad')
                                                                        <label id="txtciudad-error" class="error" for="txtciudad">{{ $message }}</label>
                                                                    @enderror 
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="input-field col s12 m6 l6">
                                                                    <i class="material-icons prefix">
                                                                        room
                                                                    </i>
                                                                    <input class="validate" id="txtbarrio" name="txtbarrio" type="text"  value="{{ isset($user->barrio) ? $user->barrio : old('txtbarrio', $user->barrio)}}">
                                                                    <label for="txtbarrio">Barrio <span class="red-text">*</span></label>
                                                                    @error('txtbarrio')
                                                                        <label id="txtbarrio-error" class="error" for="txtbarrio">{{ $message }}</label>
                                                                    @enderror
                                                                    
                                                                </div>
                                                                <div class="input-field col s12 m6 l6">
                                                                    <i class="material-icons prefix">
                                                                        room
                                                                    </i>
                                                                    <input class="validate" id="txtdireccion" name="txtdireccion" type="text"  value="{{ isset($user->direccion) ? $user->direccion : old('txtdireccion', $user->barrio)}}">
                                                                    <label for="txtdireccion">Dirección <span class="red-text">*</span></label>
                                                                    @error('txtdireccion')
                                                                        <label id="txtdireccion-error" class="error" for="txtdireccion">{{ $message }}</label>
                                                                    @enderror
                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="input-field col s12 m4 l4">
                                                                    <i class="material-icons prefix">
                                                                        mail_outline
                                                                    </i>
                                                                    <input class="validate" id="txtemail" name="txtemail" type="email" value="{{ isset($user->email) ? $user->email : old('txtemail', $user->email )}}">
                                                                    <label for="txtemail">Correo <span class="red-text">*</span></label>
                                                                    @error('txtemail')
                                                                        <label id="txtemail-error" class="error" for="txtemail">{{ $message }}</label>
                                                                    @enderror
                                                                </div>
                                                                <div class="input-field col s12 m4 l4">
                                                                    <i class="material-icons prefix">
                                                                        contact_phone
                                                                    </i>
                                                                    <input class="validate" id="txttelefono" name="txttelefono" type="tel" value="{{ isset($user->telefono) ? $user->telefono : old('txttelefono', $user->telefono )}}">
                                                                    <label for="txttelefono">Telefono</label>
                                                                    @error('txttelefono')
                                                                        <label id="txttelefono-error" class="error" for="txttelefono">{{ $message }}</label>
                                                                    @enderror
                                                                </div>
                                                                <div class="input-field col s12 m4 l4">
                                                                    <i class="material-icons prefix">
                                                                        settings_cell
                                                                    </i>
                                                                    <input class="validate" id="txtcelular" name="txtcelular" type="tel"  value="{{ isset($user->celular) ? $user->celular : old('txtcelular', $user->celular )}}">
                                                                    <label for="txtcelular">Celular</label>
                                                                    @error('txtcelular')
                                                                        <label id="txtcelular-error" class="error" for="txtcelular">{{ $message }}</label>
                                                                    @enderror 
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="divider mailbox-divider">
                                                    </div>
                                                    <div class="row">
                                                        <div class="col s12 m3 l3">
                                                            <blockquote>
                                                                <ul class="collection">
                                                                    <li class="collection-item">
                                                                        <span class="title"><b>Genero</b></span>
                                                                        <p>No puedes modificar el genero para hacerlo solicitelo mediante el link o acuda a las instalaciones del nodo más cercano.</p>
                                                                        
                                                                    </li>
                                                                </ul>
                                                            </blockquote>
                                                        </div>
                                                        <div class="col s12 m9 l9"><br>
                                                            <div class="row">
                                                                <div class="input-field col s12 m12 l12 offset-l5 m5 s5">
                                                                    <div class="switch m-b-md">
                                                                      <i class="material-icons prefix">wc</i>
                                                                      <label class="active">Genero*</label>
                                                                        <label>
                                                                            Masculino
                                                                            @if(isset($user->genero))
                                                                            <input type="checkbox" id="txtgenero" name="txtgenero" {{$user->genero != 1 ? 'checked' : old('txtgenero')}} disabled>
                                                                            @else
                                                                            <input type="checkbox" id="txtgenero" name="txtgenero" {{old('txtgenero') == 'on' ? 'checked' : ''}}>
                                                                            @endif
                                                                            <span class="lever"></span>
                                                                            Femenino
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- <div class="right">
                                                                <a class="waves-effect waves-teal darken-2 btn-flat m-t-xs">
                                                                    Solicitar actualización del genero
                                                                </a>
                                                            </div> --}}
                                                        </div>
                                                         
                                                    </div>
                                                    <div class="divider mailbox-divider"></div>
                                                    <div class="row">
                                                        <div class="col s12 m3 l3">
                                                            <blockquote>
                                                                <ul class="collection">
                                                                    <li class="collection-item">
                                                                        <span class="title"><b>Ocupaciones</b></span>
                                                                        <p>Puedes seleccionar varias ocupaciones si es el caso de que las tenga, sino seleccione una</p>
                                                                        
                                                                    </li>
                                                                </ul>
                                                            </blockquote>
                                                            <div class="row">
                                                            <div class="input-field col s12 m12 l12">
                                                                
                                                                <select class="js-states browser-default selectMultipe" id="txtocupaciones" name="txtocupaciones[]" style="width: 100%" tabindex="-1" multiple onchange="ocupacion.getOtraOcupacion(this)">
                                                                    
                                                                    @foreach($ocupaciones as $id => $nombre)
                                                                        
                                                                        <option value="{{$id}}" {{collect(old('txtocupaciones',$user->ocupaciones->pluck('id')))->contains($id) ? 'selected' : ''  }} >{{$nombre}}</option>
                                                                    
                                                                    @endforeach
                                                                </select>
                                                                <label for="txtocupaciones" class="active">Ocupación <span class="red-text">*</span></label>
                                                                @error('txtocupaciones')
                                                                    <label id="txtocupaciones-error" class="error" for="txtocupaciones">{{ $message }}</label>
                                                                @enderror
                                                            </div>
                                                            <div class="input-field col s12 m12 l12" id="otraocupacion">
                                                                <input class="validate" id="txtotra_ocupacion" name="txtotra_ocupacion" type="text"  value="{{ isset($user->otra_ocupacion) ? $user->otra_ocupacion : old('txtotra_ocupacion')}}">
                                                                <label for="txtotra_ocupacion" class="active">¿Cuál? <span class="red-text">*</span></label>
                                                                @error('txtotra_ocupacion')
                                                                    <label id="txtotra_ocupacion-error" class="error" for="txtotra_ocupacion">{{ $message }}</label>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        </div>
                                                        <div class="col s12 m9 l9"><br>
                                                            <div class="mailbox-view-header">
                                                            <div class="center">
                                                                <div class="center">
                                                                    <i class="Small material-icons prefix">
                                                                        supervised_user_circle
                                                                    </i>               
                                                                </div>
                                                                <div class="center">
                                                                    <span class="mailbox-title">Último estudio</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="divider mailbox-divider"></div>
                                                        <div class="row">
                                                            <div class="input-field col s12 m6 l6">
                                                                <i class="material-icons prefix">
                                                                    settings_cell
                                                                </i>
                                                                <input class="validate" id="txtinstitucion" name="txtinstitucion" type="text"  value="{{ isset($user->institucion) ? $user->institucion : old('txtinstitucion')}}">
                                                                <label for="txtinstitucion">Institución <span class="red-text">*</span></label>
                                                                @error('txtinstitucion')
                                                                    <label id="txtinstitucion-error" class="error" for="txtinstitucion">{{ $message }}</label>
                                                                @enderror 
                                                            </div>
                                                            <div class="input-field col s12 m6 l6 ">
                                                                <i class="material-icons prefix">
                                                                     details
                                                                </i>
                                                                <select class="" id="txtgrado_escolaridad" name="txtgrado_escolaridad" style="width: 100%" tabindex="-1">
                                                                    <option value="">Seleccione grado de escolaridad</option>
                                                                    @foreach($gradosescolaridad as $value)
                                                                        <option value="{{$value->id}}" {{old('txtgrado_escolaridad',$user->gradoescolaridad_id) ==$value->id ? 'selected':''}}>{{$value->nombre}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <label for="txtgrado_escolaridad">Grado Escolaridad <span class="red-text">*</span></label>
                                                                @error('txtgrado_escolaridad')
                                                                    <label id="txtgrado_escolaridad-error" class="error" for="txtgrado_escolaridad">{{ $message }}</label>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="input-field col s12 m6 l6">
                                                                <i class="material-icons prefix">
                                                                    settings_cell
                                                                </i>
                                                                <input class="validate" id="txttitulo" name="txttitulo" type="text"  value="{{ isset($user->titulo_obtenido) ? $user->titulo_obtenido : old('txttitulo')}}">
                                                                <label for="txttitulo">Titulo Obtenido <span class="red-text">*</span></label>
                                                                @error('txttitulo')
                                                                    <label id="txttitulo-error" class="error" for="txttitulo">{{ $message }}</label>
                                                                @enderror 
                                                            </div>
                                                            <div class="input-field col s12 m6 l6">
                                                                <i class="material-icons prefix">
                                                                    date_range
                                                                </i>
                                                                <input class="validate datepicker" id="txtfechaterminacion" name="txtfechaterminacion" type="text" value="{{ isset($user->fechanacimiento) ? $user->fechanacimiento->toDateString() : old('txtfechaterminacion')}}">
                                                                <label for="txtfechaterminacion">Fecha Terminación <span class="red-text">*</span></label>
                                                                @error('txtfechaterminacion')
                                                                    <label id="txtfechaterminacion-error" class="error" for="txtfechaterminacion">{{ $message }}</label>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="divider mailbox-divider"></div>
                                                        
                                                        </div>
                                                    </div>
                                                        
                                                    <div class="divider mailbox-divider">
                                                    </div>
                                                    <div class="right">
                                                        <button type="submit" class="waves-effect waves-teal darken-2 btn-flat m-t-xs">
                                                            Cambiar Información Personal
                                                        </button>
                                                        {{-- <a class="waves-effect waves-red btn-flat m-t-xs">
                                                            Eliminar Cuenta
                                                        </a>
                                                        <a class="waves-effect waves-red btn-flat m-t-xs">
                                                            Salir
                                                        </a> --}}
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
        </div>
    </div>
</main>
@endsection

@push('script')
<script>
$(document).ready(function() {
// UserAdmininstradorOcupacion.getOcupaciones();
    eps.getOtraEsp();
    ocupacion.getOtraOcupacion();
    UserAdministradorEdit.getCiudad();
    $('.selectMultipe').select2({
      language: "es",
    });
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
    


var eps = {
    getOtraEsp:function (ideps) {
        let id = $(ideps).val();
        let nombre = $("#txteps option:selected").text();
        if (nombre != '{{App\Models\Eps::OTRA_EPS }}') {
            $('#otraeps').hide();
             
        }else{
            console.log(nombre);
            $('#otraeps').show();
        }
        
        
    }
}

var UserAdministradorEdit = {
    getCiudad:function(){
      let id;
      id = $('#txtdepartamento').val();
      $.ajax({
        dataType:'json',
        type:'get',
        url:'/usuario/getciudad/'+id
      }).done(function(response){
       
        $('#txtciudad').empty();
        $('#txtciudad').append('<option value="">Seleccione la Ciudad</option>')
        $.each(response.ciudades, function(i, e) {
          // console.log(e.id);
          $('#txtciudad').append('<option  value="'+e.id+'">'+e.nombre+'</option>');
        })
        @if($errors->any())
        $('#txtciudad').val({{old('txtciudad')}});
        @else
        $('#txtciudad').val({{$user->ciudad->id}});
        @endif
        $('#txtciudad').material_select();
      });
    },
  }


</script>
@endpush
