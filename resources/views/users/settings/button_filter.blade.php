<div class="row">
    <div class="center input-field col s12 m4 l4">
        <a class="btn btn-outline-danger" href="{{$url}}">
            {{$message}}
         </a>
    </div>

   <div class="right mailbox-buttons">
    <span class="mailbox-title">
        <p class="center">
            <div class="right">
                <a class="waves-effect waves-light btn m-t-xs dropdown-button " data-activates="dropdown" href="#">
                    <i class="material-icons right">
                        more_vert
                    </i>
                    Descargar
                </a>
                <!-- Dropdown Structure -->
                <ul class="dropdown-content" id="dropdown">
                    @if(session()->has('login_role') && session()->get('login_role') == App\User::IsAdministrador())
                    <li>
                        <a onclick="{{$event}}" >Por nodo</a>
                    </li>
                        @if(!request()->is('usuario/talento'))
                            <li>
                                <a onclick="{{$eventAll}}">Todos</a>
                            </li>
                        @endif
                    @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsDinamizador() || session()->get('login_role') == App\User::IsInfocenter())
                        @if(request()->is('usuario/talento'))
                            <li>
                                <a onclick="{{$event}}">Descargar Talentos por año</a>
                            </li>
                        @else
                            <li>
                                <a onclick="{{$event}}">Descargar</a>
                            </li>
                        @endif
                    @else
                    <li>
                        <a onclick="{{$event}}">Desargar</a>
                    </li>
                    @endif


                </ul>
            </div>
        </p>
    </span>
</div>
</div>



