
@if ($errors->any())
<div class="card red lighten-3">
    <div class="row">
        <div class="col s12 m12">
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
{!! csrf_field() !!}
<div class="row">
    <div class="col s12 m3 l3">
        <blockquote>
            <ul class="collection">
                <li class="collection-item">
                    <span class="title"><b>Configuración principal</b></span>
                    <p>Esta información aparecerá en el perfil del usuario</p>
                </li>
                <li class="collection-item">
                    <span class="title"><b>Nodo</b></span>
                    <p>Asigna un nodo al usuario</p>
                </li>
            </ul>
        </blockquote>
        <div class="col s12 m12 l12">
            <div class="input-field col s12 m12 l12">

                <select class="" id="txtnodo" name="txtnodo" onchange="UserGestorCreate.getLineasPorNodo()" style="width: 100%" tabindex="-1">
                    <option value="">Seleccione Nodo</option>

                    @foreach($nodos as $id => $nodo)
                        @if(isset($user->gestor->nodo->id))
                            <option value="{{$id}}" {{old('txtnodo',$user->gestor->nodo->id) ==  $id ? 'selected':''}}>{{$nodo}}</option> 
                        @else
                            <option value="{{$id}}" {{old('txtnodo') ==  $id ? 'selected':''}}>{{$nodo}}</option> 
                        @endif                        
                    @endforeach
                </select>
                <label for="txtnodo">Nodo <span class="red-text">*</span></label>
                @error('txtnodo')
                    <label id="txtnodo-error" class="error" for="txtnodo">{{ $message }}</label>
                @enderror
            </div>
        </div>
        <div class="col s12 m12 l12">
            <div class="input-field col s12 m12 l12">
                
                <select class="" id="txtlinea" name="txtlinea" style="width: 100%" tabindex="-1">
                    <option value="">Seleccione Primero el nodo</option>
                </select>
                <label for="txtlinea">Linea <span class="red-text">*</span></label>
                @error('txtlinea')
                    <label id="txtlinea-error" class="error" for="txtlinea">{{ $message }}</label>
                @enderror
            </div>
        </div>
        <div class="col s12 m12 l12">
            <div class="input-field col s12 m12 l12">
            
                <input id="txthonorario" name="txthonorario" type="text" value="{{ isset($user->gestor->honorarios) ? $user->gestor->honorarios : old('txthonorario')}}">
                <label for="txthonorario">Honorario <span class="red-text">*</span></label>
                <small>ingrese el valor separado por puntos (.)</small> 
                @error('txthonorario')
                    <label id="txthonorario-error" class="error" for="txthonorario">{{ $message }}</label>
                @enderror
            </div> 
        </div>
        <div class="col s12 m12 l12">
            <ul class="collection with-header">
                <li class="collection-header center"><h6><b>Roles</b></h6></li>
                @forelse($roles as $role)
                    <li class="collection-item">
                        <p class="p-v-xs">
                            <input class="roles" type="checkbox" name="role" value="{{$role}}" id="test-{{$role}}">
                            <label for="test-{{$role}}">{{$role}}</label>
                        </p>
                    </li>
                @empty
                <p>No tienes roles asignados</p>
                @endforelse
            </ul>
        </div>
    </div>
    <div class="col s12 m9 l9">
        <div class="divider mailbox-divider"></div>
        <div class="mailbox-text">
           
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
        <input class="validate" id="txtnombres" name="txtnombres" type="text"  value="{{ isset($user->nombres) ? $user->nombres : old('txtnombres')}}">
        <label for="txtnombres">Nombres <span class="red-text">*</span></label>
        @error('txtnombres')
            <label id="txtnombres-error" class="error" for="txtnombres">{{ $message }}</label>
        @enderror
    </div>
    <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">
            account_circle
        </i>
        <input class="validate" id="txtapellidos" name="txtapellidos" type="text" value="{{ isset($user->apellidos) ? $user->apellidos : old('txtapellidos')}}">
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
        <input class="validate datepicker" id="txtfecha_nacimiento" name="txtfecha_nacimiento" type="text" value="{{ isset($user->fechanacimiento) ? $user->fechanacimiento->toDateString() : old('txtfecha_nacimiento')}}">
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
                @if(isset($user->eps_id))
                    <option value="{{$value->id}}" {{old('txteps',$user->eps_id) ==  $value->id ? 'selected':''}}>{{$value->nombre}}</option> 
                @else
                    <option value="{{$value->id}}" {{old('txteps') == $value->id  ? 'selected':''}}>{{$value->nombre}}</option> 
                @endif
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
        <input class="validate" id="txtotraeps" name="txtotraeps" type="text" value="{{ isset($user->otra_eps) ? $user->otra_eps : old('txtotraeps')}}">
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
                @if(isset($user->estrato))
                    <option value="{{ $i }}"  {{old('txtestrato',$user->estrato) ==$i ? 'selected':''}}>{{$i}}</option> 
                @else
                    <option value="{{ $i }}"  {{old('txtestrato') == $i ? 'selected':''}}>{{$i}}</option>
                @endif 
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
        @if(isset($user->ciudad->departamento->id))
        <select class="" id="txtdepartamento" name="txtdepartamento" onchange="UserGestorEdit.getCiudad()" style="width: 100%" tabindex="-1">
            <option value="">Seleccione departamento</option>
            @foreach($departamentos as $value)
                @if(isset($user->ciudad->departamento->id))
                    <option value="{{$value->id}}" {{old('txtdepartamento',$user->ciudad->departamento->id) ==  $value->id ? 'selected':''}}>{{$value->nombre}}</option> 
                @else
                    <option value="{{$value->id}}" {{old('txtdepartamento') == $value->id  ? 'selected':''}}>{{$value->nombre}}</option> 
                @endif
            @endforeach
        </select>
        @else
        <select class="" id="txtdepartamento" name="txtdepartamento" onchange="UserGestorCreate.getCiudad()" style="width: 100%" tabindex="-1">
            <option value="">Seleccione departamento</option>
            @foreach($departamentos as $value)
                @if(isset($user->ciudad->departamento->id))
                    <option value="{{$value->id}}" {{old('txtdepartamento',$user->ciudad->departamento->id) ==  $value->id ? 'selected':''}}>{{$value->nombre}}</option> 
                @else
                    <option value="{{$value->id}}" {{old('txtdepartamento') == $value->id  ? 'selected':''}}>{{$value->nombre}}</option> 
                @endif
            @endforeach
        </select>
        @endif
        <label for="txtdepartamento">Departamento de Residencia <span class="red-text">*</span></label>
        @error('txtdepartamento')
            <label id="txtdepartamento-error" class="error" for="txtdepartamento">{{ $message }}</label>
        @enderror 
    </div>
 
    <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">
            details
        </i>
        @if(isset($user->ciudad_id))
        <select class="" id="txtciudad" name="txtciudad" style="width: 100%" tabindex="-1">
            <option value="">Seleccione Primero el Departamento</option>
            
        </select>
        @else
        <select class="" id="txtciudad" name="txtciudad" style="width: 100%" tabindex="-1">
            <option value="">Seleccione Primero el Departamento</option> 
        </select>
        @endif
        
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
        <input class="validate" id="txtbarrio" name="txtbarrio" type="text"  value="{{ isset($user->barrio) ? $user->barrio : old('txtbarrio')}}">
        <label for="txtbarrio">Barrio <span class="red-text">*</span></label>
        @error('txtbarrio')
            <label id="txtbarrio-error" class="error" for="txtbarrio">{{ $message }}</label>
        @enderror
        
    </div>
    <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">
            room
        </i>
        <input class="validate" id="txtdireccion" name="txtdireccion" type="text"  value="{{ isset($user->direccion) ? $user->direccion : old('txtdireccion')}}">
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
        <input class="validate" id="txtemail" name="txtemail" type="email" value="{{ isset($user->email) ? $user->email : old('txtemail')}}">
        <label for="txtemail">Correo <span class="red-text">*</span></label>
        @error('txtemail')
            <label id="txtemail-error" class="error" for="txtemail">{{ $message }}</label>
        @enderror
    </div>
    <div class="input-field col s12 m4 l4">
        <i class="material-icons prefix">
            contact_phone
        </i>
        <input class="validate" id="txttelefono" name="txttelefono" type="tel" value="{{ isset($user->telefono) ? $user->telefono : old('txttelefono')}}">
        <label for="txttelefono">Telefono</label>
        @error('txttelefono')
            <label id="txttelefono-error" class="error" for="txttelefono">{{ $message }}</label>
        @enderror
    </div>
    <div class="input-field col s12 m4 l4">
        <i class="material-icons prefix">
            settings_cell
        </i>
        <input class="validate" id="txtcelular" name="txtcelular" type="tel"  value="{{ isset($user->celular) ? $user->celular : old('txtcelular')}}">
        <label for="txtcelular">Celular</label>
        @error('txtcelular')
            <label id="txtcelular-error" class="error" for="txtcelular">{{ $message }}</label>
        @enderror 
    </div>
</div>
<div class="row">

    <div class="input-field col s12 m12 l12 offset-l5 m5 s5">
        <div class="switch m-b-md">
          <i class="material-icons prefix">wc</i>
          <label class="active">Genero*</label>
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
<div class="divider mailbox-divider"></div>
<div class="mailbox-view-header">
    <div class="center">
        <div class="center">
            <i class="Small material-icons prefix">
                supervised_user_circle
            </i>               
        </div>
        <div class="center">
            <span class="mailbox-title">Otros</span>
        </div>
    </div>
</div>
<div class="divider mailbox-divider"></div>
<div class="row">
    <div class="input-field col s12 m6 l6 offset-l3 m3 s3">
        <i class="material-icons prefix">
             details
        </i>
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
        @error('txtgrado_escolaridad')
            <label id="txtgrado_escolaridad-error" class="error" for="txtgrado_escolaridad">{{ $message }}</label>
        @enderror
    </div>
</div>
{{-- {{var_dump(old('txtocupaciones'))}} --}}

<div class="divider mailbox-divider"></div>
<div class="row">
    <div class="input-field col s12 m6 l6 offset-l3 m3 s3">
        {{-- <i class="material-icons prefix">
             details
        </i> --}}
        <select class="js-states browser-default selectMultipe" id="txtocupaciones" name="txtocupaciones[]" style="width: 100%" tabindex="-1" multiple>
            <option value="">Seleccione ocupación</option>
            @foreach($ocupaciones as $id => $nombre)
                @if(isset($user))
                <option value="{{$id}}" {{collect(old('txtocupaciones',$user->ocupaciones->pluck('id')))->contains($id) ? 'selected' : ''  }} >{{$nombre}}</option>
                @else
                    <option {{collect(old('txtocupaciones'))->contains($id) ? 'selected' : ''  }}  value="{{$id}}" >{{$nombre}}</option>
                @endif

            
            @endforeach
        </select>
        <label for="txtocupaciones" class="active">Ocupación <span class="red-text">*</span></label>
        @error('txtocupaciones')
            <label id="txtocupaciones-error" class="error" for="txtocupaciones">{{ $message }}</label>
        @enderror
    </div>
</div>
<div class="divider mailbox-divider"></div>
<br>
<center>
    <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done_all</i>{{isset($btnText) ? $btnText : 'Guardar'}}</button> 
    <a class="waves-effect red lighten-2 btn center-aling" href="">
        <i class="material-icons right">
            backspace
        </i>
        Cancelar
    </a>
</center>
        </div>
    </div>
</div>                             

    </div>
</div>

        

                                    