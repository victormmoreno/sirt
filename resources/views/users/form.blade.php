
{!! csrf_field() !!}


<div class="row">
    <div class="col s12 m4 l3">
        <blockquote>
            <ul class="collection">
                <li class="collection-item">
                    <span class="title"><b>Configuración principal</b></span>
                    <p>Esta información aparecerá en el perfil del usuario</p>
                </li>
                @if(session()->has('login_role') && session()->get('login_role') == App\User::IsAdministrador() )
                <li class="collection-item">
                    <span class="title"><b>Dinamizadores</b></span>
                    <p>Sólo se permite un dinamizador por nodo, tenga cuidado si desea asignar un dinamizador a un nodo que ya lo tiene, este último perderá ese rol</p>
                </li>
                @endif
                <li class="collection-item">
                    <span class="title"><b>Roles</b></span>
                    <p>Puedes Asignar más roles al usuario</p>
                </li>
            </ul>
        </blockquote>

        @include('users.role.role')

        <div id="dinamizador">
            <div class="input-field col s12 m12 l12">
                <select class="js-states browser-default select2 select2-hidden-accessible" id="txtnododinamizador" name="txtnododinamizador" style="width: 100%; display: none
                " tabindex="-1" >
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
                <label for="txtnododinamizador" class="active">Nodo Dinamizador<span class="red-text">*</span></label>
                <small id="role-error" class="error red-text"></small>
            </div>
        </div>
        <div id="gestor">
            <div class="input-field col s12 m12 l12">
                <select class="js-states browser-default select2 select2-hidden-accessible" id="txtnodogestor" name="txtnodogestor" onchange="linea.getSelectLineaForNodo()" style="width: 100%" tabindex="-1">


                        @if(session()->has('login_role') && session()->get('login_role') == App\User::IsAdministrador())
                            <option value="">Seleccione Nodo</option>
                            @foreach($nodos as $id => $nodo)
                                @if(isset($user->dinamizador->nodo->id) && (collect($user->roles)->contains('name',App\User::IsExperto()) || collect($user->roles)->contains('name',App\User::IsArticulador())))
                                    <option value="{{$id}}" {{old('txtnodogestor',$user->dinamizador->nodo->id) ==  $id ? 'selected':''}} >{{$nodo}}</option>
                                @else
                                    <option value="{{$id}}" {{old('txtnodogestor') ==  $id ? 'selected':''}}>{{$nodo}}</option>
                                @endif
                            @endforeach
                        @endif

                        @if(isset($user->gestor->nodo->id) && session()->has('login_role') &&  (collect($user->roles)->contains('name',App\User::IsExperto()) || collect($user->roles)->contains('name',App\User::IsArticulador())))
                        <option value="{{$user->gestor->nodo->id}}" selected="">Tecnoparque Nodo {{$user->gestor->nodo->entidad->nombre}}</option>

                        @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id))
                            <option value="">Seleccione Nodo</option>
                             <option value="{{auth()->user()->dinamizador->nodo->id}}">Tecnoparque Nodo {{auth()->user()->dinamizador->nodo->entidad->nombre}}</option>
                        @endif

                </select>
                <label for="txtnodogestor" class="active">Nodo del experto<span class="red-text">*</span></label>
                <small id="txtnodogestor-error" class="error red-text"></small>
            </div>
            <div class="input-field col s12 m12 l12">
                <select class="js-states browser-default select2 select2-hidden-accessible" id="txtlinea" name="txtlinea" style="width: 100%" tabindex="-1">
                    @if(isset($user->gestor->lineatecnologica->id) && (session()->get('login_role') == App\User::IsExperto() || session()->get('login_role') == App\User::IsArticulador()) && (collect($user->roles)->contains('name',App\User::IsExperto()) || collect($user->roles)->contains('name',App\User::IsArticulador())))

                    <option value="{{$user->gestor->lineatecnologica->id}}" selected>{{$user->gestor->lineatecnologica->nombre}}</option>
                    @else
                        @foreach($lineas as $id => $linea)
                            @if(isset($user->gestor->lineatecnologica->id) && (collect($user->roles)->contains('name',App\User::IsExperto()) || collect($user->roles)->contains('name',App\User::IsArticulador())))
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
                <i class="material-icons prefix">
                    attach_money
                </i>
                <input id="txthonorario" name="txthonorario" type="text" value="{{ isset($user->gestor->honorarios) ? $user->gestor->honorarios : old('txthonorario')}}" {{ isset($user->gestor->honorarios) && session()->get('login_role') == App\User::IsExperto() ||   (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id)  && isset($user->gestor->nodo->id ) && $user->gestor->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : ''}}>
                <label for="txthonorario">Honorario <span class="red-text">*</span></label>
                <small id="txthonorario-error" class="error red-text"></small>
            </div>
        </div>
        <div id="infocenter">
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
                        @if(isset($user->infocenter->nodo->id) && session()->has('login_role') && session()->get('login_role') == App\User::IsExperto())

                             <option selected value="{{$user->infocenter->nodo->id}}">Tecnoparque Nodo {{$user->infocenter->nodo->entidad->nombre}}</option>
                        @endif

                </select>
                <label for="txtnodoinfocenter" class="active">Nodo Infocenter<span class="red-text">*</span></label>

                <small id="txtnodoinfocenter-error" class="error red-text"></small>
            </div>
        </div>
        <div id="ingreso">
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
                <label for="txtnodoingreso" class="active">Nodo Ingreso<span class="red-text">*</span></label>
                <small id="txtnodoingreso-error" class="error red-text"></small>
            </div>
        </div>

    </div>
    <div class="col s12 m8 l9">
        <div class="divider mailbox-divider"></div>

        @include('users.forms.infopersonal')
        @include('users.forms.estudios')

        @if(  isset($user->talento->tipotalento) && collect($user->roles)->contains('name',App\User::IsTalento()) && $view == 'edit' && session()->has('login_role') && session()->get('login_role') != App\User::IsExperto())


            @include('users.forms.tipo_talento')


        @elseif(session()->get('login_role') == App\User::IsExperto())

            @include('users.forms.tipo_talento')

        @endif
        <div class="col s12 center-align m-t-sm">
            <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done_all</i>{{isset($btnText) ? $btnText : 'Guardar'}}</button>
            <a class="waves-effect red lighten-2 btn center-aling " href="{{route('usuario.index')}}">
                <i class="material-icons right">
                    backspace
                </i>
                Cancelar
            </a>
        </div>
    </div>
</div>




