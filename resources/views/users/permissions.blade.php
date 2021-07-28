@extends('layouts.app')

@section('meta-title', 'Usuario | ' . $user->present()->userFullName())

@section('content')

<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row no-m-t no-m-b">
                    <div class="col s8 m8 l9">
                        <h5 class="left-align hand-of-Sean-fonts orange-text text-darken-3">
                            <a class="footer-text left-align" href="{{route('usuario.usuarios.show', $user->present()->userDocumento())}}">
                                <i class="material-icons arrow-l">arrow_back</i>
                            </a>Usuarios
                        </h5>
                    </div>
                    <div class="col s4 m4 l3 rigth-align show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li>
                                <a href="{{route('home')}}">
                                    Inicio
                                </a>
                            </li>
                            <li>
                                <a href="{{route('usuario.index')}}">
                                    Usuarios
                                </a>
                            </li>
                            <li class="active">
                                Permisos
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="card mailbox-content">
                    <div class="card-content">
                        <div class="row no-m-t no-m-b">
                            <div class="col s12 m12 l12">
                                <div class="mailbox-view">
                                    <div class="mailbox-view-header">
                                        <div class="left mailbox-buttons">
                                            {!!$user->present()->userProfileUserImage()!!}
                                        </div>
                                        <div class="left">
                                            <p class="m-t-lg flow-text">{{$user->present()->userFullName()}}</p>
                                            <span class="mailbox-title">{{$user->present()->userYearOld()}}</span>
                                            @foreach($user->getRoleNames() as $value)
                                            <div class="chip m-t-sm blue-grey white-text"> {{$value}}</div>
                                            @endforeach
                                            <div class="position-top-right p f-12 mail-date show-on-large hide-on-med-and-down">Miembro desde {{$user->present()->userCreatedAtFormat()}}</div>
                                        </div>
                                    </div>
                                    <div class="divider mailbox-divider"></div>
                                    <div class="mailbox-text">
                                        <form id="FormChangeNodo" action="{{ route('usuario.usuarios.updatenodo', $user->documento)}}" method="POST" onsubmit="return checkSubmit()">
                                            {!! csrf_field() !!}
                                            {!! method_field('PUT')!!}
                                            <div class="row">

                                                <div class="col s12 m3 l3">
                                                    <div class="col s12 m12 l12">
                                                        @forelse($roles as  $name)
                                                            <p class="p-v-xs">
                                                                @switch( \Session::get('login_role'))
                                                                    @case(App\User::IsAdministrador())
                                                                        @if(isset($user))
                                                                            <input class="filled-in" type="checkbox" name="role[]" {{collect(old('role',$user->roles->pluck('name')))->contains($name) ? 'checked' : ''  }}  value="{{$name}}" id="test-{{$name}}" onchange="roles.getRoleSeleted(this)">
                                                                        @else
                                                                            <input class="filled-in" type="checkbox" name="role[]" {{collect(old('role'))->contains($name) ? 'checked' : ''  }}  value="{{$name}}" id="test-{{$name}}" onchange="roles.getRoleSeleted(this)">
                                                                        @endif
                                                                    @break
                                                                    @case(App\User::IsDinamizador())
                                                                        @if(isset($user))
                                                                            <input type="checkbox" name="role[]"  {{collect(old('role',$user->roles->pluck('name')))->contains($name) ? 'checked' : ''  }}  {{$name == App\User::IsAdministrador() ? 'onclick=this.checked=!this.checked;' : ($name == App\User::IsDinamizador() ? 'onclick=this.checked=!this.checked;' : '' )}} value="{{$name}}" id="test-{{$name}}" onchange="roles.getRoleSeleted(this)">
                                                                        @else
                                                                            <input type="checkbox" name="role[]" {{collect(old('role'))->contains($name) ? 'checked' : ''  }}  value="{{$name}}" id="test-{{$name}}" {{$name == App\User::IsAdministrador() ? 'onclick=this.checked=!this.checked;' : ($name == App\User::IsDinamizador() ? 'onclick=this.checked=!this.checked;' : '' )}} onchange="roles.getRoleSeleted(this)">
                                                                        @endif
                                                                    @break
                                                                    @case(App\User::IsGestor())
                                                                        @if(isset($user))
                                                                            <input type="checkbox" name="role[]"  {{collect(old('role',$user->roles->pluck('name')))->contains($name) ? 'checked' : ''  }}  {{$name != App\User::IsTalento() ? 'onclick=this.checked=!this.checked;': '' }} value="{{$name}}" id="test-{{$name}}" onchange="roles.getRoleSeleted(this)">
                                                                        @else
                                                                            <input type="checkbox" name="role[]" {{collect(old('role'))->contains($name) ? 'checked' : ''  }}  value="{{$name}}" id="test-{{$name}}" {{$name != App\User::IsTalento() ? 'onclick=this.checked=!this.checked;' : '' }} onchange="roles.getRoleSeleted(this)">
                                                                        @endif
                                                                    @case(App\User::IsArticulador())
                                                                        @if(isset($user))
                                                                            <input type="checkbox" name="role[]"  {{collect(old('role',$user->roles->pluck('name')))->contains($name) ? 'checked' : ''  }}  {{$name != App\User::IsTalento() ? 'onclick=this.checked=!this.checked;': '' }} value="{{$name}}" id="test-{{$name}}" onchange="roles.getRoleSeleted(this)">
                                                                        @else
                                                                            <input type="checkbox" name="role[]" {{collect(old('role'))->contains($name) ? 'checked' : ''  }}  value="{{$name}}" id="test-{{$name}}" {{$name != App\User::IsTalento() ? 'onclick=this.checked=!this.checked;' : '' }} onchange="roles.getRoleSeleted(this)">
                                                                        @endif
                                                                    @break
                                                                    @default
                                                                    @break
                                                                @endswitch

                                                                <label for="test-{{$name}}">{{$name}}</label>
                                                            </p>
                                                        @empty
                                                            <p class="p-v-xs">No tienes roles asignados</p>
                                                        @endforelse
                                                        @error('role')
                                                            <div class="center">
                                                                <label class="red-text error">{{ $message }}</label>
                                                            </div>
                                                        @enderror
                                                        <small id="role-error" class="error red-text"></small>
                                                    </div>
                                                </div>
                                                <div class="col s12 m9 l9 ">
                                                    @if(session()->has('status') || session()->has('error'))
                                                        <div class="center">
                                                            <div class="card  {{session('status') ? 'green': ''}} {{session('error') ? 'red': ''}}  darken-1">
                                                                <div class="row">
                                                                    <div class="col s12 m10">
                                                                        <div class="card-content white-text">
                                                                            <p>
                                                                                <i class="material-icons left">info_outline</i>
                                                                                {{session('status') ? : session('error')}}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    @endif
                                                    <div class="row">
                                                        <div class="input-field col s12 m12 l12 valign-wrapper selectRole" style="display:block">
                                                            <h5><- Selecciona los roles</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div id="section-user_apoyo" class="input-field col s12 m12 l6 offset-l3">
                                                            <div  class="card mailbox-content">
                                                                <div class="card-content">
                                                                    <span class=" card-title activator grey-text text-darken-4 center-align">Información {{App\User::IsApoyoTecnico()}}</span>
                                                                    <div class="input-field col s12 m12 l12">
                                                                        <select class="js-states browser-default select2 select2-hidden-accessible" id="txtnodouser" name="txtnodouser"  style="width: 100%" tabindex="-1">
                                                                            @if(session()->has('login_role') && session()->get('login_role') == App\User::IsAdministrador())

                                                                                <option value="">Seleccione Nodo</option>
                                                                                @foreach($nodos as $id => $nodo)
                                                                                    @if(isset($user->apoyotecnico->nodo->id) && collect($user->roles)->contains('name',App\User::IsApoyoTecnico()))
                                                                                        <option value="{{$id}}" {{old('txtnodouser',$user->apoyotecnico->nodo->id) ==  $id ? 'selected':''}} >{{$nodo}}</option>
                                                                                    @else
                                                                                        <option value="{{$id}}" {{old('txtnodouser') ==  $id ? 'selected':''}}>{{$nodo}}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            @endif
                                                                            @if(isset($user->apoyotecnico->nodo->id) && session()->has('login_role') &&  collect($user->roles)->contains('name',App\User::IsApoyoTecnico()))
                                                                                <option value="{{$user->apoyotecnico->nodo->id}}" selected="">Tecnoparque Nodo {{$user->apoyotecnico->nodo->entidad->nombre}}</option>
                                                                            @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id))
                                                                                <option value="">Seleccione Nodo</option>
                                                                                <option value="{{auth()->user()->dinamizador->nodo->id}}">Tecnoparque Nodo {{auth()->user()->dinamizador->nodo->entidad->nombre}}</option>
                                                                            @endif
                                                                        </select>
                                                                        <label for="txtnodouser" class="active">Nodo <span class="red-text">*</span></label>
                                                                        <small id="txtnodouser-error" class="error red-text"></small>
                                                                    </div>
                                                                    <div class="input-field col s12 m12 l12">
                                                                        <input id="txthonorariouser" name="txthonorariouser" type="text" value="{{ isset($user->apoyotecnico->honorarios) ? $user->apoyotecnico->honorarios : old('txthonorario')}}" {{ isset($user->apoyotecnico->honorarios) && session()->get('login_role') == App\User::IsGestor() ||   (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id)  && isset($user->apoyotecnico->nodo->id ) && $user->apoyotecnico->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : ''}}>
                                                                        <label for="txthonorariouser">Honorario mensual <span class="red-text">*</span></label>
                                                                        <small id="txthonorariouser-error" class="error red-text"></small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="section-articulador" class="input-field col s12 m12 l6 offset-l3">
                                                            <div  class="card mailbox-content">
                                                                <div class="card-content">
                                                                    <span class=" card-title activator grey-text text-darken-4 center-align">Información {{App\User::IsArticulador()}}</span>
                                                                    <div class="input-field col s12 m12 l12">
                                                                        <select class="js-states browser-default select2 select2-hidden-accessible" id="txtnodoarticulador" name="txtnodoarticulador"  style="width: 100%" tabindex="-1">
                                                                            @if(session()->has('login_role') && session()->get('login_role') == App\User::IsAdministrador())
                                                                                <option value="">Seleccione Nodo</option>
                                                                                @foreach($nodos as $id => $nodo)
                                                                                    @if(isset($user->articulador->nodo->id) && collect($user->roles)->contains('name',App\User::IsGestor()))
                                                                                        <option value="{{$id}}" {{old('txtnodoarticulador',$user->articulador->nodo->id) ==  $id ? 'selected':''}} >{{$nodo}}</option>
                                                                                    @else
                                                                                        <option value="{{$id}}" {{old('txtnodoarticulador') ==  $id ? 'selected':''}}>{{$nodo}}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            @endif
                                                                            @if(isset($user->articulador->nodo->id) && session()->has('login_role') &&  collect($user->roles)->contains('name',App\User::IsArticulador()))
                                                                            <option value="{{$user->articulador->nodo->id}}" selected="">Tecnoparque Nodo {{$user->articulador->nodo->entidad->nombre}}</option>
                                                                            @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id))
                                                                                <option value="">Seleccione Nodo</option>
                                                                                <option value="{{auth()->user()->dinamizador->nodo->id}}">Tecnoparque Nodo {{auth()->user()->dinamizador->nodo->entidad->nombre}}</option>
                                                                            @endif
                                                                        </select>
                                                                        <label for="txtnodoarticulador" class="active">Nodo <span class="red-text">*</span></label>
                                                                        <small id="txtnodoarticulador-error" class="error red-text"></small>
                                                                    </div>
                                                                    <div class="input-field col s12 m12 l12">
                                                                        <input id="txthonorarioarticulador" name="txthonorarioarticulador" type="text" value="{{ isset($user->articulador->honorarios) ? $user->articulador->honorarios : old('txthonorarioarticulador')}}" {{ isset($user->gestor->honorarios) && session()->get('login_role') == App\User::IsGestor() ||   (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id)  && isset($user->gestor->nodo->id ) && $user->gestor->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : ''}}>
                                                                        <label for="txthonorarioarticulador">Honorario mensual <span class="red-text">*</span></label>
                                                                        <small id="txthonorarioarticulador-error" class="error red-text"></small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="section-dinamizador" class="input-field col s12 m12 l6 offset-l3">
                                                            <div  class="card mailbox-content">
                                                                <div class="card-content">
                                                                    <span class="card-title activator grey-text text-darken-4 center-align">Información Dinamizador</span>
                                                                    <div class="input-field col s12 m12 l12">
                                                                        <select class="js-states browser-default select2 select2-hidden-accessible" id="txtnododinamizador" name="txtnododinamizador" style="width: 100%; display: none
                                                                        " tabindex="-1">
                                                                            @if(session()->has('login_role') && session()->get('login_role') == App\User::IsAdministrador())
                                                                                <option value="">Seleccione Nodo</option>
                                                                                @foreach($nodos as $id => $nodo)
                                                                                    @if(isset($user->dinamizador->nodo->id) && collect($user->roles)->contains('name',App\User::IsDinamizador()))
                                                                                        <option value="{{$id}}" {{old('txtnododinamizador',$user->dinamizador->nodo->id) ==  $id ? 'selected':''}} >{{$nodo}}</option>
                                                                                    @else
                                                                                        <option value="{{$id}}" {{old('txtnododinamizador') ==  $id ? 'selected':''}}>{{$nodo}}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            @else
                                                                                @if(isset($user->dinamizador->nodo->id) && collect($user->roles)->contains('name',App\User::IsDinamizador()))
                                                                                    <option value="{{$user->dinamizador->nodo->id}}" selected>Tecnoparque Nodo {{$user->dinamizador->nodo->entidad->nombre}}</option>
                                                                                @endif
                                                                            @endif
                                                                        </select>
                                                                        <label for="txtnododinamizador" class="active">Nodo <span class="red-text">*</span></label>
                                                                        <small id="txtnododinamizador-error" class="error red-text"></small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="section-gestor" class="input-field col s12 m12 l6 offset-l3">
                                                            <div  class="card mailbox-content">
                                                                <div class="card-content">
                                                                    <span class=" card-title activator grey-text text-darken-4 center-align">Información {{App\User::IsGestor()}}</span>
                                                                    <div class="input-field col s12 m12 l12">
                                                                        <select class="js-states browser-default select2 select2-hidden-accessible" id="txtnodogestor" name="txtnodogestor" onchange="linea.getSelectLineaForNodo()" style="width: 100%" tabindex="-1">
                                                                            @if(session()->has('login_role') && session()->get('login_role') == App\User::IsAdministrador())
                                                                                <option value="">Seleccione Nodo</option>
                                                                                @foreach($nodos as $id => $nodo)
                                                                                    @if(isset($user->dinamizador->nodo->id) && collect($user->roles)->contains('name',App\User::IsGestor()))
                                                                                        <option value="{{$id}}" {{old('txtnodogestor',$user->dinamizador->nodo->id) ==  $id ? 'selected':''}} >{{$nodo}}</option>
                                                                                    @else
                                                                                        <option value="{{$id}}" {{old('txtnodogestor') ==  $id ? 'selected':''}}>{{$nodo}}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            @endif
                                                                            @if(isset($user->gestor->nodo->id) && session()->has('login_role') &&  collect($user->roles)->contains('name',App\User::IsGestor()))
                                                                            <option value="{{$user->gestor->nodo->id}}" selected="">Tecnoparque Nodo {{$user->gestor->nodo->entidad->nombre}}</option>
                                                                            @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id))
                                                                                <option value="">Seleccione Nodo</option>
                                                                                <option value="{{auth()->user()->dinamizador->nodo->id}}">Tecnoparque Nodo {{auth()->user()->dinamizador->nodo->entidad->nombre}}</option>
                                                                            @endif
                                                                        </select>
                                                                        <label for="txtnodogestor" class="active">Nodo Gestor<span class="red-text">*</span></label>
                                                                        <small id="txtnodogestor-error" class="error red-text"></small>
                                                                    </div>
                                                                    <div class="input-field col s12 m12 l12 linea">
                                                                        <select class="js-states browser-default select2" id="txtlinea" name="txtlinea" style="width: 100%" tabindex="-1">
                                                                            @if(isset($user->gestor->lineatecnologica->id) && session()->get('login_role') == App\User::IsGestor() && collect($user->roles)->contains('name',App\User::IsGestor()))
                                                                            <option value="{{$user->gestor->lineatecnologica->id}}" selected>{{$user->gestor->lineatecnologica->nombre}}</option>
                                                                            @else
                                                                                @foreach($lineas as $id => $linea)
                                                                                    @if(isset($user->gestor->lineatecnologica->id) && collect($user->roles)->contains('name',App\User::IsGestor()))
                                                                                        <option value="{{$id}}" {{old('txtlinea',$user->gestor->lineatecnologica->id) ==  $id ? 'selected':''}} >{{$linea}}</option>
                                                                                    @else
                                                                                        <option value="{{$id}}" {{old('txtlinea') ==  $id ? 'selected':''}}>{{$linea}}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                        <label for="txtlinea" class="active">Linea <span class="red-text">*</span></label>
                                                                        <small id="txtlinea-error" class="error red-text"></small>
                                                                    </div>
                                                                    <div class="input-field col s12 m12 l12">
                                                                        <input id="txthonorario" name="txthonorario" type="text" value="{{ isset($user->gestor->honorarios) ? $user->gestor->honorarios : old('txthonorario')}}" {{ isset($user->gestor->honorarios) && session()->get('login_role') == App\User::IsGestor() ||   (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id)  && isset($user->gestor->nodo->id ) && $user->gestor->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : ''}}>
                                                                        <label for="txthonorario">Honorario mensual <span class="red-text">*</span></label>
                                                                        <small id="txthonorario-error" class="error red-text"></small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="section-infocenter" class="input-field col s12 m12 l6 offset-l3">
                                                            <div  class="card mailbox-content">
                                                                <div class="card-content">
                                                                    <span class="card-title activator grey-text text-darken-4 center-align">Información Infocenter</span>
                                                                    <div class="input-field col s12 m12 l12">
                                                                        <select class="js-states browser-default select2 select2-hidden-accessible" id="txtnodoinfocenter" name="txtnodoinfocenter"  style="width: 100%" tabindex="-1">
                                                                                @if(session()->has('login_role') && session()->get('login_role') == App\User::IsAdministrador())
                                                                                    <option value="">Seleccione Nodo</option>
                                                                                    @foreach($nodos as $id => $nodo)
                                                                                        @if(isset($user->infocenter) && collect($user->roles)->contains('name',App\User::IsInfocenter()))
                                                                                            <option value="{{$id}}" {{old('txtnodoinfocenter',$user->infocenter->nodo->id) ==  $id ? 'selected':''}} >{{$nodo}}</option>
                                                                                        @else
                                                                                            <option value="{{$id}}" {{old('txtnodoinfocenter') ==  $id ? 'selected':''}}>{{$nodo}}</option>
                                                                                        @endif
                                                                                    @endforeach
                                                                                @endif
                                                                                @if(isset($user) && session()->has('login_role') && session()->get('login_role') == App\User::IsDinamizador() && collect($user->roles)->contains('name',App\User::Isinfocenter()))
                                                                                <option selected value="{{$user->infocenter->nodo->id}}">Tecnoparque Nodo {{$user->infocenter->nodo->entidad->nombre}}</option>
                                                                                @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id))
                                                                                    <option value="">Seleccione Nodo</option>
                                                                                    <option value="{{auth()->user()->dinamizador->nodo->id}}">Tecnoparque Nodo {{auth()->user()->dinamizador->nodo->entidad->nombre}}</option>
                                                                                @endif
                                                                                @if(isset($user->infocenter->nodo->id) && session()->has('login_role') && session()->get('login_role') == App\User::IsGestor())
                                                                                    <option selected value="{{$user->infocenter->nodo->id}}">Tecnoparque Nodo {{$user->infocenter->nodo->entidad->nombre}}</option>
                                                                                @endif
                                                                        </select>
                                                                        <label for="txtnodoinfocenter" class="active">Nodo Infocenter<span class="red-text">*</span></label>

                                                                        <small id="txtnodoinfocenter-error" class="error red-text"></small>
                                                                    </div>
                                                                    <div class="input-field col s12 m12 l12">
                                                                        <input id="txtextension" name="txtextension" type="text" value="{{ isset($user->infocenter->extension) && collect($user->roles)->contains('name',App\User::IsInfocenter()) ? $user->infocenter->extension : old('txtextension')}}" {{isset($user->infocenter->extension) && session()->get('login_role') == App\User::IsGestor() ||    (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->gestor->nodo->id ) &&   $user->gestor->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : ''}}>
                                                                        <label for="txtextension">Extensión <span class="red-text">*</span></label>
                                                                        <small id="txtextension-error" class="error red-text"></small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="section-ingreso" class="input-field col s12 m12 l6 offset-l3">
                                                            <div  class="card mailbox-content">
                                                                <div class="card-content">
                                                                    <span class="card-title activator grey-text text-darken-4 center-align">Información Ingreso</span>
                                                                    <div class="input-field col s12 m12 l12">
                                                                        <select class="js-states browser-default select2 select2-hidden-accessible"  id="txtnodoingreso" name="txtnodoingreso"  style="width: 100%" tabindex="-1">
                                                                            @if(session()->has('login_role') && session()->get('login_role') == App\User::IsAdministrador())
                                                                                <option value="">Seleccione Nodo</option>
                                                                                @foreach($nodos as $id => $nodo)
                                                                                    @if(isset($user->dinamizador->nodo->id) && collect($user->roles)->contains('name',App\User::IsIngreso()))
                                                                                        <option value="{{$id}}" {{old('txtnodoingreso',$user->dinamizador->nodo->id) ==  $id ? 'selected':''}} >{{$nodo}}</option>
                                                                                    @else
                                                                                        <option value="{{$id}}" {{old('txtnodoingreso') ==  $id ? 'selected':''}}>{{$nodo}}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            @endif
                                                                            @if(isset($user->ingreso->nodo) && collect($user->roles)->contains('name',App\User::IsIngreso()))
                                                                            <option selected value="{{$user->ingreso->nodo->id}}">Tecnoparque Nodo {{$user->ingreso->nodo->entidad->nombre}}</option>
                                                                            @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id))
                                                                                <option value="{{auth()->user()->dinamizador->nodo->id}}">Tecnoparque Nodo {{auth()->user()->dinamizador->nodo->entidad->nombre}}</option>
                                                                            @endif
                                                                        </select>
                                                                        <label for="txtnodoingreso" class="active">Nodo<span class="red-text">*</span></label>
                                                                        <small id="txtnodoingreso-error" class="error red-text"></small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="section-talento" class="row">
                                                            <div class="input-field col s12 m12 l6 offset-l3">
                                                                <div  class="card mailbox-content">
                                                                    <div class="card-content">
                                                                        <span class="card-title activator grey-text text-darken-4 center-align">Información {{App\User::IsTalento()}}</span>
                                                                        <div class="input-field col s12 m12 l12">
                                                                            <select class="js-states browser-default select2 select2-hidden-accessible" id="txttipotalento" name="txttipotalento" style="width: 100%" tabindex="-1" onchange="tipoTalento.getSelectTipoTalento(this)">
                                                                                <option value="">Seleccione tipo de talento</option>
                                                                                @foreach($tipotalentos as $id => $nombre)
                                                                                    @if(isset($user->talento->tipotalento->id))
                                                                                    <option value="{{$id}}" {{old('txttipotalento',$user->talento->tipotalento->id) ==$id ? 'selected':''}}>{{$nombre}}</option>
                                                                                    @else
                                                                                        <option value="{{$id}}" {{old('txttipotalento') ==$id ? 'selected':''}}>{{$nombre}}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                            <label for="txttipotalento" class="active">Tipo Talento <span class="red-text">*</span></label>
                                                                            <small id="txttipotalento-error"  class="error red-text"></small>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row aprendizSena" style="display:none">
                                                                <div class="input-field input-field col s12 m12 l6 offset-l3"  >
                                                                    <select class=" js-states browser-default select2 select2-hidden-accessible" id="txtregional_aprendiz" name="txtregional_aprendiz" style="width: 100%" tabindex="-1" onchange="tipoTalento.getCentroFormacionAprendiz()">
                                                                        <option value="">Seleccione regional</option>
                                                                        @foreach($regionales as $id => $nombre)
                                                                            @if(isset($user->talento->entidad->centro->regional->id))
                                                                                <option value="{{$id}}" {{old('txtregional_aprendiz',$user->talento->entidad->centro->regional->id) ==$id ? 'selected':''}}>{{$nombre}}</option>
                                                                            @else
                                                                                <option value="{{$id}}" {{old('txtregional_aprendiz') ==$id ? 'selected':''}}>{{$nombre}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                    <label for="txtregional_aprendiz" class="active">Regional <span class="red-text">*</span></label>
                                                                    <small id="txtregional_aprendiz-error"  class="error red-text"></small>
                                                                </div>
                                                                <div class="input-field input-field col s12 m12 l6 offset-l3">
                                                                    <select class="js-states browser-default select2 select2-hidden-accessible" id="txtcentroformacion_aprendiz" name="txtcentroformacion_aprendiz" style="width: 100%" tabindex="-1" >
                                                                        <option value="">Seleccione Primero la regional</option>
                                                                    </select>
                                                                    <label for="txtcentroformacion_aprendiz" class="active">Centro de formación <span class="red-text">*</span></label>
                                                                    <small id="txtcentroformacion_aprendiz-error"  class="error red-text"></small>
                                                                </div>
                                                                <div class="input-field input-field col s12 m12 l6 offset-l3 ">
                                                                    <input class="validate" id="txtprogramaformacion_aprendiz" name="txtprogramaformacion_aprendiz" type="text"  value="{{ isset($user->talento->programa_formacion) ? $user->talento->programa_formacion : old('txtprogramaformacion_aprendiz')}}">
                                                                    <label for="txtprogramaformacion_aprendiz">Programa de Formación <span class="red-text">*</span></label>
                                                                    <small id="txtprogramaformacion_aprendiz-error"  class="error red-text"></small>
                                                                </div>
                                                            </div>
                                                            <div class="row egresadoSena" style="display:none">
                                                                <div class="input-field input-field col s12 m12 l6 offset-l3" >
                                                                    <select class=" js-states browser-default select2 select2-hidden-accessible" id="txtregional_egresado" name="txtregional_egresado" style="width: 100%" tabindex="-1" onchange="tipoTalento.getCentroFormacionEgresadoSena()">
                                                                        <option value="">Seleccione regional</option>
                                                                        @foreach($regionales as $id => $nombre)
                                                                            @if(isset($user->talento->entidad->centro->regional->id))
                                                                                <option value="{{$id}}" {{old('txtregional_egresado',$user->talento->entidad->centro->regional->id) ==$id ? 'selected':''}}>{{$nombre}}</option>
                                                                            @else
                                                                                <option value="{{$id}}" {{old('txtregional_egresado') ==$id ? 'selected':''}}>{{$nombre}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                    <label for="txtregional_egresado" class="active">Regional <span class="red-text">*</span></label>
                                                                    <small id="txtregional_egresado-error"  class="error red-text"></small>
                                                                </div>
                                                                <div class="input-field input-field col s12 m12 l6 offset-l3">
                                                                    <select class="js-states browser-default select2 select2-hidden-accessible" id="txtcentroformacion_egresado" name="txtcentroformacion_egresado" style="width: 100%" tabindex="-1" >
                                                                        <option value="">Seleccione Primero la regional</option>
                                                                    </select>
                                                                    <label for="txtcentroformacion_egresado" class="active">Centro de formación <span class="red-text">*</span></label>
                                                                    <small id="txtcentroformacion_egresado-error"  class="error red-text"></small>
                                                                </div>
                                                                <div class="input-field input-field col s12 m12 l6 offset-l3 ">
                                                                    <input class="validate" id="txtprogramaformacion_egresado" name="txtprogramaformacion_egresado" type="text"  value="{{ isset($user->talento->programa_formacion) ? $user->talento->programa_formacion : old('txtprogramaformacion_egresado')}}">
                                                                    <label for="txtprogramaformacion_egresado">Programa de Formación <span class="red-text">*</span></label>
                                                                    <small id="txtprogramaformacion_egresado-error"  class="error red-text"></small>
                                                                </div>
                                                                <div class="input-field input-field col s12 m12 l6 offset-l3 ">
                                                                    <select class="" id="txttipoformacion" name="txttipoformacion" style="width: 100%" tabindex="-1">
                                                                        <option value="">Seleccione Tipo Formación</option>
                                                                        @foreach($tipoformaciones as $id => $nombre)
                                                                            @if(isset($user->talento->tipoformacion->id))
                                                                                <option value="{{$id}}" {{old('txttipoformacion',$user->talento->tipoformacion->id) ==$id ? 'selected':''}}>{{$nombre}}</option>
                                                                            @else
                                                                            <option value="{{$id}}" {{old('txttipoformacion') ==$id ? 'selected':''}}>{{$nombre}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                    <label for="txttipoformacion">Tipo Formación <span class="red-text">*</span></label>
                                                                    <small id="txttipoformacion-error"  class="error red-text"></small>
                                                                </div>
                                                            </div>
                                                            <div class="row funcionarioSena" style="display:none">
                                                                <div class="input-field input-field col s12 m12 l6 offset-l3" >
                                                                    <select class=" js-states browser-default select2 select2-hidden-accessible" id="txtregional_funcionarioSena" name="txtregional_funcionarioSena" style="width: 100%" tabindex="-1" onchange="tipoTalento.getCentroFormacionFuncionarioSena()">
                                                                        <option value="">Seleccione regional</option>
                                                                        @foreach($regionales as $id => $nombre)
                                                                            @if(isset($user->talento->entidad->centro->regional->id))
                                                                                <option value="{{$id}}" {{old('txtregional_funcionarioSena',$user->talento->entidad->centro->regional->id) ==$id ? 'selected':''}}>{{$nombre}}</option>
                                                                            @else
                                                                                <option value="{{$id}}" {{old('txtregional_funcionarioSena') ==$id ? 'selected':''}}>{{$nombre}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                    <label for="txtregional_funcionarioSena" class="active">Regional <span class="red-text">*</span></label>
                                                                    <small id="txtregional_funcionarioSena-error"  class="error red-text"></small>
                                                                </div>
                                                                <div class="input-field input-field col s12 m12 l6 offset-l3">
                                                                    <select class="js-states browser-default select2 select2-hidden-accessible" id="txtcentroformacion_funcionarioSena" name="txtcentroformacion_funcionarioSena" style="width: 100%" tabindex="-1" >
                                                                        <option value="">Seleccione Primero la regional</option>
                                                                    </select>
                                                                    <label for="txtcentroformacion_funcionarioSena" class="active">Centro de formación <span class="red-text">*</span></label>
                                                                    <small id="txtcentroformacion_funcionarioSena-error"  class="error red-text"></small>
                                                                </div>
                                                                <div class="input-field input-field col s12 m12 l6 offset-l3">
                                                                    <input class="validate" id="txtdependencia" name="txtdependencia" type="text"  value="{{ isset($user->talento->dependencia) ? $user->talento->dependencia : old('txtdependencia')}}">
                                                                    <label for="txtdependencia">Dependencia</label>
                                                                    <small id="txtdependencia-error"  class="error red-text"></small>
                                                                </div>
                                                            </div>
                                                            <div class="row instructorSena" style="display:none">
                                                                <div class="input-field col s12 m12 l6 offset-l3" >
                                                                    <select class=" js-states browser-default select2 select2-hidden-accessible" id="txtregional_instructorSena" name="txtregional_instructorSena" style="width: 100%" tabindex="-1" onchange="tipoTalento.getCentroFormacionInstructorSena()">
                                                                        <option value="">Seleccione regional</option>
                                                                        @foreach($regionales as $id => $nombre)
                                                                            @if(isset($user->talento->entidad->centro->regional->id))
                                                                                <option value="{{$id}}" {{old('txtregional_instructorSena',$user->talento->entidad->centro->regional->id) ==$id ? 'selected':''}}>{{$nombre}}</option>
                                                                            @else
                                                                                <option value="{{$id}}" {{old('txtregional_instructorSena') ==$id ? 'selected':''}}>{{$nombre}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                    <label for="txtregional_instructorSena" class="active">Regional <span class="red-text">*</span></label>
                                                                    <small id="txtregional_instructorSena-error"  class="error red-text"></small>
                                                                </div>
                                                                <div class="input-field col s12 m12 l6 offset-l3">
                                                                    <select class="js-states browser-default select2 select2-hidden-accessible" id="txtcentroformacion_instructorSena" name="txtcentroformacion_instructorSena" style="width: 100%" tabindex="-1">
                                                                        <option value="">Seleccione Primero la regional</option>
                                                                    </select>
                                                                    <label for="txtcentroformacion_instructorSena" class="active">Centro de formación <span class="red-text">*</span></label>
                                                                    <small id="txtcentroformacion_instructorSena-error"  class="error red-text"></small>
                                                                </div>
                                                            </div>

                                                            <div class="row universitario" style="display:none">
                                                                <div class="input-field col s12 m12 l6 offset-l3" >
                                                                    <select class="" id="txttipoestudio" name="txttipoestudio" style="width: 100%" tabindex="-1" >
                                                                            <option value="">Seleccione Tipo Estudio</option>
                                                                            @foreach($tipoestudios as $id => $nombre)
                                                                                @if(isset($user->talento->tipoestudio->id))
                                                                                <option value="{{$id}}" {{old('txttipoestudio',$user->talento->tipoestudio->id) ==$id ? 'selected':''}}>{{$nombre}}</option>
                                                                                @else
                                                                                    <option value="{{$id}}" {{old('txttipoestudio') ==$id ? 'selected':''}}>{{$nombre}}</option>
                                                                                @endif
                                                                            @endforeach
                                                                    </select>
                                                                    <label for="txttipoestudio">Tipo Estudio <span class="red-text">*</span></label>
                                                                    <small id="txttipoestudio-error"  class="error red-text"></small>
                                                                </div>
                                                                <div class="input-field col s12 m12 l6 offset-l3" >
                                                                    <input class="validate" id="txtuniversidad" name="txtuniversidad" type="text"  value="{{ isset($user->talento->universidad) ? $user->talento->universidad : old('txtuniversidad')}}">
                                                                    <label for="txtuniversidad">Universidad <span class="red-text">*</span></label>
                                                                    <small id="txtuniversidad-error"  class="error red-text"></small>
                                                                </div>
                                                                <div class="input-field col s12 m12 l6 offset-l3" >
                                                                    <input class="validate" id="txtcarrera" name="txtcarrera" type="text"  value="{{ isset($user->talento->carrera_universitaria) ? $user->talento->carrera_universitaria : old('txtcarrera')}}">
                                                                    <label for="txtcarrera">Nombre de la Carrera <span class="red-text">*</span></label>
                                                                    <small id="txtcarrera-error"  class="error red-text"></small>
                                                                </div>
                                                            </div>
                                                            <div class="row funcionarioEmpresa" style="display:none">
                                                                <div class="input-field col s12 m12 l6 offset-l3" >
                                                                    <input class="validate" id="txtempresa" name="txtempresa" type="text"  value="{{ isset($user->talento->empresa) ? $user->talento->empresa : old('txtempresa')}}">
                                                                    <label for="txtempresa">Nombre de la Empresa <span class="red-text">*</span></label>
                                                                    <small id="txtempresa-error"  class="error red-text"></small>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col s12 m8 l8 offset-l4 offset-m4">
                                                    <div class="divider mailbox-divider m-b-5">
                                                    </div>
                                                    <div class="center">
                                                        <button type="submit" class="waves-effect waves-teal darken-2 btn-flat m-t-xs">
                                                            Guardar cambios
                                                        </button>
                                                        <a href="{{route('home')}}" class="waves-effect waves-red btn-flat m-t-xs">
                                                            cancelar
                                                        </a>
                                                    </div>
                                                </div>
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
        roles.getRoleSeleted();
        @if(isset($user->talento->tipotalento->id))
            tipoTalento.getSelectTipoTalento('{{$user->talento->tipotalento->id}}');
        @endif
        @if(isset($user->talento->entidad))
            tipoTalento.getCentroFormacionAprendiz();
            tipoTalento.getCentroFormacionEgresadoSena();
            tipoTalento.getCentroFormacionFuncionarioSena();
            tipoTalento.getCentroFormacionInstructorSena();
        @endif
        @if(isset($user->gestor->nodo->lineas->id))
            linea.getSelectLineaForNodo();
        @endif
    });

    var roles = {
        getRoleSeleted:function (idrol) {
            $('#section-user_apoyo').hide();
            $('#section-articulador').hide();
            $('#section-dinamizador').hide();
            $('#section-gestor').hide();
            $('#section-infocenter').hide();
            $('#section-talento').hide();
            $('#section-ingreso').hide();
            $("input[type=checkbox]:checked").each(function(){
                if ($(this).val() == '{{App\User::IsAdministrador()}}') {
                    roles.hideSelectRole();
                }else if ($(this).val() == '{{App\User::IsApoyoTecnico()}}') {
                    roles.hideSelectRole();
                    $('#section-user_apoyo').show();
                }
                else if($(this).val() == '{{App\User::IsArticulador()}}'){
                    roles.hideSelectRole();
                    $('#section-articulador').show();
                }else if ($(this).val() == '{{App\User::IsDinamizador()}}') {
                    roles.hideSelectRole();
                    $('#section-dinamizador').show();
                }else if($(this).val() == '{{App\User::IsGestor()}}' ){
                    roles.hideSelectRole();
                    $('#section-gestor').show();
                }else if($(this).val() == '{{App\User::IsInfocenter()}}'){
                    roles.hideSelectRole();
                    $('#section-infocenter').show();
                }else if($(this).val() == '{{App\User::IsTalento()}}'){
                    roles.hideSelectRole();
                    $('#section-talento').show();
                }else if($(this).val() == '{{App\User::IsIngreso()}}'){
                    roles.hideSelectRole();
                    $('#section-ingreso').show();
                }else{
                    roles.showSelectRole();
                }
            });

            if($('#section-user_apoyo').css('display') === 'block')
            {
                @if($errors->any())
                    $("#txtnodouser").val("{{old('txtnodouser')}}");
                @else
                    $("#txtnodouser").val();
                @endif
                $("#txtnodouser").material_select();
            }

            if($('#section-dinamizador').css('display') === 'block')
            {
                @if($errors->any())
                    $("#txtnododinamizador").val("{{old('txtnododinamizador')}}");
                @else
                $("#txtnododinamizador").val();
                @endif
                $("#txtnododinamizador").material_select();
            }

            if ($('#section-gestor').css('display') === 'block') {
                @if($errors->any())
                    $('#txtnodogestor').val("{{old('txtnodogestor')}}");
                    $('#txtlinea').val("{{old('txtlinea')}}");
                    $("#txthonorario").val("{{old('txthonorario')}}");
                @else
                    $("#txtnodogestor").val();
                    $("#txtlinea").val();
                    $("#txthonorario").val();
                @endif
                $("#txtnodogestor").material_select();
                $("#txtlinea").material_select();
            }
            if ($('#section-infocenter').css('display') === 'block') {
                @if($errors->any())
                    $('#txtnodoinfocenter').val("{{old('txtnodoinfocenter')}}");
                    $('#txtextension').val("{{old('txtextension')}}");
                @else
                    $("#txtnodoinfocenter").val();
                    $("#txtextension").val();
                @endif
                $("#txtnodoinfocenter").material_select();
            }
            if($('#section-ingreso').css('display') === 'block')
            {
                @if($errors->any())
                    $("#txtnodoingreso").val("{{old('txtnodoingreso')}}");
                @else
                    $("#txtnodoingreso").val();
                @endif
                $("#txtnodoingreso").material_select();
            }
            if ($('#section-talento').css('display') === 'block') {
                $("#txtperfil").val();
                $("#txtperfil").material_select();
                $("#txtregional").val();
                $("#txtregional").material_select();
                $("#txtcentroformacion").val();
                $("#txtcentroformacion").material_select();
                $("#txtuniversidad").val();
                $("#txtempresa").val();
                $("#txtotrotipotalento").val();
                $("#txtgrupoinvestigacion").val();
                $('.aprendizSena').hide();
                $('.estudianteUniversitario').hide();
                $('#funcionarioEmpresa').hide();
                $('#otroTipoTalento').hide();
                $('.investigador').hide();
            }
        },
        hideSelectRole: function(){
            $(".selectRole").css("display", "none");
        },
        showSelectRole: function(){
            $(".selectRole").css("display", "block");
        }
    };
    var linea = {
        getSelectLineaForNodo:function(){
            let nodo = $('#txtnodogestor').val();
            $.ajax({
                dataType:'json',
                type:'get',
                url:'/lineas/getlineasnodo/'+nodo
            }).done(function(response){
                $('#txtlinea').empty();
                if (response.lineasForNodo.lineas == '') {
                    $('#txtlinea').append('<option value="">No hay lineas disponibles</option>');
                }else{
                    $('#txtlinea').append('<option value="">Seleccione la linea</option>');
                    $.each(response.lineasForNodo.lineas, function(i, e) {
                        $('#txtlinea').append('<option  value="'+e.id+'">'+e.nombre+'</option>');
                        @if(isset($user->gestor))
                            $('#txtlinea').select2('val','{{$user->gestor->lineatecnologica_id}}');
                        @endif
                    });
                    @if($errors->any())
                        $('#txtlinea').val("{{old('txtlinea')}}");
                    @endif
                }
                $('#txtlinea').material_select();
            });
        },
    }
    var tipoTalento = {
        getSelectTipoTalento:function (idtipotalento) {
            let valor = $(idtipotalento).val();
            let nombretipotalento = $("#txttipotalento option:selected").text();
            if((nombretipotalento == '{{App\Models\TipoTalento::IS_APRENDIZ_SENA_CON_APOYO }}' ||
                nombretipotalento == '{{App\Models\TipoTalento::IS_APRENDIZ_SENA_SIN_APOYO }}') ){
                tipoTalento.showAprendizSena();
            }else if(nombretipotalento == '{{App\Models\TipoTalento::IS_EGRESADO_SENA }}' ){
                tipoTalento.showEgresadoSena();
            }
            else if(nombretipotalento == '{{App\Models\TipoTalento::IS_INSTRUCTOR_SENA }}' ){
                tipoTalento.showInstructorSena();
            }
            else if(nombretipotalento == '{{App\Models\TipoTalento::IS_FUNCIONARIO_SENA }}'){
                tipoTalento.showFuncionarioSena();
            }
            else if(nombretipotalento == '{{App\Models\TipoTalento::IS_PROPIETARIO_EMPRESA }}'){
                tipoTalento.showPropietarioEmpresa();
            }
            else if(nombretipotalento == '{{App\Models\TipoTalento::IS_EMPRENDEDOR }}'){
                tipoTalento.showEmprendedor();
            }
            else if(nombretipotalento == '{{App\Models\TipoTalento::IS_ESTUDIANTE_UNIVERSITARIO }}'){
                tipoTalento.showUniversitario();
            }
            else if(nombretipotalento == '{{App\Models\TipoTalento::IS_FUNCIONARIO_EMPRESA }}' ){
                tipoTalento.showFuncionarioEmpresa();
            }
            else{
                tipoTalento.ShowSelectTipoTalento();
            }
        },
        showAprendizSena: function(){
            tipoTalento.hideSelectTipoTalento();
            tipoTalento.hideEgresadoSena();
            tipoTalento.hideInstructorSena();
            tipoTalento.hideFuncionarioSena();

            tipoTalento.hideUniversitario();
            tipoTalento.hideFuncionarioEmpresa();
            $(".aprendizSena").css("display", "block");
        },
        showEgresadoSena: function(){
            tipoTalento.hideSelectTipoTalento();
            tipoTalento.hideAprendizSena();
            tipoTalento.hideInstructorSena();
            tipoTalento.hideFuncionarioSena();

            tipoTalento.hideUniversitario();
            tipoTalento.hideFuncionarioEmpresa();
            $(".egresadoSena").css("display", "block");
            $(".egresadoSena").show();

        },
        showInstructorSena: function(){
            tipoTalento.hideSelectTipoTalento();
            tipoTalento.hideAprendizSena();
            tipoTalento.hideEgresadoSena();
            tipoTalento.hideFuncionarioSena();
            tipoTalento.hideFuncionarioSena();
            tipoTalento.hideUniversitario();
            tipoTalento.hideFuncionarioEmpresa();
            $(".instructorSena").css("display", "block");
        },
        showFuncionarioSena: function(){
            tipoTalento.hideSelectTipoTalento();
            tipoTalento.hideAprendizSena();
            tipoTalento.hideEgresadoSena();
            tipoTalento.hideInstructorSena();
            tipoTalento.hideFuncionarioSena();
            tipoTalento.hideUniversitario();
            tipoTalento.hideFuncionarioEmpresa();
            $(".funcionarioSena").css("display", "block");
        },
        showPropietarioEmpresa: function (){
            tipoTalento.hideSelectTipoTalento();
            tipoTalento.hideAprendizSena();
            tipoTalento.hideEgresadoSena();
            tipoTalento.hideInstructorSena();
            tipoTalento.hideFuncionarioSena();
            tipoTalento.hideUniversitario();
            tipoTalento.hideFuncionarioEmpresa();
        },
        showEmprendedor: function (){
            tipoTalento.hideSelectTipoTalento();
            tipoTalento.hideAprendizSena();
            tipoTalento.hideEgresadoSena();
            tipoTalento.hideInstructorSena();
            tipoTalento.hideFuncionarioSena();
            tipoTalento.hideUniversitario();
            tipoTalento.hideFuncionarioEmpresa();
        },
        showUniversitario: function(){
            tipoTalento.hideSelectTipoTalento();
            tipoTalento.hideAprendizSena();
            tipoTalento.hideEgresadoSena();
            tipoTalento.hideInstructorSena();
            tipoTalento.hideFuncionarioSena();
            tipoTalento.hideFuncionarioEmpresa();
            $(".universitario").css("display", "block");
        },
        showFuncionarioEmpresa: function(){
            tipoTalento.hideSelectTipoTalento();
            tipoTalento.hideAprendizSena();
            tipoTalento.hideEgresadoSena();
            tipoTalento.hideInstructorSena();
            tipoTalento.hideFuncionarioSena();
            tipoTalento.hideUniversitario();
            $(".funcionarioEmpresa").css("display", "block");
        },
        hideAprendizSena: function(){
            $(".aprendizSena").css("display", "none");
        },
        hideEgresadoSena: function(){
            $(".egresadoSena").hide();
        },
        hideInstructorSena: function(){
            $(".instructorSena").css("display", "none");
        },
        hideFuncionarioSena: function(){
            $(".funcionarioSena").css("display", "none");
        },
        hideSelectTipoTalento: function(){
            $(".selecttipotalento").css("display", "none");
        },
        hideUniversitario: function(){
            $(".universitario").css("display", "none");
        },
        hideFuncionarioEmpresa: function(){
            $(".funcionarioEmpresa").css("display", "none");
        },
        ShowSelectTipoTalento: function(){
            tipoTalento.hideAprendizSena();
            $(".selecttipotalento").css("display", "block");
        },
        getCentroFormacionAprendiz:function (){
            let regional = $('#txtregional_aprendiz').val();
            $.ajax({
                dataType:'json',
                type:'get',
                url:'/centro-formacion/getcentrosregional/'+regional
            }).done(function(response){
                $('#txtcentroformacion_aprendiz').empty();
                @if(isset($user->talento->entidad) && collect($user->roles)->contains('name',App\User::IsTalento()) &&  session()->get('login_role') != App\User::IsGestor())
                    $('#txtcentroformacion_aprendiz').append(`<option value=`+'{{$user->talento->entidad->id}}'+`>`+'{{$user->talento->entidad->nombre}}'+`</option>`);
                    @if(isset($user->talento->entidad))
                        $('#txtcentroformacion_aprendiz').select2('val','{{$user->talento->entidad->id}}');
                    @endif
                @else
                $('#txtcentroformacion_aprendiz').append('<option value="">Seleccione el centro de formación</option>')
                $.each(response.centros, function(id, nombre) {
                    $('#txtcentroformacion_aprendiz').append('<option  value="'+id+'">'+nombre+'</option>');
                    @if(isset($user->talento->entidad))
                        $('#txtcentroformacion_aprendiz').select2('val','{{$user->talento->entidad->id}}');
                    @endif
                    $('#txtcentroformacion_aprendiz').material_select();
                });
                @endif
            });
        },
        getCentroFormacionEgresadoSena:function (){
            let regional = $('#txtregional_egresado').val();
            $.ajax({
                dataType:'json',
                type:'get',
                url:'/centro-formacion/getcentrosregional/'+regional
            }).done(function(response){
                $('#txtcentroformacion_egresado').empty();
                $('#txtcentroformacion_egresado').append('<option value="">Seleccione el centro de formación</option>')
                $.each(response.centros, function(id, nombre) {
                    $('#txtcentroformacion_egresado').append('<option  value="'+id+'">'+nombre+'</option>');
                    @if(isset($user->talento->entidad))
                        $('#txtcentroformacion_egresado').select2('val','{{$user->talento->entidad->id}}');
                        @endif
                    $('#txtcentroformacion_egresado').material_select();
                });
            });
        },
        getCentroFormacionFuncionarioSena:function (){
            let regional = $('#txtregional_funcionarioSena').val();
            $.ajax({
                dataType:'json',
                type:'get',
                url:'/centro-formacion/getcentrosregional/'+regional
            }).done(function(response){
                $('#txtcentroformacion_funcionarioSena').empty();
                $('#txtcentroformacion_funcionarioSena').append('<option value="">Seleccione el centro de formación</option>')
                $.each(response.centros, function(id, nombre) {
                    $('#txtcentroformacion_funcionarioSena').append('<option  value="'+id+'">'+nombre+'</option>');
                    @if(isset($user->talento->entidad))
                        $('#txtcentroformacion_funcionarioSena').select2('val','{{$user->talento->entidad->id}}');
                        @endif
                    $('#txtcentroformacion_funcionarioSena').material_select();
                });
            });
        },
        getCentroFormacionInstructorSena:function (){
            let regional = $('#txtregional_instructorSena').val();
            $.ajax({
                dataType:'json',
                type:'get',
                url:'/centro-formacion/getcentrosregional/'+regional
            }).done(function(response){
                $('#txtcentroformacion_instructorSena').empty();
                $('#txtcentroformacion_instructorSena').append('<option value="">Seleccione el centro de formación</option>')
                $.each(response.centros, function(id, nombre) {
                    $('#txtcentroformacion_instructorSena').append('<option value="'+id+'">'+nombre+'</option>');
                    @if(isset($user->talento->entidad))
                        $('#txtcentroformacion_instructorSena').select2('val','{{$user->talento->entidad->id}}');
                    @endif
                    $('#txtcentroformacion_instructorSena').material_select();
                });
            });
        },
    }
</script>
@endpush
