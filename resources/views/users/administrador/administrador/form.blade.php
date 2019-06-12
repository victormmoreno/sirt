
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
        <label for="txtcelular">Tipo Documento *</label>
        @error('txttipo_documento')
            <label id="txttipo_documento-error" class="error" for="txttipo_documento">{{ $message }}</label>
        @enderror
    </div>
    <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">
            assignment_ind
        </i>
        <input id="txtdocumento" name="txtdocumento" type="text" value="{{ isset($user->documento) ? $user->documento : old('txtdocumento')}}">
        <label for="txtdocumento">Documento *</label> 
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
        <label for="txtnombres">Nombres *</label>
        @error('txtnombres')
            <label id="txtnombres-error" class="error" for="txtnombres">{{ $message }}</label>
        @enderror
    </div>
    <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">
            account_circle
        </i>
        <input class="validate" id="txtapellidos" name="txtapellidos" type="text" value="{{ isset($user->apellidos) ? $user->apellidos : old('txtapellidos')}}">
        <label for="txtapellidos">Apellidos *</label>
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
        <label for="txtfecha_nacimiento">Fecha de Nacimiento *</label>
        @error('txtfecha_nacimiento')
            <label id="txtfecha_nacimiento-error" class="error" for="txtfecha_nacimiento">{{ $message }}</label>
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
        <label for="txtestrato">Estrato *</label>
        @error('txtestrato')
            <label id="txtestrato-error" class="error" for="txtestrato">{{ $message }}</label>
        @enderror 
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">
            mail_outline
        </i>
        <input class="validate" id="txtemail" name="txtemail" type="email" value="{{ isset($user->email) ? $user->email : old('txtemail')}}">
        <label for="txtemail">Correo *</label>
        @error('txtemail')
            <label id="txtemail-error" class="error" for="txtemail">{{ $message }}</label>
        @enderror
    </div>
    <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">
            room
        </i>
        <input class="validate" id="txtdireccion" name="txtdireccion" type="text"  value="{{ isset($user->direccion) ? $user->direccion : old('txtdireccion')}}">
        <label for="txtdireccion">Dirección *</label>
        @error('txtdireccion')
            <label id="txtdireccion-error" class="error" for="txtdireccion">{{ $message }}</label>
        @enderror
        
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">
            contact_phone
        </i>
        <input class="validate" id="txttelefono" name="txttelefono" type="tel" value="{{ isset($user->telefono) ? $user->telefono : old('txttelefono')}}">
        <label for="txttelefono">Telefono</label>
        @error('txttelefono')
            <label id="txttelefono-error" class="error" for="txttelefono">{{ $message }}</label>
        @enderror
    </div>
    <div class="input-field col s12 m6 l6">
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
                <input type="checkbox" id="txtgenero" name="txtgenero" {{isset($user->genero) == 1 ? 'checked' : ''}}>
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
        <label for="txtgrado_escolaridad">Grado Escolaridad*</label>
        @error('txtgrado_escolaridad')
            <label id="txtgrado_escolaridad-error" class="error" for="txtgrado_escolaridad">{{ $message }}</label>
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


                                    