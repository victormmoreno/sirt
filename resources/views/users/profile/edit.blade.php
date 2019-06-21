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
                                        <div class="mailbox-options">
                                            <ul>
                                                <li>
                                                    <a href="{{{route('perfil.index',$user->documento)}}}">
                                                        Información Personal
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{{route('perfil.roles',$user->documento)}}}">
                                                        Roles
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{{route('perfil.permisos', $user->documento)}}}">
                                                        Permisos Adicionales
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="">
                                                        Cambiar Contraseña
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="mailbox-view">
                                            <div class="mailbox-view-header">
                                                <div class="left">
                                                    <div class="left">
                                                        <img alt="" class="circle mailbox-profile-image z-depth-1" src="{{ asset('img/profile-image-masculine.png') }}">
                                                        </img>
                                                    </div>
                                                    <div class="left">
                                                        <span class="mailbox-title">
                                                            {{auth()->check() ? auth()->user()->nombres.' '.auth()->user()->apellidos : ''}}
                                                        </span>
                                                        <span class="mailbox-author">
                                                            {{$user->getRoleNames()->implode(', ')}}
                                                            <br>
                                                                Miembro desde {{$user->created_at->isoFormat('LL')}}
                                                                <br>
                                                                    {{$user->fechanacimiento->age}} años
                                                                </br>
                                                            </br>
                                                        </span>
                                                    </div>
                                                </div>
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
                                                <form action="{{ route('perfil.edit',$user->id)}}" method="POST" onsubmit="return checkSubmit()">
                                                    {!! method_field('PUT')!!}
                                                        {!! csrf_field() !!}
                                                    <div class="row">
                                                        <div class="col s12 m3 l3">
                                                            <blockquote>
                                                                <ul class="collection">
                                                                    <li class="collection-item">
                                                                        Para agregar una idea de proyecto al entrenamiento solo debe buscarla y seleccionarla.
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
                                                                    <input id="txtdocumento" name="txtdocumento" type="text" value="{{ isset($user->documento) ? $user->documento : old('txtdocumento',$user->documento)}}">
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
                                                                                <option value="{{ $i }}"  {{old('txtestrato',$user->estrato) ==$i ? 'selected':''}}>{{$i}}</option> 
                                                                        @endfor
                                                                    </select>
                                                                    <label for="txtestrato">Estrato <span class="red-text">*</span></label>
                                                                    @error('txtestrato')
                                                                        <label id="txtestrato-error" class="error" for="txtestrato">{{ $message }}</label>
                                                                    @enderror 
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="divider mailbox-divider">
                                                    </div>
                                                    <div class="right">
                                                        <a class="waves-effect waves-teal darken-2 btn-flat m-t-xs">
                                                            Cambiar Información Personal
                                                        </a>
                                                        <a class="waves-effect waves-red btn-flat m-t-xs">
                                                            Delete
                                                        </a>
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
